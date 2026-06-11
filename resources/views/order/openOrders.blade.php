<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('orders.index_title'), 'url' => route('orders.index')],
        ['name' => __('orders.open_orders_title'), 'url' => route('orders.open-orders')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-6 pb-4">
        <div class="px-4 sm:px-6 lg:px-8">

            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('orders.open_orders_title') }}</h1>
                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ __('orders.open_orders_description') }}</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm text-green-700 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm text-red-700 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mt-6">
                <x-order.tabs />

                {{-- Stats --}}
                <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('orders.stat_outstanding') }}</p>
                        <p class="mt-1 text-xl font-semibold text-orange-600 dark:text-orange-400">{{ $stats['count'] }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.stat_orders') }}</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('orders.stat_outstanding_amount') }}</p>
                        <p class="mt-1 text-xl font-semibold text-orange-600 dark:text-orange-400">{{ Number::currency($stats['total']) }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.stat_total_to_receive') }}</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('orders.stat_invoices_sent') }}</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['online'] }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.stat_online_payment') }}</p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="mt-8">
                    @if ($orders->count() > 0)
                        <div class="flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">{{ __('orders.table_header_customer') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_amount') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_payment_method') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_invoice_number') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_date') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('orders.table_header_wait_time') }}</th>
                                                <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8"><span class="sr-only">{{ __('orders.table_header_actions_sr') }}</span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-gray-900">
                                            @foreach ($orders as $order)
                                                @php
                                                    $daysAgo = (int) $order->created_at->diffInDays(now());
                                                    $urgency = $daysAgo >= 30 ? 'red' : ($daysAgo >= 14 ? 'orange' : 'gray');
                                                    $customerName = trim(($order->customer_first_name ?? '') . ' ' . ($order->customer_last_name ?? ''))
                                                        ?: ($order->customer ? trim($order->customer->first_name . ' ' . $order->customer->last_name) : '—');
                                                    $hasPdf = $order->invoice && $order->invoice->pdf_url;
                                                    $onlineDue = round((float) $order->amount_online - (float) $order->amount_paid_online, 2);
                                                    $onsiteDue = round((float) $order->amount_onsite - (float) $order->amount_paid_onsite, 2);
                                                    $hasSplit = (float) $order->amount_online > 0 || (float) $order->amount_onsite > 0;
                                                @endphp
                                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                                    {{-- Customer --}}
                                                    <td class="py-4 pr-3 pl-4 text-sm sm:pl-6 lg:pl-8">
                                                        @if ($order->customer_id)
                                                            <a href="{{ route('customers.show.overview', $order->customer_id) }}"
                                                               class="font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline">
                                                                {{ $customerName }}
                                                            </a>
                                                        @else
                                                            <span class="font-medium text-gray-900 dark:text-white">{{ $customerName }}</span>
                                                        @endif
                                                        @if ($order->customer_email)
                                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $order->customer_email }}</p>
                                                        @endif
                                                    </td>

                                                    {{-- Amount --}}
                                                    <td class="px-3 py-4 text-sm font-semibold whitespace-nowrap text-gray-900 dark:text-white">
                                                        {{ Number::currency($order->total ?? 0) }}
                                                        @if ($hasSplit)
                                                            <div class="mt-1 flex flex-col gap-0.5 text-xs font-normal">
                                                                <span class="{{ $onlineDue > 0 ? 'text-orange-600 dark:text-orange-400' : 'text-gray-400 dark:text-gray-500 line-through' }}">
                                                                    {{ __('orders.amount_online_label') }}: {{ Number::currency($order->amount_online) }}
                                                                </span>
                                                                <span class="{{ $onsiteDue > 0 ? 'text-orange-600 dark:text-orange-400' : 'text-gray-400 dark:text-gray-500 line-through' }}">
                                                                    {{ __('orders.amount_onsite_label') }}: {{ Number::currency($order->amount_onsite) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    {{-- Payment method --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @if ($order->payment_method === 'online')
                                                            <span class="inline-flex items-center rounded-md bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 text-xs font-medium text-indigo-700 dark:text-indigo-400 ring-1 ring-inset ring-indigo-700/10">{{ __('common.payment_online') }}</span>
                                                        @elseif ($order->payment_method === 'manual')
                                                            <span class="inline-flex items-center rounded-md bg-purple-50 dark:bg-purple-900/20 px-2 py-1 text-xs font-medium text-purple-700 dark:text-purple-400 ring-1 ring-inset ring-purple-700/10">{{ __('orders.payment_method_manual_badge') }}</span>
                                                        @else
                                                            <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">{{ $order->payment_method ?? '—' }}</span>
                                                        @endif
                                                    </td>

                                                    {{-- Invoice number --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        @if ($order->invoice_number)
                                                            @if ($hasPdf)
                                                                <button onclick="openPdfModal('{{ route('orders.invoice', $order) }}')"
                                                                    class="font-mono text-xs hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline cursor-pointer">
                                                                    {{ $order->invoice_number }}
                                                                </button>
                                                            @elseif ($order->payment_link)
                                                                <a href="{{ route('orders.payment-link', $order) }}" target="_blank"
                                                                   class="font-mono text-xs hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline">
                                                                    {{ $order->invoice_number }}
                                                                </a>
                                                            @else
                                                                <span class="font-mono text-xs">{{ $order->invoice_number }}</span>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-300 dark:text-gray-600">—</span>
                                                        @endif
                                                    </td>

                                                    {{-- Date --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        {{ $order->created_at->format('d/m/Y') }}
                                                    </td>

                                                    {{-- Wachttijd --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @php
                                                            $urgencyClasses = [
                                                                'red'    => 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 ring-red-600/20',
                                                                'orange' => 'bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 ring-orange-600/20',
                                                                'gray'   => 'bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 ring-gray-500/20',
                                                            ];
                                                        @endphp
                                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $urgencyClasses[$urgency] }}">
                                                            {{ trans_choice('orders.wait_days', $daysAgo, ['count' => $daysAgo]) }}
                                                        </span>
                                                    </td>

                                                    {{-- Actions --}}
                                                    <td class="py-4 pr-4 pl-3 text-right text-sm whitespace-nowrap sm:pr-6 lg:pr-8">
                                                        @php
                                                            $canRemind = $order->customer_email && ($order->payment_link || $order->mollie_id)
                                                                && (
                                                                    ($order->payment_method === 'online' && (float) $order->total > 0)
                                                                    || ($order->payment_method === 'manual' && $onlineDue > 0)
                                                                );
                                                            $canMarkOnsite = $order->payment_method === 'manual' && $onsiteDue > 0;
                                                        @endphp
                                                        @if ($canMarkOnsite)
                                                            <form method="POST" action="{{ route('orders.mark-onsite-paid', $order) }}" class="inline">
                                                                @csrf
                                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-xs font-medium cursor-pointer">
                                                                    {{ __('orders.mark_onsite_paid_button') }}
                                                                </button>
                                                            </form>
                                                            <span class="mx-2 text-gray-300 dark:text-gray-700">|</span>
                                                        @endif
                                                        @if ($canRemind)
                                                            <form method="POST" action="{{ route('orders.send-payment-reminder', $order) }}" class="inline">
                                                                @csrf
                                                                <button type="submit" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-xs font-medium cursor-pointer">
                                                                    {{ __('orders.send_reminder_button') }}
                                                                </button>
                                                            </form>
                                                            <span class="mx-2 text-gray-300 dark:text-gray-700">|</span>
                                                        @endif
                                                        <a href="{{ route('orders.index') }}?search={{ urlencode($order->invoice_number ?? $order->id) }}"
                                                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-xs font-medium">
                                                            {{ __('orders.view_link') }}
                                                        </a>
                                                    </td>
                                                </tr>
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
                        <div class="mt-6 text-center py-16 rounded-xl border border-dashed border-gray-300 dark:border-white/10">
                            <svg class="mx-auto h-10 w-10 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('orders.empty_no_outstanding') }}</p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">{{ __('orders.empty_all_paid') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePdfModal();
        });
    </script>
</x-layouts.app>
