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
                <div class="border-b border-gray-200 dark:border-white/10">
                    <nav class="-mb-px flex gap-x-6" aria-label="Tabs">
                        <button
                            id="tab-btn-overview"
                            onclick="switchTab('overview')"
                            class="tab-btn whitespace-nowrap border-b-2 px-1 pb-3 text-sm font-medium border-indigo-500 text-indigo-600 dark:text-white dark:border-white"
                            aria-current="page">
                            Overzicht
                        </button>
                    </nav>
                </div>

                <div id="tab-overview" class="tab-panel">
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
                                                    <tr>
                                                        <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 dark:text-white sm:pl-6 lg:pl-8">
                                                            {{ $order->invoice_number ?? '#' . $order->id }}
                                                        </td>
                                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                            {{ trim(($order->customer_first_name ?? $order->customer?->first_name) . ' ' . ($order->customer_last_name ?? $order->customer?->last_name)) ?: '—' }}
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
                                                            @if ($order->status === 'paid')
                                                                <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Betaald</span>
                                                            @elseif ($order->status === 'pending')
                                                                <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">In behandeling</span>
                                                            @else
                                                                <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">{{ $order->status }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Geen bestellingen vandaag.</p>
                        @endif
                    </div>

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
                                                    <tr>
                                                        <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 dark:text-white sm:pl-6 lg:pl-8">
                                                            {{ $order->invoice_number ?? '#' . $order->id }}
                                                        </td>
                                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                            {{ trim(($order->customer_first_name ?? $order->customer?->first_name) . ' ' . ($order->customer_last_name ?? $order->customer?->last_name)) ?: '—' }}
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
                                                            @if ($order->status === 'paid')
                                                                <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Betaald</span>
                                                            @elseif ($order->status === 'pending')
                                                                <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">In behandeling</span>
                                                            @else
                                                                <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">{{ $order->status }}</span>
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
    </div>
</x-layouts.app>
