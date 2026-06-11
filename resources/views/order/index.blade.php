<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('orders.index_title'), 'url' => route('orders.index')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-6 pb-4">
        <div class="px-4 sm:px-6 lg:px-8">

            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('orders.index_title') }}</h1>
                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ __('orders.index_description') }}</p>
                </div>
            </div>

            <div class="mt-6">
                <x-order.tabs />

                <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4">
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('orders.stat_revenue_today') }}</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ Number::currency($todayRevenue) }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.stat_paid_orders') }}</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('orders.stat_total_revenue') }}</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ Number::currency($totalRevenue) }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.stat_paid_orders') }}</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('orders.stat_orders_today') }}</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $todayOrderCount }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.stat_all_statuses') }}</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('orders.stat_total_orders') }}</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $totalOrderCount }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.stat_all_statuses') }}</p>
                    </div>
                </div>

                @php
                    $statusBadge = function(string $status): string {
                        return match($status) {
                            'paid'      => '<span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">' . __('common.status_paid') . '</span>',
                            'pending'   => '<span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">' . __('common.status_open') . '</span>',
                            'cancelled' => '<span class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/20 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/20">' . __('common.status_cancelled') . '</span>',
                            default     => '<span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">' . e($status) . '</span>',
                        };
                    };

                    /**
                     * Step tracker — adapts per payment method:
                     *   cash / kaart  →  2 steps: Betaald | Factuur
                     *   online / manual / overig met mollie  →  3 steps: Betaallink | Betaald | Factuur
                     */
                    $paymentSteps = function(\App\Models\Order $order): string {
                        $invoice     = $order->invoice;
                        $paid        = $order->status === 'paid';
                        $receiptSent = $invoice !== null && $invoice->status === 'paid';

                        $isInPerson = in_array($order->payment_method, ['cash', 'kaart']);

                        if ($isInPerson) {
                            // Cash / kaart: geen betaallink stap
                            $methodLabel = $order->payment_method === 'cash' ? __('common.payment_cash') : __('orders.payment_method_card');
                            $steps = [
                                ['label' => __('orders.payment_step_paid'),   'done' => $paid],
                                ['label' => __('orders.payment_step_invoice'), 'done' => $receiptSent],
                            ];
                            $badge = '<span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-white/10 px-1.5 py-0.5 text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">' . $methodLabel . '</span>';
                        } else {
                            // Online / manual: Mollie betaallink flow
                            $invoiceSent = !empty($order->mollie_id);
                            $steps = [
                                ['label' => __('orders.payment_step_payment_link'), 'done' => $invoiceSent],
                                ['label' => __('orders.payment_step_paid'),         'done' => $paid],
                                ['label' => __('orders.payment_step_invoice'),      'done' => $receiptSent],
                            ];
                            $methodLabel = $order->payment_method === 'manual' ? __('orders.payment_method_manual') : __('common.payment_online');
                            $badge = '<span class="inline-flex items-center rounded-md bg-indigo-50 dark:bg-indigo-900/20 px-1.5 py-0.5 text-xs font-medium text-indigo-600 dark:text-indigo-400 mb-1">' . $methodLabel . '</span>';
                        }

                        $html = '<div class="flex flex-col gap-1">';
                        $html .= $badge;
                        $html .= '<div class="flex items-center gap-1">';
                        foreach ($steps as $i => $step) {
                            $dot = $step['done']
                                ? '<span class="inline-flex size-5 items-center justify-center rounded-full bg-indigo-600 text-white dark:bg-indigo-500 text-xs">✓</span>'
                                : '<span class="inline-flex size-5 items-center justify-center rounded-full border-2 border-gray-300 dark:border-white/20 text-gray-400 text-xs">' . ($i + 1) . '</span>';
                            $label = '<span class="text-xs ' . ($step['done'] ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500') . '">' . e($step['label']) . '</span>';
                            $html .= '<div class="flex flex-col items-center gap-0.5">' . $dot . $label . '</div>';
                            if ($i < count($steps) - 1) {
                                $html .= '<div class="mb-4 h-px w-4 ' . ($step['done'] ? 'bg-indigo-600 dark:bg-indigo-500' : 'bg-gray-200 dark:bg-white/10') . '"></div>';
                            }
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        return $html;
                    };
                @endphp

                {{-- Vandaag --}}
                <div class="mt-8">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.today_section_title') }}</h2>
                    @if ($todayOrders->count() > 0)
                        <div class="mt-3 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">{{ __('orders.table_header_number') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_customer') }}</th>
                                                <th scope="col" class="hidden sm:table-cell px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_description') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_time') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_amount') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_status') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white"><span class="sr-only">{{ __('orders.table_header_actions') }}</span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-gray-900">
                                            @foreach ($todayOrders as $order)
                                                @php
                                                    $customerName = trim(($order->customer_first_name ?? $order->customer?->first_name) . ' ' . ($order->customer_last_name ?? $order->customer?->last_name)) ?: '—';
                                                    $hasPdf = $order->invoice && $order->invoice->pdf_url;
                                                @endphp
                                                <tr>
                                                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap sm:pl-6 lg:pl-8">
                                                        @if ($hasPdf)
                                                            <button onclick="openPdfModal('{{ route('orders.invoice', $order) }}')"
                                                                class="text-indigo-600 dark:text-indigo-400 hover:underline font-mono">
                                                                {{ $order->invoice_number ?? '#' . $order->id }}
                                                            </button>
                                                        @elseif ($order->payment_link)
                                                            <a href="{{ route('orders.payment-link', $order) }}" target="_blank"
                                                                class="text-indigo-600 dark:text-indigo-400 hover:underline font-mono">
                                                                {{ $order->invoice_number ?? '#' . $order->id }}
                                                            </a>
                                                        @else
                                                            <span class="text-gray-900 dark:text-white font-mono">{{ $order->invoice_number ?? '#' . $order->id }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        @if ($order->customer_id)
                                                            <a href="{{ route('customers.show.overview', $order->customer_id) }}"
                                                               class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline">
                                                                {{ $customerName }}
                                                            </a>
                                                        @else
                                                            {{ $customerName }}
                                                        @endif
                                                    </td>
                                                    <td class="hidden sm:table-cell px-3 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                                        {{ $order->orderedItems->pluck('item_name')->filter()->join(', ') ?: '—' }}
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        {{ $order->created_at->format('H:i') }}
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        {{ Number::currency($order->total ?? 0) }}
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @if ($order->status === 'cancelled')
                                                            {!! $statusBadge($order->status) !!}
                                                        @elseif ($order->payment_method !== null)
                                                            {!! $paymentSteps($order) !!}
                                                        @else
                                                            {!! $statusBadge($order->status) !!}
                                                        @endif
                                                    </td>
                                                    <td class="py-4 pl-3 pr-4 text-right text-sm whitespace-nowrap sm:pr-6 lg:pr-8">
                                                        <button type="button" onclick="openOrderModal({{ $order->id }})"
                                                            class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                                            {{ __('orders.view_order_button') }}
                                                            <span class="sr-only">{{ __('orders.view_order_sr') }}</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <template id="order-template-{{ $order->id }}">
                                                    <x-order.detail-content :order="$order" />
                                                </template>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            {{ $todayOrders->links() }}
                        </div>
                    @else
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('orders.empty_today') }}</p>
                    @endif
                </div>

                {{-- Eerdere bestellingen --}}
                <div class="mt-10">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.earlier_section_title') }}</h2>

                    @if ($orders->count() > 0)
                        <div class="mt-3 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">{{ __('orders.table_header_number') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_customer') }}</th>
                                                <th scope="col" class="hidden sm:table-cell px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_description') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_date') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_amount') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_status') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white"><span class="sr-only">{{ __('orders.table_header_actions') }}</span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-gray-900">
                                            @foreach ($orders as $order)
                                                @php
                                                    $customerName = trim(($order->customer_first_name ?? $order->customer?->first_name) . ' ' . ($order->customer_last_name ?? $order->customer?->last_name)) ?: '—';
                                                    $hasPdf = $order->invoice && $order->invoice->pdf_url;
                                                @endphp
                                                <tr>
                                                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap sm:pl-6 lg:pl-8">
                                                        @if ($hasPdf)
                                                            <button onclick="openPdfModal('{{ route('orders.invoice', $order) }}')"
                                                                class="text-indigo-600 dark:text-indigo-400 hover:underline font-mono">
                                                                {{ $order->invoice_number ?? '#' . $order->id }}
                                                            </button>
                                                        @elseif ($order->payment_link)
                                                            <a href="{{ route('orders.payment-link', $order) }}" target="_blank"
                                                                class="text-indigo-600 dark:text-indigo-400 hover:underline font-mono">
                                                                {{ $order->invoice_number ?? '#' . $order->id }}
                                                            </a>
                                                        @else
                                                            <span class="text-gray-900 dark:text-white font-mono">{{ $order->invoice_number ?? '#' . $order->id }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @if ($order->customer_id)
                                                            <a href="{{ route('customers.show.overview', $order->customer_id) }}"
                                                               class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline">
                                                                {{ $customerName }}
                                                            </a>
                                                        @else
                                                            <span class="text-gray-600 dark:text-gray-400">{{ $customerName }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="hidden sm:table-cell px-3 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                                        {{ $order->orderedItems->pluck('item_name')->filter()->join(', ') ?: '—' }}
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        {{ $order->created_at->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        {{ Number::currency($order->total ?? 0) }}
                                                    </td>
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @if ($order->status === 'cancelled')
                                                            {!! $statusBadge($order->status) !!}
                                                        @elseif ($order->payment_method !== null)
                                                            {!! $paymentSteps($order) !!}
                                                        @else
                                                            {!! $statusBadge($order->status) !!}
                                                        @endif
                                                    </td>
                                                    <td class="py-4 pl-3 pr-4 text-right text-sm whitespace-nowrap sm:pr-6 lg:pr-8">
                                                        <button type="button" onclick="openOrderModal({{ $order->id }})"
                                                            class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                                            {{ __('orders.view_order_button') }}
                                                            <span class="sr-only">{{ __('orders.view_order_sr') }}</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <template id="order-template-{{ $order->id }}">
                                                    <x-order.detail-content :order="$order" />
                                                </template>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('orders.empty_earlier') }}</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @if (session('gift_vouchers'))
        {{-- Gift voucher codes modal --}}
        <div id="gift-voucher-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
             onclick="if(event.target===this) this.classList.add('hidden')">
            <div class="w-full max-w-md rounded-xl border border-gray-200 bg-white dark:border-white/10 dark:bg-gray-900 overflow-hidden shadow-2xl">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-white/10">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">{{ trans_choice('orders.voucher_modal_title', count(session('gift_vouchers'))) }}</h2>
                    <button type="button" onclick="document.getElementById('gift-voucher-modal').classList.add('hidden')"
                        class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ trans_choice('orders.voucher_modal_description', count(session('gift_vouchers'))) }}</p>
                    @foreach (session('gift_vouchers') as $voucher)
                        <div class="rounded-lg border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 px-4 py-3">
                            @if ($voucher['gift_card_name'])
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $voucher['gift_card_name'] }} &middot; {{ Number::currency($voucher['amount']) }}</p>
                            @else
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ Number::currency($voucher['amount']) }}</p>
                            @endif
                            <p class="font-mono tracking-widest text-lg font-semibold text-gray-900 dark:text-white select-all">{{ $voucher['code'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-white/10">
                    <button type="button" onclick="document.getElementById('gift-voucher-modal').classList.add('hidden')"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                        {{ __('orders.voucher_modal_close') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- PDF Modal --}}
    <div id="pdf-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         onclick="closePdfModal(event)">
        <div class="relative w-full max-w-4xl h-[85vh] bg-white dark:bg-gray-900 rounded-xl shadow-2xl flex flex-col overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-white/10">
                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.pdf_modal_invoice') }}</span>
                <div class="flex items-center gap-2">
                    <a id="pdf-download-link" href="#" download
                       class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        {{ __('orders.pdf_modal_download') }}
                    </a>
                    <button onclick="closePdfModal()" class="rounded-lg p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <iframe id="pdf-frame" src="" class="flex-1 w-full border-0"></iframe>
        </div>
    </div>

    {{-- Order detail modal --}}
    <div id="order-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         onclick="closeOrderModal(event)">
        <div class="relative w-full max-w-2xl max-h-[85vh] bg-white dark:bg-gray-900 rounded-xl shadow-2xl flex flex-col overflow-hidden">
            <div class="flex items-center justify-end px-4 py-3 border-b border-gray-200 dark:border-white/10">
                <button onclick="closeOrderModal()" class="rounded-lg p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="order-modal-content" class="flex-1 overflow-y-auto px-6 py-4"></div>
        </div>
    </div>

    <script>
        function openPdfModal(url) {
            document.getElementById('pdf-frame').src = url;
            document.getElementById('pdf-download-link').href = url;
            var modal = document.getElementById('pdf-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closePdfModal(e) {
            if (e && e.target !== document.getElementById('pdf-modal')) return;
            var modal = document.getElementById('pdf-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('pdf-frame').src = '';
            document.body.style.overflow = '';
        }

        function openOrderModal(orderId) {
            var template = document.getElementById('order-template-' + orderId);
            if (!template) return;
            document.getElementById('order-modal-content').innerHTML = template.innerHTML;
            var modal = document.getElementById('order-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeOrderModal(e) {
            if (e && e.target !== document.getElementById('order-modal')) return;
            var modal = document.getElementById('order-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('order-modal-content').innerHTML = '';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePdfModal();
                closeOrderModal();
            }
        });
    </script>
</x-layouts.app>
