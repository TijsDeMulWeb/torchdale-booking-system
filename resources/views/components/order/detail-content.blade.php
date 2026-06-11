@props(['order'])

@php
    $customerName = trim(($order->customer_first_name ?? $order->customer?->first_name) . ' ' . ($order->customer_last_name ?? $order->customer?->last_name)) ?: '—';
    $customerEmail = $order->customer_email ?? $order->customer?->email;
    $customerPhone = $order->customer_phone ?? $order->customer?->phone;
    $hasInvoicePdf = $order->invoice && $order->invoice->pdf_url;

    // `order->subtotal`/`vat_amount` aren't reliably excl.-VAT (escape room items store the
    // incl.-VAT price as "subtotal"), so derive the breakdown from `total`, `discount` and
    // the per-item vat_amount/total_price instead, which are correct for every item type.
    $total = (float) ($order->total ?? 0);
    $discount = (float) ($order->discount ?? 0);
    $totalBeforeDiscount = $total + $discount;
    $vatBeforeDiscount = (float) $order->orderedItems->sum('vat_amount');
    $subtotalExclVatBeforeDiscount = $totalBeforeDiscount - $vatBeforeDiscount;

    $ratio = $totalBeforeDiscount > 0 ? $total / $totalBeforeDiscount : 1;
    $vatAmount = round($vatBeforeDiscount * $ratio, 2);
    $subtotalExclVatAfterDiscount = $total - $vatAmount;
    $discountExclVat = round($subtotalExclVatBeforeDiscount - $subtotalExclVatAfterDiscount, 2);
    $subtotalExclVat = $subtotalExclVatBeforeDiscount;
@endphp

<div class="space-y-6">
    <div>
        <h3 class="text-base font-semibold text-gray-900 dark:text-white">
            {{ __('orders.order_modal_title', ['number' => $order->invoice_number ?? '#' . $order->id]) }}
        </h3>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d-m-Y H:i') }}</p>
    </div>

    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
        <div>
            <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_customer') }}</dt>
            <dd class="text-gray-900 dark:text-white">{{ $customerName }}</dd>
        </div>
        <div>
            <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_email') }}</dt>
            <dd class="text-gray-900 dark:text-white break-all">{{ $customerEmail ?: '—' }}</dd>
        </div>
        <div>
            <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_phone') }}</dt>
            <dd class="text-gray-900 dark:text-white">{{ $customerPhone ?: '—' }}</dd>
        </div>
        <div>
            <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_payment_method') }}</dt>
            <dd class="text-gray-900 dark:text-white">{{ $order->payment_method ?? '—' }}</dd>
        </div>
        <div>
            <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_status') }}</dt>
            <dd class="text-gray-900 dark:text-white">{{ $order->status }}</dd>
        </div>
        @if ($order->referral_source)
            <div>
                <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_referral_source') }}</dt>
                <dd class="text-gray-900 dark:text-white">{{ $order->referral_source }}</dd>
            </div>
        @endif
        <div>
            <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_invoice') }}</dt>
            <dd>
                @if ($hasInvoicePdf)
                    <a href="{{ route('orders.invoice', $order) }}" target="_blank" rel="noopener"
                        class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('orders.order_modal_view_invoice') }}
                    </a>
                @elseif ($order->payment_link || $order->mollie_id)
                    <a href="{{ route('orders.payment-link', $order) }}" target="_blank" rel="noopener"
                        class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('orders.order_modal_view_payment_link') }}
                    </a>
                @else
                    <span class="text-gray-400 dark:text-gray-500">{{ __('orders.order_modal_no_document') }}</span>
                @endif
            </dd>
        </div>
    </dl>

    <div>
        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('orders.order_modal_items') }}</h4>
        <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10 text-sm">
            <thead>
                <tr>
                    <th class="py-2 pr-3 text-left font-medium text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_item_header_name') }}</th>
                    <th class="px-3 py-2 text-right font-medium text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_item_header_qty') }}</th>
                    <th class="px-3 py-2 text-right font-medium text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_item_header_price') }}</th>
                    <th class="py-2 pl-3 text-right font-medium text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_item_header_total') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @foreach ($order->orderedItems as $item)
                    <tr>
                        <td class="py-2 pr-3 text-gray-900 dark:text-white">
                            {{ $item->item_name ?? $item->description ?? '—' }}
                            @if ($item->timeSlot?->language)
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('orders.order_modal_language') }}: {{ $item->timeSlot->language->name }}
                                </p>
                            @endif
                            @if (!empty($item->player_names))
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('orders.order_modal_players') }}: {{ implode(', ', $item->player_names) }}
                                </p>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-right text-gray-600 dark:text-gray-400">{{ $item->quantity }}</td>
                        <td class="px-3 py-2 text-right text-gray-600 dark:text-gray-400">{{ Number::currency($item->unit_price ?? 0) }}</td>
                        <td class="py-2 pl-3 text-right text-gray-900 dark:text-white">{{ Number::currency($item->total_price ?? 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <dl class="mt-3 space-y-1 text-sm border-t border-gray-100 dark:border-white/10 pt-3">
            <div class="flex justify-between">
                <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_subtotal') }}</dt>
                <dd class="text-gray-900 dark:text-white">{{ Number::currency($subtotalExclVat) }}</dd>
            </div>
            @if ($discount)
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_discount') }}</dt>
                    <dd class="text-gray-900 dark:text-white">-{{ Number::currency($discountExclVat) }}</dd>
                </div>
            @endif
            <div class="flex justify-between">
                <dt class="text-gray-500 dark:text-gray-400">{{ __('orders.order_modal_vat') }}</dt>
                <dd class="text-gray-900 dark:text-white">{{ Number::currency($vatAmount) }}</dd>
            </div>
            <div class="flex justify-between font-semibold">
                <dt class="text-gray-900 dark:text-white">{{ __('orders.order_modal_total') }}</dt>
                <dd class="text-gray-900 dark:text-white">{{ Number::currency($total) }}</dd>
            </div>
        </dl>
    </div>

    @if ($order->notes)
        <div>
            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('orders.order_modal_notes') }}</h4>
            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $order->notes }}</p>
        </div>
    @endif

    <div>
        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('orders.order_modal_legal_documents') }}</h4>
        <ul class="space-y-1 text-sm">
            <li class="flex items-center justify-between gap-3">
                <span class="text-gray-500 dark:text-gray-400">{{ __('legalDocuments.type_privacy_policy') }}</span>
                @if ($order->privacyPolicyDocument)
                    <a href="{{ Storage::disk('public')->url($order->privacyPolicyDocument->file_path) }}" target="_blank" rel="noopener"
                        class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('legalDocuments.version_label', ['version' => $order->privacyPolicyDocument->version]) }}
                    </a>
                @else
                    <span class="text-gray-400 dark:text-gray-500">{{ __('orders.order_modal_no_document') }}</span>
                @endif
            </li>
            <li class="flex items-center justify-between gap-3">
                <span class="text-gray-500 dark:text-gray-400">{{ __('legalDocuments.type_terms_conditions') }}</span>
                @if ($order->termsConditionsDocument)
                    <a href="{{ Storage::disk('public')->url($order->termsConditionsDocument->file_path) }}" target="_blank" rel="noopener"
                        class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('legalDocuments.version_label', ['version' => $order->termsConditionsDocument->version]) }}
                    </a>
                @else
                    <span class="text-gray-400 dark:text-gray-500">{{ __('orders.order_modal_no_document') }}</span>
                @endif
            </li>
        </ul>
    </div>
</div>
