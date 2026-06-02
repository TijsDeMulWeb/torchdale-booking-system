<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $orderInfo = $request->input();
        $customerInput = $request->input('customer');

        $customer = $this->matchOrCreateCustomer($request->escaperoom, $customerInput, $request->ip());

        if ($customer->banned_at) {
            return response()->json(['success' => false, 'message' => 'Customer isn\'t allowed to place an order.'], 403);
        }

        $items = $request->input('items', []);

        if (empty($items)) {
            return response()->json(['success' => false, 'message' => 'No items provided.'], 422);
        }

        $total = 0;
        $subtotal = 0;
        $discount = 0;
        $vatTotal = 0;
        $leftToPay = 0;
        $roomPrice = null;

        foreach ($items as $item) {
            if (empty($item['type'])) {
                return response()->json(['success' => false, 'message' => 'Each item must have a type.'], 422);
            }

            if (!in_array($item['type'], ['product', 'escaperoom', 'giftcard'])) {
                return response()->json(['success' => false, 'message' => 'Invalid item type: ' . $item['type']], 422);
            }

            if ($item['type'] === 'product') {
                if (empty($item['product_id']) || empty($item['qty'])) {
                    return response()->json(['success' => false, 'message' => 'Each item must have a product_id and quantity.'], 422);
                }

                $product = $request->escaperoom->products()->find($item['product_id']);

                if (!$product) {
                    return response()->json(['success' => false, 'message' => 'Product not found: ' . $item['product_id']], 422);
                }

                if ($product->stock_quantity !== null && $product->stock_quantity === 0) {
                    return response()->json(['success' => false, 'message' => 'Product out of stock: ' . $item['product_id']], 422);
                }
            }

            if ($item['type'] === 'giftcard') {
                if (empty($item['gift_card_id'])) {
                    return response()->json(['success' => false, 'message' => 'Each item must have a gift_card_id.'], 422);
                }

                $giftCard = $request->escaperoom->giftCards()->find($item['gift_card_id']);

                if (!$giftCard) {
                    return response()->json(['success' => false, 'message' => 'Gift card not found: ' . $item['gift_card_id']], 422);
                }

                if ($giftCard->valid_from > now() || ($giftCard->valid_until && $giftCard->valid_until < now())) {
                    return response()->json(['success' => false, 'message' => 'Gift card not valid: ' . $item['gift_card_id']], 422);
                }
            }

            if ($item['type'] === 'escaperoom') {
                if (empty($item['room_id']) || empty($item['start_time']) || empty($item['end_time']) || empty($item['date']) || empty($item['players'])) {
                    return response()->json(['success' => false, 'message' => 'Each item must have a room_id, start_time, end_time, date and players.'], 422);
                }

                $room = $request->escaperoom->rooms()->find($item['room_id']);

                if (!$room) {
                    return response()->json(['success' => false, 'message' => 'Room not found: ' . $item['room_id']], 422);
                }

                $dayOfWeek = Carbon::parse($item['date'])->dayOfWeekIso - 1;
                $roomPrice = $room->prices()->where('day_of_week', $dayOfWeek)->where('player_amount', $item['players'])->first();

                if (!$roomPrice) {
                    return response()->json(['success' => false, 'message' => 'No price found for room ' . $item['room_id'] . ' on day ' . $dayOfWeek . ' for ' . $item['players'] . ' players.'], 422);
                }
            }
        }

        DB::transaction(function () use ($request, $items, $customer, &$total, &$subtotal, &$discount, &$vatTotal, &$leftToPay, &$roomPrice) {
            $order = new Order();
            $order->escaperoom_id = $request->escaperoom->id;
            $order->customer_id = $customer->id;
            $order->save();

            foreach ($items as $item) {
                if ($item['type'] === 'product') {
                    $productTotal = 0;
                    $productSubtotal = 0;
                    $productDiscountTotal = 0;
                    $productVatTotal = 0;
                    $product = $request->escaperoom->products()->find($item['product_id']);

                    if ($product->stock_quantity !== null) {
                        if ($product->stock_quantity < $item['qty']) {
                            $item['qty'] = $product->stock_quantity;
                        }

                        $product->stock_quantity -= $item['qty'];
                        $product->save();
                    }

                    $productTotal = round($product->selling_price * $item['qty'], 2);

                    if ($product->discount_type) {
                        if ($product->discount_type === 'percentage') {
                            $productDiscountTotal = round($productTotal * ($product->discount_value / 100), 2);
                        }

                        if ($product->discount_type === 'fixed') {
                            $productDiscountTotal = round($product->discount_value * $item['qty'], 2);
                        }
                    }

                    $productSubtotal = round($productTotal - $productDiscountTotal, 2);
                    $productVatTotal = round($productSubtotal * $product->vat_percentage / (100 + $product->vat_percentage), 2);

                    $total += $productTotal;
                    $subtotal += $productSubtotal;
                    $discount += $productDiscountTotal;
                    $vatTotal += $productVatTotal;

                    $order->orderedItems()->create([
                        'product_id' => $product->id,
                        'quantity' => $item['qty'],
                        'unit_price' => round($productSubtotal / $item['qty'], 2),
                        'total_price' => $productSubtotal,
                        'vat_percentage' => $product->vat_percentage,
                        'vat_amount' => $productVatTotal,
                    ]);
                }

                if ($item['type'] === 'giftcard') {
                    $giftCard = $request->escaperoom->giftCards()->find($item['gift_card_id']);
                    $giftCardTotal = $giftCard->amount;

                    $total += $giftCardTotal;
                    $subtotal += $giftCardTotal;
                }

                if ($item['type'] === 'escaperoom') {
                    $roomTotal = 0;
                    $roomSubtotal = 0;
                    $roomDiscountTotal = 0;
                    $roomVatTotal = 0;
                    $roomLeftToPay = 0;
                    $room = $request->escaperoom->rooms()->find($item['room_id']);
                    $dayOfWeek = Carbon::parse($item['date'])->dayOfWeekIso - 1;
                    $roomPrice = $room->prices()->where('day_of_week', $dayOfWeek)->where('player_amount', $item['players'])->first();

                    if ($roomPrice->payment_location === 'online') {
                        $roomTotal = round($roomPrice->price, 2);
                        $roomSubtotal = round($roomPrice->price, 2);
                        $roomVatTotal = round($roomSubtotal * $roomPrice->vat_percentage / (100 + $roomPrice->vat_percentage), 2);
                    }

                    if ($roomPrice->payment_location === 'location') {
                        if ($roomPrice->base_price >= $roomPrice->price) {
                            $roomTotal = round($roomPrice->price, 2);
                            $roomSubtotal = round($roomPrice->price, 2);
                            $roomVatTotal = round($roomSubtotal * $roomPrice->vat_percentage / (100 + $roomPrice->vat_percentage), 2);
                        }

                        if ($roomPrice->base_price < $roomPrice->price) {
                            $roomTotal = round($roomPrice->base_price, 2);
                            $roomSubtotal = round($roomPrice->base_price, 2);
                            $roomVatTotal = round($roomSubtotal * $roomPrice->vat_percentage / (100 + $roomPrice->vat_percentage), 2);
                            $roomLeftToPay = round($roomPrice->price - $roomPrice->base_price, 2);
                        }
                    }

                    $total += $roomTotal;
                    $subtotal += $roomSubtotal;
                    $discount += $roomDiscountTotal;
                    $vatTotal += $roomVatTotal;
                    $leftToPay += $roomLeftToPay;
                }
            }

            $order->total = $total;
            $order->subtotal = $subtotal;
            $order->discount = $discount;
            $order->vat_amount = $vatTotal;
            $order->save();
        });

        return response()->json(['success' => true, 'info' => $orderInfo, 'customer' => $customer, 'ip' => $request->ip(), 'roomPrices' => $roomPrice, 'total' => $total, 'subtotal' => $subtotal, 'discount' => $discount, 'vat_total' => $vatTotal, 'left_to_pay' => $leftToPay]);
    }

    private function matchOrCreateCustomer($escaperoom, array $input, ?string $ip): Customer
    {
        $candidates = $escaperoom->customers()
            ->where(function ($q) use ($input, $ip) {
                $q->where('email', $input['email'] ?? '')
                    ->orWhere(function ($q) use ($input) {
                        if (!empty($input['phone'])) {
                            $q->where('phone', $input['phone']);
                        }
                    })
                    ->orWhere(function ($q) use ($input) {
                        if (!empty($input['first_name']) && !empty($input['last_name'])) {
                            $q->where('first_name', $input['first_name'])
                                ->where('last_name', $input['last_name']);
                        }
                    })
                    ->orWhere(function ($q) use ($ip) {
                        if ($ip) {
                            $q->where('ip_address', $ip);
                        }
                    });
            })
            ->get();

        $best = null;
        $bestScore = 0;

        foreach ($candidates as $candidate) {
            $score = 0;

            if (!empty($input['email']) && $candidate->email === $input['email']) {
                $score += 60;
            }
            if (!empty($input['phone']) && $candidate->phone === $input['phone']) {
                $score += 50;
            }
            if (
                !empty($input['first_name']) && !empty($input['last_name'])
                && $candidate->first_name === $input['first_name']
                && $candidate->last_name === $input['last_name']
            ) {
                $score += 30;
            }
            if (!empty($input['city']) && $candidate->city === $input['city']) {
                $score += 10;
            }
            if (!empty($input['street']) && $candidate->street === $input['street']) {
                $score += 10;
            }
            if ($ip && $candidate->ip_address === $ip) {
                $score += 15;
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $candidate;
            }
        }

        if ($best && $bestScore >= 50) {
            return $best;
        }

        return $escaperoom->customers()->create(array_merge(
            array_intersect_key($input, array_flip([
                'first_name',
                'last_name',
                'email',
                'phone',
                'street',
                'house_number',
                'postal_code',
                'city',
                'country',
            ])),
            ['ip_address' => $ip]
        ));
    }
}
