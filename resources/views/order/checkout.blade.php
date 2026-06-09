<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Bestellingen', 'url' => route('orders.index')],
        ['name' => 'Afrekenen', 'url' => route('orders.checkout')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-6 pb-4">
        <div class="px-4 sm:px-6 lg:px-8">

            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">Bestellingen</h1>
                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Nieuwe bestelling aanmaken en afrekenen.</p>
                </div>
            </div>

            <div class="mt-6">
                <x-order.tabs />
                <div class="lg:hidden mt-4">
                    <button
                        id="mobile-cart-toggle"
                        onclick="toggleMobileCart()"
                        class="flex w-full items-center justify-between rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-indigo-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Winkelwagen
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ Number::currency(0) }}</span>
                            <svg id="mobile-cart-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-400 transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-start lg:gap-6">
                    <div class="flex-1 min-w-0 flex flex-col gap-4">
                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Klant</label>

                            <div id="selected-customer" class="hidden mb-3 flex items-center justify-between rounded-lg bg-indigo-50 dark:bg-indigo-900/20 px-3 py-2.5 border border-indigo-200 dark:border-indigo-500/30">
                                <div>
                                    <p id="selected-customer-name" class="text-sm font-medium text-indigo-900 dark:text-indigo-100"></p>
                                    <p id="selected-customer-email" class="text-xs text-indigo-600 dark:text-indigo-400"></p>
                                </div>
                                <button onclick="clearCustomer()" type="button" class="ml-3 text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div id="customer-search-wrap" class="relative">
                                <input
                                    id="customer-search-input"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="Naam of e-mailadres..."
                                    class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2.5 pl-9 pr-4 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="pointer-events-none absolute left-3 top-2.5 size-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.25 11.25Z" />
                                </svg>

                                <ul id="customer-dropdown" class="hidden absolute z-20 mt-1 w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 shadow-lg overflow-hidden"></ul>
                            </div>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Producten</h3>
                                <div class="flex flex-wrap gap-1.5">
                                    <button onclick="filterItems('all')" data-filter="all" class="filter-btn rounded-md px-3 py-1.5 text-xs font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5">Alles</button>
                                    <button onclick="filterItems('room')" data-filter="room" class="filter-btn rounded-md bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1.5 text-xs font-medium text-indigo-700 dark:text-indigo-300">Kamers ({{ $rooms->count() }})</button>
                                    <button onclick="filterItems('product')" data-filter="product" class="filter-btn rounded-md px-3 py-1.5 text-xs font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5">Producten ({{ $products->count() }})</button>
                                    <button onclick="filterItems('giftcard')" data-filter="giftcard" class="filter-btn rounded-md px-3 py-1.5 text-xs font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5">Cadeaubonnen ({{ $giftCards->count() }})</button>
                                </div>
                            </div>

                            <div id="items-grid" class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-4">
                                @forelse ($rooms as $room)
                                    @php $basePrice = $room->prices->min('base_price'); $noPrice = !$basePrice; @endphp
                                    <button
                                        @if(!$noPrice) onclick="addToCart(this)" @endif
                                        data-type="room"
                                        data-id="{{ $room->id }}"
                                        data-name="{{ $room->name }}"
                                        data-price="{{ $basePrice ?? 0 }}"
                                        data-vat="0"
                                        data-stock="-1"
                                        @if($noPrice) disabled @endif
                                        class="item-card group flex flex-col items-start rounded-lg border p-3 text-left transition-colors
                                            {{ $noPrice
                                                ? 'border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/[0.02] opacity-50 cursor-not-allowed'
                                                : 'border-gray-200 dark:border-white/10 hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/20' }}">
                                        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/40 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-medium text-gray-900 dark:text-white leading-snug">{{ $room->name }}</span>
                                        <span class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                            {{ $basePrice ? 'v.a. ' . Number::currency($basePrice) : 'Prijs niet ingesteld' }}
                                        </span>
                                        @if($noPrice)
                                            <span class="mt-1 inline-flex items-center rounded px-1.5 py-0.5 text-xs font-medium bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400">Geen prijs</span>
                                        @endif
                                    </button>
                                @empty
                                @endforelse

                                @forelse ($products as $product)
                                    @php $outOfStock = !is_null($product->stock_quantity) && $product->stock_quantity <= 0; @endphp
                                    <button
                                        @if(!$outOfStock) onclick="addToCart(this)" @endif
                                        data-type="product"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->selling_price ?? 0 }}"
                                        data-vat="{{ $product->vat_percentage ?? 0 }}"
                                        data-stock="{{ $product->stock_quantity ?? -1 }}"
                                        @if($outOfStock) disabled @endif
                                        class="item-card group flex flex-col items-start rounded-lg border p-3 text-left transition-colors
                                            {{ $outOfStock
                                                ? 'border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/[0.02] opacity-50 cursor-not-allowed'
                                                : 'border-gray-200 dark:border-white/10 hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/20' }}">
                                        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/40 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-medium text-gray-900 dark:text-white leading-snug">{{ $product->name }}</span>
                                        <span class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                            {{ $product->selling_price ? Number::currency($product->selling_price) : '—' }}
                                        </span>
                                        @if($outOfStock)
                                            <span class="mt-1 inline-flex items-center rounded px-1.5 py-0.5 text-xs font-medium bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">Uitverkocht</span>
                                        @elseif(!is_null($product->stock_quantity) && $product->stock_quantity <= 5)
                                            <span class="mt-1 inline-flex items-center rounded px-1.5 py-0.5 text-xs font-medium bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">Nog {{ $product->stock_quantity }} op voorraad</span>
                                        @endif
                                    </button>
                                @empty
                                @endforelse

                                @forelse ($giftCards as $giftCard)
                                    <button
                                        onclick="addToCart(this)"
                                        data-type="giftcard"
                                        data-id="{{ $giftCard->id }}"
                                        data-name="{{ $giftCard->name }}"
                                        data-price="{{ $giftCard->amount ?? 0 }}"
                                        data-vat="0"
                                        data-stock="-1"
                                        class="item-card group flex flex-col items-start rounded-lg border border-gray-200 dark:border-white/10 p-3 text-left hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/40 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H4.5a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-medium text-gray-900 dark:text-white leading-snug">{{ $giftCard->name }}</span>
                                        <span class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                            {{ $giftCard->amount ? Number::currency($giftCard->amount) : '—' }}
                                        </span>
                                    </button>
                                @empty
                                @endforelse

                                @if ($rooms->isEmpty() && $products->isEmpty() && $giftCards->isEmpty())
                                    <div class="col-span-full flex flex-col items-center justify-center py-10 text-center">
                                        <p class="text-sm text-gray-400 dark:text-gray-500">Geen items gevonden.</p>
                                    </div>
                                @endif
                            </div>

                            <div id="items-empty" class="hidden py-8 text-center">
                                <p class="text-sm text-gray-400 dark:text-gray-500">Geen items in deze categorie.</p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Kortingscode</label>
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    placeholder="Voer code in..."
                                    class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2.5 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                <button class="rounded-lg border border-gray-300 dark:border-white/10 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    Toepassen
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:flex lg:w-80 xl:w-96 flex-col gap-3 lg:sticky lg:top-6">
                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Winkelwagen</h3>

                            <div id="cart-empty-state" class="flex flex-col items-center justify-center py-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="size-10 text-gray-300 dark:text-gray-600 mb-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                                <p class="text-sm text-gray-400 dark:text-gray-500">Nog geen items toegevoegd</p>
                            </div>

                            <ul id="cart-items-list" class="hidden divide-y divide-gray-100 dark:divide-white/5 -mx-1"></ul>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4 space-y-2">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>Subtotaal</span><span id="cart-subtotaal">€ 0,00</span></div>
                            <div id="cart-korting-row" class="hidden flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>Korting</span><span id="cart-korting" class="text-green-600 dark:text-green-400"></span></div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>BTW</span><span id="cart-btw">€ 0,00</span></div>
                            <div class="border-t border-gray-200 dark:border-white/10 pt-2 flex justify-between text-base font-semibold text-gray-900 dark:text-white"><span>Totaal</span><span id="cart-totaal">€ 0,00</span></div>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-3">Betaalmethode</p>
                            <div class="grid grid-cols-3 gap-2">
                                <button data-method="kaart" onclick="selectPayment('kaart')" class="payment-btn flex flex-col items-center gap-1.5 rounded-lg border-2 border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 p-3 text-xs font-medium text-indigo-700 dark:text-indigo-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                    </svg>
                                    Kaart
                                </button>
                                <button data-method="cash" onclick="selectPayment('cash')" class="payment-btn flex flex-col items-center gap-1.5 rounded-lg border-2 border-gray-200 dark:border-white/10 p-3 text-xs font-medium text-gray-600 dark:text-gray-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75" />
                                    </svg>
                                    Cash
                                </button>
                                <button data-method="online" onclick="selectPayment('online')" class="payment-btn flex flex-col items-center gap-1.5 rounded-lg border-2 border-gray-200 dark:border-white/10 p-3 text-xs font-medium text-gray-600 dark:text-gray-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                    </svg>
                                    Online
                                </button>
                            </div>

                            <div id="payment-term-block" class="hidden mt-4 border-t border-gray-100 dark:border-white/5 pt-4">
                                <label for="payment_term" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Betaaltermijn</label>
                                <select
                                    id="payment_term"
                                    name="payment_term"
                                    class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2.5 px-3 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <option value="7">7 dagen</option>
                                    <option value="14">14 dagen</option>
                                    <option value="30" selected>30 dagen (standaard)</option>
                                    <option value="45">45 dagen</option>
                                    <option value="60">60 dagen</option>
                                    <option value="90">90 dagen</option>
                                    <option value="120">120 dagen</option>
                                </select>
                                <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Factuur wordt verstuurd naar het e-mailadres van de klant.</p>
                            </div>
                        </div>

                        <button class="w-full rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400 transition-colors">
                            Bestelling plaatsen
                        </button>
                    </div>

                    <div id="mobile-cart-panel" class="hidden lg:hidden flex-col gap-3">

                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Winkelwagen</h3>

                            <div id="cart-empty-state-mobile" class="flex flex-col items-center justify-center py-6 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="size-10 text-gray-300 dark:text-gray-600 mb-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                                <p class="text-sm text-gray-400 dark:text-gray-500">Nog geen items toegevoegd</p>
                            </div>

                            <ul id="cart-items-list-mobile" class="hidden divide-y divide-gray-100 dark:divide-white/5 -mx-1"></ul>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4 space-y-2">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>Subtotaal</span><span id="cart-subtotaal-mobile">€ 0,00</span></div>
                            <div id="cart-korting-row-mobile" class="hidden flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>Korting</span><span id="cart-korting-mobile" class="text-green-600 dark:text-green-400"></span></div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>BTW</span><span id="cart-btw-mobile">€ 0,00</span></div>
                            <div class="border-t border-gray-200 dark:border-white/10 pt-2 flex justify-between text-base font-semibold text-gray-900 dark:text-white"><span>Totaal</span><span id="cart-totaal-mobile">€ 0,00</span></div>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-3">Betaalmethode</p>
                            <div class="grid grid-cols-3 gap-2">
                                <button data-method="kaart" onclick="selectPayment('kaart')" class="payment-btn flex flex-col items-center gap-1.5 rounded-lg border-2 border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 p-3 text-xs font-medium text-indigo-700 dark:text-indigo-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                                    Kaart
                                </button>
                                <button data-method="cash" onclick="selectPayment('cash')" class="payment-btn flex flex-col items-center gap-1.5 rounded-lg border-2 border-gray-200 dark:border-white/10 p-3 text-xs font-medium text-gray-600 dark:text-gray-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75" /></svg>
                                    Cash
                                </button>
                                <button data-method="online" onclick="selectPayment('online')" class="payment-btn flex flex-col items-center gap-1.5 rounded-lg border-2 border-gray-200 dark:border-white/10 p-3 text-xs font-medium text-gray-600 dark:text-gray-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" /></svg>
                                    Online
                                </button>
                            </div>

                            <div id="payment-term-block-mobile" class="hidden mt-4 border-t border-gray-100 dark:border-white/5 pt-4">
                                <label for="payment_term_mobile" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Betaaltermijn</label>
                                <select
                                    id="payment_term_mobile"
                                    name="payment_term"
                                    class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2.5 px-3 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <option value="7">7 dagen</option>
                                    <option value="14">14 dagen</option>
                                    <option value="30" selected>30 dagen (standaard)</option>
                                    <option value="45">45 dagen</option>
                                    <option value="60">60 dagen</option>
                                    <option value="90">90 dagen</option>
                                    <option value="120">120 dagen</option>
                                </select>
                                <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Factuur wordt verstuurd naar het e-mailadres van de klant.</p>
                            </div>
                        </div>

                        <button class="w-full rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                            Bestelling plaatsen
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var customerSearchUrl = '{{ route('customers.search') }}';
        var selectedCustomerId = null;
        var searchTimer = null;

        var searchInput    = document.getElementById('customer-search-input');
        var dropdown       = document.getElementById('customer-dropdown');
        var selectedChip   = document.getElementById('selected-customer');
        var selectedName   = document.getElementById('selected-customer-name');
        var selectedEmail  = document.getElementById('selected-customer-email');
        var searchWrap     = document.getElementById('customer-search-wrap');

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);
            var q = this.value.trim();
            if (q.length < 2) { closeDropdown(); return; }
            searchTimer = setTimeout(function () { fetchCustomers(q); }, 250);
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDropdown();
        });

        document.addEventListener('click', function (e) {
            if (!searchWrap.contains(e.target)) closeDropdown();
        });

        function fetchCustomers(q) {
            fetch(customerSearchUrl + '?q=' + encodeURIComponent(q), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (r) { return r.json(); })
            .then(function (customers) { renderDropdown(customers); });
        }

        function renderDropdown(customers) {
            dropdown.innerHTML = '';

            if (!customers.length) {
                dropdown.innerHTML = '<li class="px-4 py-3 text-sm text-gray-400 dark:text-gray-500">Geen klanten gevonden.</li>';
                dropdown.classList.remove('hidden');
                return;
            }

            customers.forEach(function (c) {
                var li = document.createElement('li');
                li.className = 'flex flex-col px-4 py-2.5 cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/20 border-b border-gray-100 dark:border-white/5 last:border-0';
                li.innerHTML = '<span class="text-sm font-medium text-gray-900 dark:text-white">' + escHtml(c.name) + '</span>'
                             + '<span class="text-xs text-gray-400 dark:text-gray-500">' + escHtml(c.email) + '</span>';
                li.addEventListener('click', function () { selectCustomer(c); });
                dropdown.appendChild(li);
            });

            dropdown.classList.remove('hidden');
        }

        function selectCustomer(c) {
            selectedCustomerId = c.id;
            selectedName.textContent  = c.name;
            selectedEmail.textContent = c.email;
            selectedChip.classList.remove('hidden');
            searchWrap.classList.add('hidden');
            closeDropdown();
        }

        function clearCustomer() {
            selectedCustomerId = null;
            searchInput.value = '';
            selectedChip.classList.add('hidden');
            searchWrap.classList.remove('hidden');
            searchInput.focus();
        }

        function closeDropdown() {
            dropdown.classList.add('hidden');
            dropdown.innerHTML = '';
        }

        function escHtml(str) {
            return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }
        // ────────────────────────────────────────────────────────────

        // ── Cart ─────────────────────────────────────────────────────
        var cart = [];

        function addToCart(btn) {
            var id    = btn.dataset.type + '_' + btn.dataset.id;
            var price = parseFloat(btn.dataset.price) || 0;
            var vat   = parseFloat(btn.dataset.vat)   || 0;
            var stock = parseInt(btn.dataset.stock, 10); // -1 = unlimited
            var existing = cart.find(function (i) { return i.id === id; });
            var currentQty = existing ? existing.qty : 0;

            if (stock !== -1 && currentQty >= stock) return;

            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id: id, name: btn.dataset.name, price: price, vat: vat, qty: 1, stock: stock });
            }

            renderCart();
        }

        function changeQty(id, delta) {
            var idx = cart.findIndex(function (i) { return i.id === id; });
            if (idx === -1) return;
            var item = cart[idx];

            if (delta > 0 && item.stock !== -1 && item.qty >= item.stock) return;

            item.qty += delta;
            if (item.qty <= 0) cart.splice(idx, 1);
            renderCart();
        }

        var discount = 0; // set this when a coupon is applied

        function renderCart() {
            var isEmpty = cart.length === 0;
            var fmt = function (n) { return '€ ' + n.toFixed(2).replace('.', ','); };

            // Calculate totals
            var subtotaal = 0, btwTotal = 0;
            cart.forEach(function (item) {
                var lineTotal = item.price * item.qty;
                var btwFactor = item.vat / (100 + item.vat);
                subtotaal += lineTotal;
                btwTotal  += lineTotal * btwFactor;
            });
            var totaal = subtotaal - discount;

            // Render desktop + mobile in one pass
            ['', '-mobile'].forEach(function (suffix) {
                var emptyEl    = document.getElementById('cart-empty-state'   + suffix);
                var listEl     = document.getElementById('cart-items-list'    + suffix);
                var subEl      = document.getElementById('cart-subtotaal'     + suffix);
                var kortingRow = document.getElementById('cart-korting-row'   + suffix);
                var kortingEl  = document.getElementById('cart-korting'       + suffix);
                var btwEl      = document.getElementById('cart-btw'           + suffix);
                var totEl      = document.getElementById('cart-totaal'        + suffix);

                if (!emptyEl) return;

                emptyEl.classList.toggle('hidden', !isEmpty);
                listEl.classList.toggle('hidden', isEmpty);

                subEl.textContent = fmt(subtotaal);
                btwEl.textContent = fmt(btwTotal);
                totEl.textContent = fmt(totaal);

                if (kortingRow) {
                    var hasDiscount = discount > 0;
                    kortingRow.classList.toggle('hidden', !hasDiscount);
                    if (kortingEl && hasDiscount) kortingEl.textContent = '— ' + fmt(discount);
                }

                listEl.innerHTML = '';
                cart.forEach(function (item) {
                    var lineTotal = item.price * item.qty;
                    var atMax = item.stock !== -1 && item.qty >= item.stock;
                    var plusClass = atMax
                        ? 'flex h-6 w-6 items-center justify-center rounded-md border border-gray-100 dark:border-white/5 text-gray-300 dark:text-gray-600 cursor-not-allowed text-sm leading-none'
                        : 'flex h-6 w-6 items-center justify-center rounded-md border border-gray-200 dark:border-white/10 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 text-sm leading-none';
                    var stockLabel = (item.stock !== -1)
                        ? '<span class="text-xs text-gray-400 dark:text-gray-500">' + fmt(item.price) + ' · max ' + item.stock + '</span>'
                        : '<span class="text-xs text-gray-400 dark:text-gray-500">' + fmt(item.price) + ' / stuk</span>';

                    var li = document.createElement('li');
                    li.className = 'flex items-center gap-2 px-1 py-2.5';
                    li.innerHTML =
                        '<div class="flex-1 min-w-0">' +
                            '<p class="text-xs font-medium text-gray-900 dark:text-white truncate">' + escHtml(item.name) + '</p>' +
                            stockLabel +
                        '</div>' +
                        '<div class="flex items-center gap-1 shrink-0">' +
                            '<button onclick="changeQty(\'' + item.id + '\', -1)" class="flex h-6 w-6 items-center justify-center rounded-md border border-gray-200 dark:border-white/10 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 text-sm leading-none">−</button>' +
                            '<span class="w-5 text-center text-xs font-medium text-gray-900 dark:text-white">' + item.qty + '</span>' +
                            '<button onclick="changeQty(\'' + item.id + '\', 1)" ' + (atMax ? 'disabled' : '') + ' class="' + plusClass + '">+</button>' +
                        '</div>' +
                        '<span class="w-14 text-right text-xs font-medium text-gray-900 dark:text-white shrink-0">' + fmt(lineTotal) + '</span>';
                    listEl.appendChild(li);
                });
            });
        }
        // ─────────────────────────────────────────────────────────────

        document.addEventListener('DOMContentLoaded', function () { filterItems('room'); });

        function filterItems(type) {
            var cards = document.querySelectorAll('.item-card');
            var visible = 0;

            cards.forEach(function (card) {
                var show = type === 'all' || card.dataset.type === type;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            document.getElementById('items-empty').classList.toggle('hidden', visible > 0);

            document.querySelectorAll('.filter-btn').forEach(function (btn) {
                var isActive = btn.dataset.filter === type;
                btn.classList.toggle('bg-indigo-50', isActive);
                btn.classList.toggle('dark:bg-indigo-900/30', isActive);
                btn.classList.toggle('text-indigo-700', isActive);
                btn.classList.toggle('dark:text-indigo-300', isActive);
                btn.classList.toggle('text-gray-500', !isActive);
                btn.classList.toggle('dark:text-gray-400', !isActive);
            });
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-btn').forEach(function (btn) {
                var isActive = btn.dataset.method === method;
                btn.classList.toggle('border-indigo-500', isActive);
                btn.classList.toggle('bg-indigo-50', isActive);
                btn.classList.toggle('dark:bg-indigo-900/20', isActive);
                btn.classList.toggle('text-indigo-700', isActive);
                btn.classList.toggle('dark:text-indigo-300', isActive);
                btn.classList.toggle('border-gray-200', !isActive);
                btn.classList.toggle('dark:border-white/10', !isActive);
                btn.classList.toggle('text-gray-600', !isActive);
                btn.classList.toggle('dark:text-gray-400', !isActive);
            });

            var showTerm = method === 'online';
            document.getElementById('payment-term-block').classList.toggle('hidden', !showTerm);
            document.getElementById('payment-term-block-mobile').classList.toggle('hidden', !showTerm);
        }

        function toggleMobileCart() {
            var panel = document.getElementById('mobile-cart-panel');
            var chevron = document.getElementById('mobile-cart-chevron');
            var isHidden = panel.classList.contains('hidden');
            panel.classList.toggle('hidden', !isHidden);
            panel.classList.toggle('flex', isHidden);
            chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
        }
    </script>

</x-layouts.app>
