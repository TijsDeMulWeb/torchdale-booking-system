<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $orderInfo = $request->input();
        $customerInput = $request->input('customer');
        $total = 0;
        $subtotal = 0;
        $discount = 0;
        $vatTotal = 0;

        $customer = $this->matchOrCreateCustomer($request->escaperoom, $customerInput, $request->ip());

        if ($customer->banned_at) {
            return response()->json(['success' => false, 'message' => 'Customer isn\'t allowed to place an order.'], 403);
        }

        $items = $request->input('items', []);

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

                $productTotal = 0;
                $productSubtotal = 0;
                $productDiscountTotal = 0;
                $productVatTotal = 0;
                $product = $request->escaperoom->products()->find($item['product_id']);

                if (!$product) {
                    return response()->json(['success' => false, 'message' => 'Product not found: ' . $item['product_id']], 422);
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
            }

            if ($item['type'] === 'giftcard') {
                if (empty($item['gift_card_id'])) {
                    return response()->json(['success' => false, 'message' => 'Each item must have a gift_card_id.'], 422);
                }

                $giftCardTotal = 0;
                $giftCard = $request->escaperoom->giftCards()->find($item['gift_card_id']);

                if (!$giftCard) {
                    return response()->json(['success' => false, 'message' => 'Gift card not found: ' . $item['gift_card_id']], 422);
                }

                if ($giftCard->valid_from > now() || ($giftCard->valid_until && $giftCard->valid_until < now())) {
                    return response()->json(['success' => false, 'message' => 'Gift card not valid: ' . $item['gift_card_id']], 422);
                }

                $giftCardTotal = $giftCard->amount;

                $total += $giftCardTotal;
                $subtotal += $giftCardTotal;
            }
        }

        return response()->json(['success' => true, 'info' => $orderInfo, 'customer' => $customer, 'ip' => $request->ip(), 'giftcard' => $giftCard, 'total' => $total, 'subtotal' => $subtotal, 'discount' => $discount, 'vat_total' => $vatTotal]);
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
