<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Mollie\Api\MollieApiClient;

class ShowOrderPaymentLinkController extends Controller
{
    public function __invoke(Order $order): RedirectResponse
    {
        if ($order->payment_link) {
            return redirect()->away($order->payment_link);
        }

        abort_if(!$order->mollie_id, 404);

        $mollieKey = $order->escaperoom?->escaperoomSetting?->mollie_api_key;

        abort_if(!$mollieKey, 404);

        $mollie = new MollieApiClient();
        $mollie->setApiKey($mollieKey);

        $invoice = $mollie->salesInvoices->get($order->mollie_id);

        $paymentLink = $invoice->_links->paymentLink->href ?? null;

        abort_if(!$paymentLink, 404);

        return redirect()->away($paymentLink);
    }
}
