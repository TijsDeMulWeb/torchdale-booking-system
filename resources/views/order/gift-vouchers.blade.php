<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Bestellingen', 'url' => route('orders.index')],
        ['name' => 'Cadeaubonnen', 'url' => route('orders.gift-vouchers')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-6 pb-4">
        <div class="px-4 sm:px-6 lg:px-8">

            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">Cadeaubonnen</h1>
                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Overzicht van alle uitgegeven cadeauboncodes.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button" onclick="document.getElementById('create-voucher-overlay').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Cadeaubon aanmaken
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm text-green-700 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-6">
                <x-order.tabs />

                {{-- Stats --}}
                <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4">
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Totaal uitgegeven</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Alle bonnen</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Actief</p>
                        <p class="mt-1 text-xl font-semibold text-green-600 dark:text-green-400">{{ $stats['active'] }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Nog niet ingelost</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Ingelost</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['used'] }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Gebruikt</p>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-5 py-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Openstaande waarde</p>
                        <p class="mt-1 text-xl font-semibold text-indigo-600 dark:text-indigo-400">{{ Number::currency($stats['value']) }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Actieve bonnen</p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="mt-8">
                    @if ($vouchers->count() > 0)
                        <div class="flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">Code</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Klant</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Waarde</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Bron</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Levering</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Geldig tot</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Aangemaakt</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-gray-900">
                                            @foreach ($vouchers as $voucher)
                                                @php
                                                    $isExpired = $voucher->valid_until && $voucher->valid_until->isPast() && $voucher->status === 'active';
                                                    $customerName = $voucher->customer
                                                        ? trim($voucher->customer->first_name . ' ' . $voucher->customer->last_name)
                                                        : '—';
                                                @endphp
                                                <tr>
                                                    {{-- Code --}}
                                                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap sm:pl-6 lg:pl-8">
                                                        <span class="font-mono tracking-widest text-gray-900 dark:text-white select-all">{{ $voucher->code }}</span>
                                                    </td>

                                                    {{-- Customer --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        @if ($voucher->customer_id)
                                                            <a href="{{ route('customers.show.overview', $voucher->customer_id) }}"
                                                               class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline">
                                                                {{ $customerName }}
                                                            </a>
                                                        @else
                                                            {{ $customerName }}
                                                        @endif
                                                    </td>

                                                    {{-- Amount --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                                        {{ Number::currency($voucher->amount) }}
                                                    </td>

                                                    {{-- Source --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @if ($voucher->source === 'cancellation')
                                                            <span class="inline-flex items-center rounded-md bg-orange-50 dark:bg-orange-900/20 px-2 py-1 text-xs font-medium text-orange-700 dark:text-orange-400 ring-1 ring-inset ring-orange-600/20">Annulering</span>
                                                        @else
                                                            <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/20 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-400 ring-1 ring-inset ring-blue-600/20">Aankoop</span>
                                                        @endif
                                                    </td>

                                                    {{-- Delivery method --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @php
                                                            $delivery = match($voucher->delivery_method) {
                                                                'post'   => ['label' => 'Per post',  'class' => 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 ring-purple-600/20'],
                                                                'pickup' => ['label' => 'Afhalen',   'class' => 'bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 ring-teal-600/20'],
                                                                default  => ['label' => 'E-mail',    'class' => 'bg-sky-50 dark:bg-sky-900/20 text-sky-700 dark:text-sky-400 ring-sky-600/20'],
                                                            };
                                                        @endphp
                                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $delivery['class'] }}">
                                                            {{ $delivery['label'] }}
                                                        </span>
                                                        @if ($voucher->delivery_method === 'post' && $voucher->shipping_cost > 0)
                                                            <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">
                                                                + {{ Number::currency($voucher->shipping_cost) }}
                                                            </span>
                                                        @endif
                                                    </td>

                                                    {{-- Valid until --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        @if ($voucher->valid_until)
                                                            <span class="{{ $isExpired ? 'text-red-500 dark:text-red-400' : '' }}">
                                                                {{ $voucher->valid_until->format('d/m/Y') }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">—</span>
                                                        @endif
                                                    </td>

                                                    {{-- Created at --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                        {{ $voucher->created_at->format('d/m/Y') }}
                                                    </td>

                                                    {{-- Status --}}
                                                    <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                        @if ($isExpired)
                                                            <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">Verlopen</span>
                                                        @elseif ($voucher->status === 'used')
                                                            <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">
                                                                Ingelost
                                                                @if ($voucher->used_at)
                                                                    <span class="ml-1 text-gray-400">{{ $voucher->used_at->format('d/m/Y') }}</span>
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Actief</span>
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
                            {{ $vouchers->links() }}
                        </div>
                    @else
                        <div class="mt-6 text-center py-12 rounded-xl border border-dashed border-gray-300 dark:border-white/10">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nog geen cadeaubonnen uitgegeven.</p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Bonnen worden automatisch aangemaakt bij aankoop of bij het annuleren van een boeking.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    {{-- Create voucher modal --}}
    <div id="create-voucher-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
         onclick="if(event.target===this) this.classList.add('hidden')">
        <div class="w-full max-w-md rounded-xl border border-gray-200 bg-white dark:border-white/10 dark:bg-gray-900 overflow-hidden shadow-2xl">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-white/10">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Cadeaubon aanmaken</h2>
                <button type="button" onclick="document.getElementById('create-voucher-overlay').classList.add('hidden')"
                    class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('orders.gift-vouchers.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Amount --}}
                <div>
                    <label for="vc-amount" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Waarde <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">€</span>
                        <input type="number" id="vc-amount" name="amount" min="1" max="9999" step="0.01"
                            placeholder="0.00" required
                            class="w-full pl-7 pr-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-white/15 bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                {{-- Valid until --}}
                <div>
                    <label for="vc-valid-until" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Geldig tot <span class="text-gray-400 font-normal">(standaard 1 jaar)</span>
                    </label>
                    <input type="date" id="vc-valid-until" name="valid_until"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        value="{{ now()->addYear()->format('Y-m-d') }}"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-white/15 bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Delivery method --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Leveringswijze <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach ([
                            ['value' => 'mail',   'label' => 'E-mail',    'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
                            ['value' => 'post',   'label' => 'Per post',  'icon' => 'M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.235 2.235 0 00-.1.661z'],
                            ['value' => 'pickup', 'label' => 'Afhalen',   'icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z'],
                        ] as $opt)
                            <label class="relative flex flex-col items-center gap-1.5 rounded-lg border-2 px-3 py-3 cursor-pointer transition-colors
                                has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/20
                                border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20">
                                <input type="radio" name="delivery_method" value="{{ $opt['value'] }}"
                                    {{ $opt['value'] === 'mail' ? 'checked' : '' }}
                                    onchange="toggleShippingCost(this.value)"
                                    class="sr-only">
                                <svg class="h-5 w-5 text-gray-400 has-[:checked]:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $opt['icon'] }}"/>
                                </svg>
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $opt['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Shipping cost — only visible when 'post' is selected --}}
                <div id="shipping-cost-field" class="hidden">
                    <label for="vc-shipping-cost" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Verzendkosten</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">€</span>
                        <input type="number" id="vc-shipping-cost" name="shipping_cost" min="0" max="99.99" step="0.01"
                            placeholder="0.00"
                            class="w-full pl-7 pr-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-white/15 bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Wordt apart geregistreerd, bovenop de waarde van de bon.</p>
                </div>

                {{-- Preview --}}
                <div class="rounded-lg bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 px-4 py-3">
                    <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium mb-1">De code wordt automatisch gegenereerd</p>
                    <p class="text-xs text-indigo-500 dark:text-indigo-500">Formaat: <span class="font-mono">XXXX-XXXX-XXXX-XXXX</span></p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100 dark:border-white/10">
                    <button type="button" onclick="document.getElementById('create-voucher-overlay').classList.add('hidden')"
                        class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Annuleren</button>
                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                        Aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
function toggleShippingCost(value) {
    const field = document.getElementById('shipping-cost-field');
    const input = document.getElementById('vc-shipping-cost');
    if (value === 'post') {
        field.classList.remove('hidden');
    } else {
        field.classList.add('hidden');
        input.value = '';
    }
}
</script>
</x-layouts.app>
