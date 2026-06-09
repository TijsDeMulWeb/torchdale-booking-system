<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Http\Data\DataCollection;
use Mollie\Api\Http\Data\Discount;
use Mollie\Api\Http\Data\InvoiceLine;
use Mollie\Api\Http\Data\Money;
use Mollie\Api\Http\Data\Recipient;
use Mollie\Api\Http\Requests\CreateSalesInvoiceRequest;
use Mollie\Api\Types\RecipientType;
use Mollie\Api\Types\SalesInvoiceStatus;
use Mollie\Api\Types\VatMode;
use Mollie\Api\Types\VatScheme;

class StoreOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $escaperoomId = $user->escaperoom_id;

        $customerId = $request->input('customer_id');
        $cart = json_decode($request->input('cart', '[]'), true) ?? [];
        $paymentTerm = $request->input('payment_term', '30');
        $couponId = $request->input('coupon_id') ?: null;
        $totals = json_decode($request->input('totals', '{}'), true) ?? [];
        $business = json_decode($request->input('business', '{}'), true) ?? [];

        $customer = Customer::findOrFail($customerId);

        $totalBtw = array_sum($totals['btw'] ?? []);

        $order = new Order();
        $order->escaperoom_id = $escaperoomId;
        $order->customer_id = $customerId;
        $order->customer_first_name = $customer->first_name;
        $order->customer_last_name = $customer->last_name;
        $order->customer_email = $customer->email;
        $order->customer_phone = $customer->phone ?? null;
        $order->coupon_id = $couponId;
        $order->total = round($totals['totaal_incl_btw'] ?? 0, 2);
        $order->subtotal = round($totals['subtotaal_excl'] ?? 0, 2);
        $order->discount = round($totals['discount'] ?? 0, 2);
        $order->vat_amount = round($totalBtw, 2);
        $order->status = 'pending';
        $order->is_business = (bool) ($business['is_business'] ?? false);
        $order->company_name = $business['company_name'] ?? null;
        $order->vat_number = $business['vat_number'] ?? null;
        $order->registration_number = $business['registration_number'] ?? null;
        $order->save();

        foreach ($cart as $item) {
            $itemId = (string) ($item['id'] ?? '');
            $unitPrice = (float) ($item['price'] ?? 0);
            $qty = (int) ($item['qty'] ?? 1);
            $vatPct = (float) ($item['vat'] ?? 0);
            $lineTotal = $unitPrice * $qty;
            $vatAmount = $vatPct > 0 ? $lineTotal * ($vatPct / (100 + $vatPct)) : 0;

            $orderedItem = new OrderedItem();
            $orderedItem->order_id = $order->id;
            $orderedItem->quantity = $qty;
            $orderedItem->unit_price = $unitPrice;
            $orderedItem->total_price = $lineTotal;
            $orderedItem->vat_percentage = $vatPct;
            $orderedItem->vat_amount = round($vatAmount, 4);

            if (str_starts_with($itemId, 'room_')) {
                $orderedItem->time_slot_id = null;
            } elseif (str_starts_with($itemId, 'giftcard_')) {
                $orderedItem->gift_card_id = (int) substr($itemId, strlen('giftcard_'));
            } elseif (str_starts_with($itemId, 'product_')) {
                $orderedItem->product_id = (int) substr($itemId, strlen('product_'));
            } else {
                $orderedItem->product_id = (int) $itemId ?: null;
            }

            $orderedItem->save();
        }

        if ($request->payment_method === 'online') {
            $this->createMollieInvoice($order, $customer, $cart, $totals, $business, $paymentTerm);
        }

        return redirect()->route('orders.index')->with('success', 'Bestelling geplaatst.');
    }

    private function createMollieInvoice(
        Order $order,
        Customer $customer,
        array $cart,
        array $totals,
        array $business,
        string $paymentTerm
    ): void {
        try {
            $isBusiness = (bool) ($business['is_business'] ?? false);
            $street = trim(($customer->street ?? '') . ' ' . ($customer->house_number ?? ''));

            $recipient = new Recipient(
                type: $isBusiness ? RecipientType::BUSINESS : RecipientType::CONSUMER,
                email: $customer->email,
                streetAndNumber: $street,
                postalCode: $customer->postal_code,
                city: $customer->city,
                country: 'BE',
                locale: 'nl_BE',
                givenName: $customer->first_name,
                familyName: $customer->last_name,
                organizationName: $isBusiness ? ($business['company_name'] ?? null) : null,
                vatNumber: $isBusiness ? ($business['vat_number'] ?? null) : null,
                organizationNumber: $isBusiness ? ($business['registration_number'] ?? null) : null,
                phone: $customer->phone ?? null,
            );

            $lines = [];
            foreach ($cart as $item) {
                $originalPrice = (float) ($item['originalPrice'] ?? $item['price'] ?? 0);
                $effectivePrice = (float) ($item['price'] ?? 0);
                $discountType = $item['discountType'] ?? '';
                $discountValue = (float) ($item['discountValue'] ?? 0);

                $lineDiscount = null;
                if ($originalPrice > 0 && $effectivePrice < $originalPrice && $discountType && $discountValue > 0) {
                    if ($discountType === 'percentage') {
                        $lineDiscount = new Discount(
                            type: 'percentage',
                            value: number_format($discountValue, 2, '.', ''),
                        );
                    } else {
                        $lineDiscount = new Discount(
                            type: 'amount',
                            value: number_format($discountValue, 2, '.', ''),
                        );
                    }
                }

                $lines[] = new InvoiceLine(
                    description: $item['name'] ?? 'Product',
                    quantity: (int) ($item['qty'] ?? 1),
                    vatRate: number_format((float) ($item['vat'] ?? 0), 2, '.', ''),
                    unitPrice: new Money('EUR', number_format($originalPrice, 2, '.', '')),
                    discount: $lineDiscount,
                );
            }

            $molliePaymentTerm = $this->mapPaymentTerm($paymentTerm);

            $discount = (float) ($totals['discount'] ?? 0);
            $subtotaalExcl = (float) ($totals['subtotaal_excl'] ?? 0);
            $invoiceDiscount = null;
            if ($discount > 0 && $subtotaalExcl > 0) {
                $pct = round($discount / $subtotaalExcl * 100, 2);
                $invoiceDiscount = new Discount(
                    type: 'percentage',
                    value: number_format($pct, 2, '.', ''),
                );
            }

            $salesInvoiceRequest = new CreateSalesInvoiceRequest(
                currency: 'EUR',
                status: SalesInvoiceStatus::ISSUED,
                vatScheme: VatScheme::STANDARD,
                vatMode: VatMode::INCLUSIVE,
                paymentTerm: $molliePaymentTerm,
                recipientIdentifier: $isBusiness
                ? ($business['vat_number'] ?? ($customer->email . '-business'))
                : $customer->email,
                recipient: $recipient,
                lines: new DataCollection($lines),
                discount: $invoiceDiscount,
                isEInvoice: false,
            );

            $mollie = new MollieApiClient();
            $mollie->setApiKey(env('MOLLIE_KEY'));

            $mollieInvoice = $mollie->send($salesInvoiceRequest);

            $invoiceNumber = $mollieInvoice->invoiceNumber ?? ('INV-' . $order->id . '-' . time());

            $pdfPath = null;
            $mollieHref = $mollieInvoice->_links->pdfLink->href ?? null;
            if ($mollieHref) {
                $pdfResponse = Http::withToken(env('MOLLIE_KEY'))->get($mollieHref);
                if ($pdfResponse->successful()) {
                    $pdfPath = 'escaperooms/' . auth()->user()->escaperoom->id . '/invoices/' . $invoiceNumber . '.pdf';
                    Storage::disk('local')->put($pdfPath, $pdfResponse->body());
                }
            }

            DB::table('invoices')->insert([
                'customer_id' => $customer->id,
                'order_id' => $order->id,
                'mollie_invoice_id' => $mollieInvoice->id,
                'pdf_url' => $pdfPath,
                'source' => 'mollie',
                'invoice_number' => $invoiceNumber,
                'status' => $mollieInvoice->status,
                'amount' => round($totals['totaal_incl_btw'] ?? 0, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $order->mollie_id = $mollieInvoice->id;
            $order->invoice_number = $invoiceNumber;
            $order->save();
        } catch (\Exception $e) {
            Log::error('Mollie sales invoice creation failed for order ' . $order->id . ': ' . $e->getMessage());
        }
    }

    private function mapPaymentTerm(string $days): string
    {
        return match ($days) {
            '7' => '7 days',
            '14' => '14 days',
            '45' => '45 days',
            '60' => '60 days',
            '90' => '90 days',
            '120' => '120 days',
            default => '30 days',
        };
    }
}
