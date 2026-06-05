<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Http\Requests\CreateSalesInvoiceRequest;
use Mollie\Api\Http\Data\Money;
use Mollie\Api\Http\Data\Discount;
use Mollie\Api\Http\Data\Recipient;
use Mollie\Api\Http\Data\InvoiceLine;
use Mollie\Api\Http\Data\DataCollection;
use Mollie\Api\Types\RecipientType;
use Mollie\Api\Types\VatScheme;
use Mollie\Api\Types\VatMode;
use Mollie\Api\Types\PaymentTerm;
use Mollie\Api\Types\SalesInvoiceStatus;


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

        $discountCodeInput = $request->input('discount_code');
        $discountCode = null;

        if ($discountCodeInput) {
            $discountCode = $request->escaperoom->coupons()->where('code', $discountCodeInput)->first();

            if (!$discountCode || $discountCode->valid_from > now() || ($discountCode->valid_until && $discountCode->valid_until < now()) || ($discountCode->usage_limit !== null && $discountCode->usage_limit === 0)) {
                return response()->json(['success' => false, 'message' => 'Invalid discount code.'], 422);
            }
        }

        $total = 0;
        $subtotal = 0;
        $discount = 0;
        $vatTotal = 0;
        $leftToPay = 0;
        $invoiceDiscount = null;
        $roomPrice = null;
        $order = null;
        $invoiceLineData = [];

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



        DB::transaction(function () use ($request, $items, $customer, $customerInput, $discountCode, &$total, &$subtotal, &$discount, &$vatTotal, &$leftToPay, &$roomPrice, &$order, &$invoiceLineData, &$invoiceDiscount) {
            $order = new Order();
            $order->escaperoom_id = $request->escaperoom->id;
            $order->customer_id = $customer->id;
            $order->customer_first_name = $customerInput['first_name'] ?? $customer->first_name;
            $order->customer_last_name = $customerInput['last_name'] ?? $customer->last_name;
            $order->customer_email = $customerInput['email'] ?? $customer->email;
            $order->customer_phone = $customerInput['phone'] ?? $customer->phone;
            $order->is_business = !empty($customerInput['is_business']);
            $order->company_name = $customerInput['company_name'] ?? null;
            $order->vat_number = $customerInput['vat_number'] ?? null;
            $order->registration_number = $customerInput['registration_number'] ?? null;
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

                    $productTotalInclVat = round($product->selling_price * $item['qty'], 2);

                    if ($product->discount_type) {
                        if ($product->discount_type === 'percentage') {
                            $productDiscountTotal = round($productTotalInclVat * ($product->discount_value / 100), 2);
                        }

                        if ($product->discount_type === 'fixed') {
                            $productDiscountTotal = round(min($product->discount_value * $item['qty'], $productTotalInclVat), 2);
                        }
                    }

                    $productTotal = round($productTotalInclVat - $productDiscountTotal, 2);
                    $productSubtotal = round($productTotal / (1 + $product->vat_percentage / 100), 2);
                    $productVatTotal = round($productTotal - $productSubtotal, 2);

                    $total += $productTotal;
                    $subtotal += $productSubtotal;
                    $discount += $productDiscountTotal;
                    $vatTotal += $productVatTotal;

                    $order->orderedItems()->create([
                        'product_id' => $product->id,
                        'quantity' => $item['qty'],
                        'unit_price' => $product->selling_price,
                        'total_price' => $productTotal,
                        'vat_percentage' => $product->vat_percentage,
                        'vat_amount' => $productVatTotal,
                    ]);

                    $invoiceLineData[] = [
                        'description' => $product->name,
                        'quantity' => $item['qty'],
                        'vatRate' => number_format((float) $product->vat_percentage, 2, '.', ''),
                        'unitPrice' => $product->selling_price,
                        'discountType' => $product->discount_type,
                        'discountValue' => $product->discount_value ? number_format((float) $product->discount_value, 2, '.', '') : null,
                    ];
                }

                if ($item['type'] === 'giftcard') {
                    $giftCard = $request->escaperoom->giftCards()->find($item['gift_card_id']);
                    $giftCardTotal = $giftCard->amount;

                    $total += $giftCardTotal;
                    $subtotal += $giftCardTotal;

                    $invoiceLineData[] = [
                        'description' => $giftCard->name,
                        'quantity' => 1,
                        'vatRate' => '0.00',
                        'unitPrice' => $giftCardTotal,
                        'discountType' => null,
                        'discountValue' => null,
                    ];
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

                    $invoiceLineData[] = [
                        'description' => $room->name . ' — ' . $item['date'] . ' (' . $item['players'] . ' spelers)',
                        'quantity' => 1,
                        'vatRate' => number_format((float) $roomPrice->vat_percentage, 2, '.', ''),
                        'unitPrice' => $roomTotal,
                        'discountType' => null,
                        'discountValue' => null,
                    ];
                }
            }

            if ($discountCode) {
                $totalBeforeDiscount = $total;

                if ($discountCode->discount_type === 'percentage') {
                    $couponDiscount = round($totalBeforeDiscount * ($discountCode->discount_value / 100), 2);
                }

                if ($discountCode->discount_type === 'fixed') {
                    $couponDiscount = round(min($discountCode->discount_value, $totalBeforeDiscount), 2);
                }

                $discount += $couponDiscount;
                $total = round($totalBeforeDiscount - $couponDiscount, 2);

                $subtotal = $totalBeforeDiscount > 0 ? round($subtotal * ($total / $totalBeforeDiscount), 2) : 0;

                $vatTotal = round($total - $subtotal, 2);

                if ($discountCode->usage_limit !== null) {
                    $discountCode->usage_limit -= 1;
                    $discountCode->times_used += 1;
                    $discountCode->save();
                }

                $invoiceDiscount = new Discount(
                    type: $discountCode->discount_type === 'fixed' ? 'amount' : 'percentage',
                    value: number_format((float) $discountCode->discount_value, 2, '.', ''),
                );
            }

            $order->total = $total;
            $order->subtotal = $subtotal;
            $order->discount = $discount;
            $order->vat_amount = $vatTotal;
            $order->save();
        });

        $mollie = new MollieApiClient();
        $mollie->setApiKey('test_McAeHWQHyjAAnkjEkzDdTm7nuAbgkd');

        $streetAndNumber = trim(($customerInput['street'] ?? '') . ' ' . ($customerInput['house_number'] ?? ''));

        $recipient = new Recipient(
            type: $order->is_business ? RecipientType::BUSINESS : RecipientType::CONSUMER,
            givenName: $order->customer_first_name,
            familyName: $order->customer_last_name,
            email: $order->customer_email,
            phone: $order->customer_phone ?? null,
            streetAndNumber: $streetAndNumber,
            streetAdditional: $customerInput['address_line_2'] ?? null,
            postalCode: $customerInput['postal_code'],
            city: $customerInput['city'],
            country: 'BE',
            locale: 'nl_BE',
            organizationName: $order->is_business ? $order->company_name : null,
            organizationNumber: $order->is_business ? $order->registration_number : null,
            vatNumber: $order->is_business ? $order->vat_number : null,
        );

        $mollieLines = array_map(function (array $line): InvoiceLine {
            $discount = null;
            if ($line['discountType'] && $line['discountValue'] !== null) {
                $discount = new Discount(type: $line['discountType'], value: $line['discountValue']);
            }

            return new InvoiceLine(
                description: $line['description'],
                quantity: $line['quantity'],
                vatRate: $line['vatRate'],
                unitPrice: new Money(currency: 'EUR', value: number_format((float) $line['unitPrice'], 2, '.', '')),
                discount: $discount,
            );
        }, $invoiceLineData);

        $invoiceRequest = new CreateSalesInvoiceRequest(
            currency: 'EUR',
            status: SalesInvoiceStatus::ISSUED,
            vatScheme: VatScheme::STANDARD,
            vatMode: VatMode::INCLUSIVE,
            paymentTerm: PaymentTerm::DAYS_30,
            recipientIdentifier: 'customer-' . $customer->id . '-' . ($order->is_business ? 'business' : 'consumer'),
            recipient: $recipient,
            lines: new DataCollection($mollieLines),
            discount: $invoiceDiscount,
            isEInvoice: false
        );

        $salesInvoice = $mollie->send($invoiceRequest);

        return response()->json(['success' => true, 'order' => $order, 'invoice' => $salesInvoice]);
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
                            $q->whereRaw('LOWER(first_name) = ?', [strtolower($input['first_name'])])
                                ->whereRaw('LOWER(last_name) = ?', [strtolower($input['last_name'])]);
                        }
                    })
                    ->orWhere(function ($q) use ($ip) {
                        if ($ip) {
                            $q->where('ip_address', $ip);
                        }
                    })
                    ->orWhereHas('identifiers', function ($q) use ($input, $ip) {
                        $q->where(function ($q) use ($input) {
                            if (!empty($input['email'])) {
                                $q->where('type', 'email')->where('value', $input['email']);
                            }
                        })->orWhere(function ($q) use ($input) {
                            if (!empty($input['phone'])) {
                                $q->where('type', 'phone')->where('value', $input['phone']);
                            }
                        })->orWhere(function ($q) use ($ip) {
                            if ($ip) {
                                $q->where('type', 'ip_address')->where('value', $ip);
                            }
                        });
                    });
            })
            ->with('identifiers')
            ->get();

        $best = null;
        $bestScore = 0;
        $bestBanned = null;
        $bestBannedScore = 0;

        foreach ($candidates as $candidate) {
            $score = 0;

            $knownEmails = $candidate->identifiers->where('type', 'email')->pluck('value')->push($candidate->email);
            $knownPhones = $candidate->identifiers->where('type', 'phone')->pluck('value')->push($candidate->phone);
            $knownIps = $candidate->identifiers->where('type', 'ip_address')->pluck('value')->push($candidate->ip_address);

            if (!empty($input['email']) && $knownEmails->contains($input['email'])) {
                $score += 60;
            }
            if (!empty($input['phone']) && $knownPhones->contains($input['phone'])) {
                $score += 50;
            }
            if (
                !empty($input['first_name']) && !empty($input['last_name'])
                && strtolower($candidate->first_name) === strtolower($input['first_name'])
                && strtolower($candidate->last_name) === strtolower($input['last_name'])
            ) {
                $score += 30;
            }
            if (!empty($input['city']) && strtolower($candidate->city) === strtolower($input['city'])) {
                $score += 10;
            }
            if (!empty($input['street']) && strtolower($candidate->street) === strtolower($input['street'])) {
                $score += 10;
            }
            if ($ip && $knownIps->contains($ip)) {
                $score += 15;
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $candidate;
            }

            if ($candidate->banned_at && $score > $bestBannedScore) {
                $bestBannedScore = $score;
                $bestBanned = $candidate;
            }
        }

        if ($bestBanned && $bestBannedScore >= 30) {
            return $bestBanned;
        }

        if ($best && $bestScore >= 50) {
            if (!empty($input['email']) && !$best->identifiers->where('type', 'email')->where('value', $input['email'])->count() && $best->email !== $input['email']) {
                $best->identifiers()->firstOrCreate(['type' => 'email', 'value' => $input['email']]);
            }
            if (!empty($input['phone']) && !$best->identifiers->where('type', 'phone')->where('value', $input['phone'])->count() && $best->phone !== $input['phone']) {
                $best->identifiers()->firstOrCreate(['type' => 'phone', 'value' => $input['phone']]);
            }
            if ($ip && !$best->identifiers->where('type', 'ip_address')->where('value', $ip)->count() && $best->ip_address !== $ip) {
                $best->identifiers()->firstOrCreate(['type' => 'ip_address', 'value' => $ip]);
            }

            return $best;
        }

        $customer = $escaperoom->customers()->create(array_merge(
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

        return $customer;
    }
}
