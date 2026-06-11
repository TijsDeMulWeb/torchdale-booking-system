<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Mail\PaymentReminderMail;
use App\Models\Order;
use App\Services\MailTemplateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\MollieApiClient;

class SendPaymentReminderController extends Controller
{
    public function __invoke(Order $order): RedirectResponse
    {
        abort_unless($order->escaperoom_id === auth()->user()->escaperoom_id, 404);

        if ($order->status !== 'pending' || ! $order->customer_email) {
            return back()->with('error', __('orders.payment_reminder_error'));
        }

        $amountDue = $order->payment_method === 'manual'
            ? round((float) $order->amount_online - (float) $order->amount_paid_online, 2)
            : (float) $order->total;

        if ($amountDue <= 0) {
            return back()->with('error', __('orders.payment_reminder_error'));
        }

        $paymentLink = $order->payment_link ?: $this->resolvePaymentLink($order);

        if (! $paymentLink) {
            return back()->with('error', __('orders.payment_reminder_error'));
        }

        $escaperoom = $order->escaperoom;

        try {
            Mail::to($order->customer_email)->send(new PaymentReminderMail($order, $escaperoom, $amountDue));
        } catch (\Exception $e) {
            Log::error('Versturen betalingsherinnering mislukt voor order ' . $order->id . ': ' . $e->getMessage());

            return back()->with('error', __('orders.payment_reminder_error'));
        }

        app(MailTemplateService::class)->logMail(
            $order,
            'payment_reminder',
            __('orders.payment_reminder_log_subject'),
            __('orders.payment_reminder_log_body')
        );

        return back()->with('success', __('orders.payment_reminder_sent'));
    }

    private function resolvePaymentLink(Order $order): ?string
    {
        if (! $order->mollie_id) {
            return null;
        }

        $mollieKey = $order->escaperoom?->escaperoomSetting?->mollie_api_key;

        if (! $mollieKey) {
            return null;
        }

        try {
            $mollie = new MollieApiClient();
            $mollie->setApiKey($mollieKey);

            $invoice = $mollie->salesInvoices->get($order->mollie_id);
            $paymentLink = $invoice->_links->invoicePayment->href ?? null;

            if ($paymentLink) {
                $order->payment_link = $paymentLink;
                $order->save();
            }

            return $paymentLink;
        } catch (\Exception $e) {
            Log::error('Ophalen betaallink mislukt voor order ' . $order->id . ': ' . $e->getMessage());

            return null;
        }
    }
}
