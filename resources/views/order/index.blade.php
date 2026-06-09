<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Bestellingen', 'url' => route('orders.index')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-6 pb-4">
        <div class="px-4 sm:px-6 lg:px-8">

            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">Bestellingen</h1>
                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Overzicht van bestellingen.</p>
                </div>
            </div>

            <div class="mt-6">
                <x-order.tabs />

                <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4">
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Omzet vandaag</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ Number::currency($todayRevenue) }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Betaalde bestellingen</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Totale omzet</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ Number::currency($totalRevenue) }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Betaalde bestellingen</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Bestellingen vandaag</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $todayOrderCount }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Alle statussen</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Totaal bestellingen</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $totalOrderCount }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Alle statussen</p>
                    </div>
                </div>

                @php
                    $statusBadge = function(string $status): string {
                        return match($status) {
                            'paid'      => '<span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Betaald</span>',
                            'pending'   => '<span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">Open</span>',
                            'cancelled' => '<span class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/20 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/20">Geannuleerd</span>',
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
                        $receiptSent = $invoice !== null;

                        $isInPerson = in_array($order->payment_method, ['cash', 'kaart']);

                        if ($isInPerson) {
                            // Cash / kaart: geen betaallink stap
                            $methodLabel = $order->payment_method === 'cash' ? 'Cash' : 'Kaart';
                            $steps = [
                                ['label' => 'Betaald',  'done' => $paid],
                                ['label' => 'Factuur',  'done' => $receiptSent],
                            ];
                            $badge = '<span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-white/10 px-1.5 py-0.5 text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">' . $methodLabel . '</span>';
                        } else {
                            // Online / manual: Mollie betaallink flow
                            $invoiceSent = !empty($order->mollie_id);
                            $steps = [
                                ['label' => 'Betaallink', 'done' => $invoiceSent],
                                ['label' => 'Betaald',    'done' => $paid],
                                ['label' => 'Factuur',    'done' => $receiptSent],
                            ];
                            $methodLabel = $order->payment_method === 'manual' ? 'Handmatig' : 'Online';
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
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Bestellingen vandaag</h2>
                    @if ($todayOrders->count() > 0)
                        <div class="mt-3 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">#</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Klant</th>
                                                <th scope="col" class="hidden sm:table-cell px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Omschrijving</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Tijdstip</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Bedrag</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
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
                                                </tr>
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
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Geen bestellingen vandaag.</p>
                    @endif
                </div>

                {{-- Eerdere bestellingen --}}
                <div class="mt-10">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Eerdere bestellingen</h2>

                    @if ($orders->count() > 0)
                        <div class="mt-3 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">#</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Klant</th>
                                                <th scope="col" class="hidden sm:table-cell px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Omschrijving</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Datum</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Bedrag</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
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
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Geen eerdere bestellingen.</p>
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
                <span class="text-sm font-semibold text-gray-900 dark:text-white">Factuur</span>
                <div class="flex items-center gap-2">
                    <a id="pdf-download-link" href="#" download
                       class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download
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
