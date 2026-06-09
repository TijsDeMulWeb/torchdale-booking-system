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
                            <span id="mobile-cart-toggle-total" class="font-semibold text-gray-900 dark:text-white">€ 0,00</span>
                            <svg id="mobile-cart-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-400 transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </button>
                </div>

                <div id="mobile-cart-panel" class="hidden lg:hidden flex-col gap-3 mt-3">

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
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400"><span id="cart-subtotaal-label-mobile">Subtotaal excl. BTW</span><span id="cart-subtotaal-mobile">€ 0,00</span></div>
                    <div id="cart-btw-rows-mobile"></div>
                    <div id="cart-korting-row-mobile" class="hidden flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>Korting</span><span id="cart-korting-mobile" class="text-green-600 dark:text-green-400"></span></div>
                    <div class="border-t border-gray-200 dark:border-white/10 pt-2 flex justify-between text-base font-semibold text-gray-900 dark:text-white"><span>Totaal incl. BTW</span><span id="cart-totaal-mobile">€ 0,00</span></div>
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

                <button id="place-order-btn" disabled class="w-full rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    Bestelling plaatsen
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
                                        @if(!$noPrice) onclick="openRoomModal(this)" @endif
                                        data-type="room"
                                        data-id="{{ $room->id }}"
                                        data-name="{{ $room->name }}"
                                        data-min-players="{{ $room->min_players ?? 1 }}"
                                        data-max-players="{{ $room->max_players ?? 8 }}"
                                        data-prices="{{ json_encode($room->prices->map(fn($p) => ['player_amount' => $p->player_amount, 'day_of_week' => $p->day_of_week, 'base_price' => $p->base_price, 'vat' => $p->vat_percentage ?? 0])) }}"
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
                                    @php
                                        $outOfStock = !is_null($product->stock_quantity) && $product->stock_quantity <= 0;
                                        $sellingPrice = $product->selling_price ?? 0;
                                        $discountType  = $product->discount_type;
                                        $discountValue = $product->discount_value ?? 0;
                                        if ($discountType === 'percentage' && $discountValue > 0) {
                                            $effectivePrice = $sellingPrice * (1 - $discountValue / 100);
                                        } elseif ($discountType === 'fixed' && $discountValue > 0) {
                                            $effectivePrice = max(0, $sellingPrice - $discountValue);
                                        } else {
                                            $effectivePrice = $sellingPrice;
                                        }
                                        $hasDiscount = $effectivePrice < $sellingPrice;
                                    @endphp
                                    <button
                                        @if(!$outOfStock) onclick="addToCart(this)" @endif
                                        data-type="product"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $effectivePrice }}"
                                        data-original-price="{{ $sellingPrice }}"
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
                                        <span class="mt-0.5 text-xs leading-snug">
                                            @if($hasDiscount)
                                                <span class="line-through text-gray-400 dark:text-gray-500">{{ Number::currency($sellingPrice) }}</span>
                                                <span class="text-green-600 dark:text-green-400 font-medium"> {{ Number::currency($effectivePrice) }}</span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">{{ $sellingPrice ? Number::currency($sellingPrice) : '—' }}</span>
                                            @endif
                                        </span>
                                        @if($outOfStock)
                                            <span class="mt-1 inline-flex items-center rounded px-1.5 py-0.5 text-xs font-medium bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">Uitverkocht</span>
                                        @elseif(!is_null($product->stock_quantity) && $product->stock_quantity <= 5)
                                            <span class="mt-1 inline-flex items-center rounded px-1.5 py-0.5 text-xs font-medium bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">Nog {{ $product->stock_quantity }} op voorraad</span>
                                        @elseif($hasDiscount)
                                            <span class="mt-1 inline-flex items-center rounded px-1.5 py-0.5 text-xs font-medium bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                                                {{ $discountType === 'percentage' ? $discountValue . '% korting' : '−' . Number::currency($discountValue) }}
                                            </span>
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

                            <div id="selected-coupon" class="hidden mb-3 flex items-center justify-between rounded-lg bg-green-50 dark:bg-green-900/20 px-3 py-2.5 border border-green-200 dark:border-green-500/30">
                                <div>
                                    <p id="selected-coupon-name" class="text-sm font-medium text-green-900 dark:text-green-100"></p>
                                    <p id="selected-coupon-detail" class="text-xs text-green-600 dark:text-green-400"></p>
                                </div>
                                <button onclick="clearCoupon()" type="button" class="ml-3 text-green-400 hover:text-green-600 dark:hover:text-green-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div id="coupon-search-wrap" class="relative">
                                <input
                                    id="coupon-search-input"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="Zoek op code of naam..."
                                    class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2.5 pl-9 pr-4 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="pointer-events-none absolute left-3 top-2.5 size-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-4.5-4.5-4.5 4.5-4.5-4.5-4.5 4.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185Z" />
                                </svg>
                                <ul id="coupon-dropdown" class="hidden absolute z-20 mt-1 w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 shadow-lg overflow-hidden"></ul>
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
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400"><span id="cart-subtotaal-label">Subtotaal excl. BTW</span><span id="cart-subtotaal">€ 0,00</span></div>
                            <div id="cart-btw-rows"></div>
                            <div id="cart-korting-row" class="hidden flex justify-between text-sm text-gray-600 dark:text-gray-400"><span>Korting</span><span id="cart-korting" class="text-green-600 dark:text-green-400"></span></div>
                            <div class="border-t border-gray-200 dark:border-white/10 pt-2 flex justify-between text-base font-semibold text-gray-900 dark:text-white"><span>Totaal incl. BTW</span><span id="cart-totaal">€ 0,00</span></div>
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

                        <button id="place-order-btn-mobile" disabled class="w-full rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                            Bestelling plaatsen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Room modal --}}
    <div id="room-modal-backdrop" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" onclick="closeRoomModal(event)">
        <div class="w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/10 px-5 py-4">
                <h3 id="room-modal-title" class="text-sm font-semibold text-gray-900 dark:text-white"></h3>
                <button onclick="closeRoomModal()" class="rounded-md p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-5 py-4 space-y-4">
                {{-- Date --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Datum</label>
                    <input
                        id="room-modal-date"
                        type="date"
                        oninput="updateRoomPrice()"
                        class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2.5 px-3 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>

                {{-- Players --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Aantal spelers</label>
                    <div class="flex items-center gap-3">
                        <button onclick="changeRoomPlayers(-1)" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 text-lg font-medium">−</button>
                        <span id="room-modal-players" class="w-8 text-center text-sm font-semibold text-gray-900 dark:text-white">1</span>
                        <button onclick="changeRoomPlayers(1)" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 text-lg font-medium">+</button>
                        <span id="room-modal-players-range" class="text-xs text-gray-400 dark:text-gray-500"></span>
                    </div>
                </div>

                {{-- Price result --}}
                <div id="room-modal-price-block" class="rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 px-4 py-3">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mb-0.5">Prijs</p>
                    <p id="room-modal-price-display" class="text-base font-semibold text-gray-900 dark:text-white">—</p>
                    <p id="room-modal-price-note" class="text-xs text-gray-400 dark:text-gray-500 mt-0.5"></p>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-white/10 px-5 py-4 flex gap-3">
                <button onclick="closeRoomModal()" class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">Annuleren</button>
                <button id="room-modal-add-btn" onclick="addRoomToCart()" disabled class="flex-1 rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">Toevoegen</button>
            </div>
        </div>
    </div>

    <script>
        var customerSearchUrl = '{{ route('customers.search') }}';
        var couponSearchUrl   = '{{ route('coupons.search') }}';
        var selectedCustomerId = null;
        var searchTimer = null;

        var searchInput    = document.getElementById('customer-search-input');
        var dropdown       = document.getElementById('customer-dropdown');
        var selectedChip   = document.getElementById('selected-customer');
        var selectedName   = document.getElementById('selected-customer-name');
        var selectedEmail  = document.getElementById('selected-customer-email');
        var searchWrap     = document.getElementById('customer-search-wrap');
        var customerFocusIdx = -1;

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);
            var q = this.value.trim();
            if (q.length < 2) { closeDropdown(); return; }
            searchTimer = setTimeout(function () { fetchCustomers(q); }, 250);
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeDropdown(); return; }
            var items = dropdown.querySelectorAll('li.dd-item');
            if (!items.length) return;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                customerFocusIdx = Math.min(customerFocusIdx + 1, items.length - 1);
                setDropdownFocus(items, customerFocusIdx, 'indigo');
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                customerFocusIdx = Math.max(customerFocusIdx - 1, 0);
                setDropdownFocus(items, customerFocusIdx, 'indigo');
            } else if (e.key === 'Enter' && customerFocusIdx >= 0) {
                e.preventDefault();
                items[customerFocusIdx].click();
            }
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
            customerFocusIdx = -1;

            if (!customers.length) {
                dropdown.innerHTML = '<li class="px-4 py-3 text-sm text-gray-400 dark:text-gray-500">Geen klanten gevonden.</li>';
                dropdown.classList.remove('hidden');
                return;
            }

            customers.forEach(function (c) {
                var li = document.createElement('li');
                li.className = 'dd-item flex flex-col px-4 py-2.5 cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/20 border-b border-gray-100 dark:border-white/5 last:border-0';
                li.innerHTML = '<span class="text-sm font-medium text-gray-900 dark:text-white">' + escHtml(c.name) + '</span>'
                             + '<span class="text-xs text-gray-400 dark:text-gray-500">' + escHtml(c.email) + '</span>';
                li.addEventListener('click', function () { selectCustomer(c); });
                dropdown.appendChild(li);
            });

            dropdown.classList.remove('hidden');
        }

        function setDropdownFocus(items, idx, color) {
            items.forEach(function (item, i) {
                var active = i === idx;
                item.classList.toggle('bg-' + color + '-50', active);
                item.classList.toggle('dark:bg-' + color + '-900/20', active);
            });
            if (items[idx]) items[idx].scrollIntoView({ block: 'nearest' });
        }

        function selectCustomer(c) {
            selectedCustomerId = c.id;
            selectedName.textContent  = c.name;
            selectedEmail.textContent = c.email;
            selectedChip.classList.remove('hidden');
            searchWrap.classList.add('hidden');
            closeDropdown();
            updatePlaceOrderBtn();
        }

        function clearCustomer() {
            selectedCustomerId = null;
            searchInput.value = '';
            selectedChip.classList.add('hidden');
            searchWrap.classList.remove('hidden');
            searchInput.focus();
            updatePlaceOrderBtn();
        }

        function closeDropdown() {
            dropdown.classList.add('hidden');
            dropdown.innerHTML = '';
        }

        function escHtml(str) {
            return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }
        // ────────────────────────────────────────────────────────────

        // ── Coupon search ────────────────────────────────────────────
        var couponSearchTimer = null;
        var selectedCoupon    = null;

        var couponInput    = document.getElementById('coupon-search-input');
        var couponDropdown = document.getElementById('coupon-dropdown');
        var couponChip     = document.getElementById('selected-coupon');
        var couponWrap     = document.getElementById('coupon-search-wrap');
        var couponFocusIdx = -1;

        couponInput.addEventListener('input', function () {
            clearTimeout(couponSearchTimer);
            var q = this.value.trim();
            if (q.length < 1) { closeCouponDropdown(); return; }
            couponSearchTimer = setTimeout(function () { fetchCoupons(q); }, 250);
        });

        couponInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeCouponDropdown(); return; }
            var items = couponDropdown.querySelectorAll('li.dd-item');
            if (!items.length) return;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                couponFocusIdx = Math.min(couponFocusIdx + 1, items.length - 1);
                setDropdownFocus(items, couponFocusIdx, 'green');
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                couponFocusIdx = Math.max(couponFocusIdx - 1, 0);
                setDropdownFocus(items, couponFocusIdx, 'green');
            } else if (e.key === 'Enter' && couponFocusIdx >= 0) {
                e.preventDefault();
                items[couponFocusIdx].click();
            }
        });

        document.addEventListener('click', function (e) {
            if (!couponWrap.contains(e.target)) closeCouponDropdown();
        });

        function fetchCoupons(q) {
            fetch(couponSearchUrl + '?q=' + encodeURIComponent(q), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (r) { return r.json(); })
            .then(function (coupons) { renderCouponDropdown(coupons); });
        }

        function renderCouponDropdown(coupons) {
            couponDropdown.innerHTML = '';
            couponFocusIdx = -1;

            if (!coupons.length) {
                couponDropdown.innerHTML = '<li class="px-4 py-3 text-sm text-gray-400 dark:text-gray-500">Geen kortingscodes gevonden.</li>';
                couponDropdown.classList.remove('hidden');
                return;
            }

            coupons.forEach(function (c) {
                var discountLabel = c.discount_type === 'percentage'
                    ? c.discount_value + '%'
                    : '€\xa0' + parseFloat(c.discount_value).toFixed(2).replace('.', ',');

                var li = document.createElement('li');
                li.className = 'dd-item flex items-center justify-between px-4 py-2.5 cursor-pointer hover:bg-green-50 dark:hover:bg-green-900/20 border-b border-gray-100 dark:border-white/5 last:border-0';
                li.innerHTML =
                    '<div>' +
                        '<span class="text-sm font-medium text-gray-900 dark:text-white">' + escHtml(c.code) + '</span>' +
                        '<span class="ml-2 text-xs text-gray-400 dark:text-gray-500">' + escHtml(c.name) + '</span>' +
                    '</div>' +
                    '<span class="text-xs font-semibold text-green-600 dark:text-green-400 shrink-0">' + discountLabel + '</span>';
                li.addEventListener('click', function () { applyCoupon(c); });
                couponDropdown.appendChild(li);
            });

            couponDropdown.classList.remove('hidden');
        }

        function applyCoupon(c) {
            selectedCoupon = c;
            document.getElementById('selected-coupon-name').textContent = c.code + ' — ' + c.name;
            var discountLabel = c.discount_type === 'percentage'
                ? c.discount_value + '% korting'
                : '€\xa0' + parseFloat(c.discount_value).toFixed(2).replace('.', ',') + ' korting';
            document.getElementById('selected-coupon-detail').textContent = discountLabel;
            couponChip.classList.remove('hidden');
            couponWrap.classList.add('hidden');
            closeCouponDropdown();
            renderCart(); // recalculate discount
        }

        function clearCoupon() {
            selectedCoupon = null;
            couponInput.value = '';
            couponChip.classList.add('hidden');
            couponWrap.classList.remove('hidden');
            couponInput.focus();
            renderCart();
        }

        function closeCouponDropdown() {
            couponDropdown.classList.add('hidden');
            couponDropdown.innerHTML = '';
        }
        // ─────────────────────────────────────────────────────────────

        // ── Room modal ───────────────────────────────────────────────
        var roomModal = {
            id: null, name: null, players: 1, minPlayers: 1, maxPlayers: 8,
            prices: [], selectedPrice: null, selectedDate: null
        };

        var DAY_NAMES = ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'];

        function openRoomModal(btn) {
            roomModal.id         = btn.dataset.id;
            roomModal.name       = btn.dataset.name;
            roomModal.minPlayers = parseInt(btn.dataset.minPlayers, 10) || 1;
            roomModal.maxPlayers = parseInt(btn.dataset.maxPlayers, 10) || 8;
            roomModal.players    = roomModal.minPlayers;
            roomModal.prices     = JSON.parse(btn.dataset.prices || '[]');
            roomModal.selectedPrice = null;
            roomModal.selectedDate  = null;

            document.getElementById('room-modal-title').textContent = roomModal.name;
            document.getElementById('room-modal-players').textContent = roomModal.players;
            document.getElementById('room-modal-players-range').textContent =
                roomModal.minPlayers + '–' + roomModal.maxPlayers + ' spelers';

            // Default date = today
            var today = new Date();
            var yyyy = today.getFullYear();
            var mm   = String(today.getMonth() + 1).padStart(2, '0');
            var dd   = String(today.getDate()).padStart(2, '0');
            document.getElementById('room-modal-date').value = yyyy + '-' + mm + '-' + dd;

            document.getElementById('room-modal-backdrop').classList.remove('hidden');
            document.getElementById('room-modal-backdrop').classList.add('flex');
            updateRoomPrice();
        }

        function closeRoomModal(e) {
            if (e && e.target !== document.getElementById('room-modal-backdrop')) return;
            document.getElementById('room-modal-backdrop').classList.add('hidden');
            document.getElementById('room-modal-backdrop').classList.remove('flex');
        }

        function changeRoomPlayers(delta) {
            var next = roomModal.players + delta;
            if (next < roomModal.minPlayers || next > roomModal.maxPlayers) return;
            roomModal.players = next;
            document.getElementById('room-modal-players').textContent = next;
            updateRoomPrice();
        }

        function updateRoomPrice() {
            var dateVal = document.getElementById('room-modal-date').value;
            var priceDisplay = document.getElementById('room-modal-price-display');
            var priceNote    = document.getElementById('room-modal-price-note');
            var addBtn       = document.getElementById('room-modal-add-btn');

            roomModal.selectedPrice = null;
            roomModal.selectedDate  = dateVal;

            if (!dateVal) {
                priceDisplay.textContent = '—';
                priceNote.textContent = 'Kies een datum';
                addBtn.disabled = true;
                return;
            }

            var parts = dateVal.split('-');
            var dow = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2])).getDay(); // 0=Sun

            // Find price matching day_of_week AND player_amount
            var match = roomModal.prices.find(function (p) {
                return p.day_of_week == dow && p.player_amount == roomModal.players;
            });

            // Fallback: match only player_amount (if no day-specific pricing)
            if (!match) {
                match = roomModal.prices.find(function (p) {
                    return p.player_amount == roomModal.players && p.day_of_week == null;
                });
            }

            if (match) {
                roomModal.selectedPrice = match;
                var fmtPrice = function (n) { return '€\xa0' + parseFloat(n).toFixed(2).replace('.', ','); };
                priceDisplay.textContent = fmtPrice(match.base_price);
                priceNote.textContent = DAY_NAMES[dow] + ' · ' + roomModal.players + ' speler' + (roomModal.players !== 1 ? 's' : '')
                    + (match.vat ? ' · ' + match.vat + '% BTW incl.' : '');
                addBtn.disabled = false;
            } else {
                priceDisplay.textContent = '—';
                priceNote.textContent = 'Geen prijs gevonden voor ' + DAY_NAMES[dow] + ' met ' + roomModal.players + ' speler' + (roomModal.players !== 1 ? 's' : '');
                addBtn.disabled = true;
            }
        }

        function addRoomToCart() {
            if (!roomModal.selectedPrice) return;
            var p     = roomModal.selectedPrice;
            var total = parseFloat(p.base_price);
            var id    = 'room_' + roomModal.id + '_' + roomModal.players + '_' + roomModal.selectedDate;
            var label = roomModal.name + ' (' + roomModal.players + ' spelers, ' + roomModal.selectedDate + ')';

            var existing = cart.find(function (i) { return i.id === id; });
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id: id, name: label, price: total, vat: p.vat || 0, qty: 1, stock: -1 });
            }

            renderCart();
            document.getElementById('room-modal-backdrop').classList.add('hidden');
            document.getElementById('room-modal-backdrop').classList.remove('flex');
        }
        // ─────────────────────────────────────────────────────────────

        // ── Cart ─────────────────────────────────────────────────────
        var cart = [];

        function addToCart(btn) {
            var id            = btn.dataset.type + '_' + btn.dataset.id;
            var price         = parseFloat(btn.dataset.price) || 0;
            var originalPrice = parseFloat(btn.dataset.originalPrice || btn.dataset.price) || 0;
            var vat           = parseFloat(btn.dataset.vat)   || 0;
            var stock         = parseInt(btn.dataset.stock, 10); // -1 = unlimited
            var existing      = cart.find(function (i) { return i.id === id; });
            var currentQty    = existing ? existing.qty : 0;

            if (stock !== -1 && currentQty >= stock) return;

            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id: id, name: btn.dataset.name, price: price, originalPrice: originalPrice, vat: vat, qty: 1, stock: stock });
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

        function renderCart() {
            var isEmpty = cart.length === 0;
            var fmt = function (n) { return '€ ' + n.toFixed(2).replace('.', ','); };

            // Prices are VAT-inclusive; compute excl. BTW subtotaal and BTW per rate
            var totaalInclBtw = 0, itemCount = 0;
            var btwPerRate = {};
            cart.forEach(function (item) {
                var lineTotal = item.price * item.qty;
                var btwAmount = lineTotal * (item.vat / (100 + item.vat));
                totaalInclBtw += lineTotal;
                itemCount += item.qty;
                if (item.vat > 0) {
                    var key = String(item.vat);
                    btwPerRate[key] = (btwPerRate[key] || 0) + btwAmount;
                }
            });
            var totalBtw      = Object.values(btwPerRate).reduce(function (s, v) { return s + v; }, 0);
            var subtotaalExcl = totaalInclBtw - totalBtw;

            // 1. Bereken korting op excl. BTW bedrag
            var discount = 0;
            if (selectedCoupon && subtotaalExcl > 0) {
                discount = selectedCoupon.discount_type === 'percentage'
                    ? subtotaalExcl * parseFloat(selectedCoupon.discount_value) / 100
                    : Math.min(parseFloat(selectedCoupon.discount_value), subtotaalExcl);
            }

            // 2. BTW herberekenen op gecorrigeerd excl. bedrag (proportioneel schalen)
            var discountedExcl = subtotaalExcl - discount;
            var scale = subtotaalExcl > 0 ? discountedExcl / subtotaalExcl : 1;
            var scaledBtw = {};
            Object.keys(btwPerRate).forEach(function (rate) {
                scaledBtw[rate] = btwPerRate[rate] * scale;
            });

            // 3. Totaal = gecorrigeerd excl. + geschaalde BTW
            var totaal = discountedExcl + Object.values(scaledBtw).reduce(function (s, v) { return s + v; }, 0);

            // Render desktop + mobile in one pass
            ['', '-mobile'].forEach(function (suffix) {
                var emptyEl    = document.getElementById('cart-empty-state'      + suffix);
                var listEl     = document.getElementById('cart-items-list'       + suffix);
                var subLabel   = document.getElementById('cart-subtotaal-label'  + suffix);
                var subEl      = document.getElementById('cart-subtotaal'        + suffix);
                var btwRows    = document.getElementById('cart-btw-rows'         + suffix);
                var kortingRow = document.getElementById('cart-korting-row'      + suffix);
                var kortingEl  = document.getElementById('cart-korting'          + suffix);
                var totEl      = document.getElementById('cart-totaal'           + suffix);

                if (!emptyEl) return;

                emptyEl.classList.toggle('hidden', !isEmpty);
                listEl.classList.toggle('hidden', isEmpty);

                var artikelLabel = itemCount === 1 ? '1 artikel' : itemCount + ' artikelen';
                if (subLabel) subLabel.textContent = isEmpty ? 'Subtotaal excl. BTW' : 'Subtotaal excl. BTW (' + artikelLabel + ')';
                subEl.textContent = fmt(subtotaalExcl);
                totEl.textContent = fmt(totaal);

                if (btwRows) {
                    btwRows.innerHTML = '';
                    Object.keys(scaledBtw).sort(function(a,b){return a-b;}).forEach(function (rate) {
                        var row = document.createElement('div');
                        row.className = 'flex justify-between text-sm text-gray-600 dark:text-gray-400';
                        row.innerHTML = '<span>BTW ' + rate + '%</span><span>' + fmt(scaledBtw[rate]) + '</span>';
                        btwRows.appendChild(row);
                    });
                }

                if (kortingRow) {
                    var hasDiscount = discount > 0;
                    kortingRow.classList.toggle('hidden', !hasDiscount);
                    if (kortingEl && hasDiscount) kortingEl.textContent = '— ' + fmt(discount);
                }

                listEl.innerHTML = '';
                cart.forEach(function (item) {
                    var lineTotal = item.price * item.qty;
                    var isRoom = item.id.indexOf('room_') === 0;

                    var hasDiscount = item.originalPrice && item.originalPrice > item.price;
                    var subLabel;
                    if (isRoom) {
                        subLabel = '';
                    } else if (hasDiscount) {
                        var stockSuffix = item.stock !== -1 ? ' · max ' + item.stock : ' / stuk';
                        subLabel = '<span class="text-xs line-through text-gray-400 dark:text-gray-500">' + fmt(item.originalPrice) + '</span>' +
                                   '<span class="text-xs text-green-600 dark:text-green-400 font-medium ml-1">' + fmt(item.price) + '</span>' +
                                   '<span class="text-xs text-gray-400 dark:text-gray-500">' + stockSuffix + '</span>';
                    } else {
                        subLabel = item.stock !== -1
                            ? '<span class="text-xs text-gray-400 dark:text-gray-500">' + fmt(item.price) + ' · max ' + item.stock + '</span>'
                            : '<span class="text-xs text-gray-400 dark:text-gray-500">' + fmt(item.price) + ' / stuk</span>';
                    }

                    var qtyControls;
                    if (isRoom) {
                        qtyControls =
                            '<button onclick="changeQty(\'' + item.id + '\', -1)" title="Verwijderen" class="flex h-6 w-6 items-center justify-center rounded-md border border-gray-200 dark:border-white/10 text-gray-400 hover:text-red-500 hover:border-red-300 dark:hover:border-red-500 dark:hover:text-red-400 text-sm leading-none transition-colors">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>' +
                            '</button>';
                    } else {
                        var atMax = item.stock !== -1 && item.qty >= item.stock;
                        var plusClass = atMax
                            ? 'flex h-6 w-6 items-center justify-center rounded-md border border-gray-100 dark:border-white/5 text-gray-300 dark:text-gray-600 cursor-not-allowed text-sm leading-none'
                            : 'flex h-6 w-6 items-center justify-center rounded-md border border-gray-200 dark:border-white/10 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 text-sm leading-none';
                        qtyControls =
                            '<button onclick="changeQty(\'' + item.id + '\', -1)" class="flex h-6 w-6 items-center justify-center rounded-md border border-gray-200 dark:border-white/10 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 text-sm leading-none">−</button>' +
                            '<span class="w-5 text-center text-xs font-medium text-gray-900 dark:text-white">' + item.qty + '</span>' +
                            '<button onclick="changeQty(\'' + item.id + '\', 1)" ' + (atMax ? 'disabled' : '') + ' class="' + plusClass + '">+</button>';
                    }

                    var li = document.createElement('li');
                    li.className = 'flex items-center gap-2 px-1 py-2.5';
                    li.innerHTML =
                        '<div class="flex-1 min-w-0">' +
                            '<p class="text-xs font-medium text-gray-900 dark:text-white truncate">' + escHtml(item.name) + '</p>' +
                            subLabel +
                        '</div>' +
                        '<div class="flex items-center gap-1 shrink-0">' +
                            qtyControls +
                        '</div>' +
                        '<span class="w-14 text-right text-xs font-medium text-gray-900 dark:text-white shrink-0">' + fmt(lineTotal) + '</span>';
                    listEl.appendChild(li);
                });
            });

            // Update mobile toggle button total
            var toggleTotal = document.getElementById('mobile-cart-toggle-total');
            if (toggleTotal) toggleTotal.textContent = fmt(totaal);

            updatePlaceOrderBtn();
        }
        // ─────────────────────────────────────────────────────────────

        function updatePlaceOrderBtn() {
            var enabled = selectedCustomerId !== null && cart.length > 0;
            ['place-order-btn', 'place-order-btn-mobile'].forEach(function (id) {
                var btn = document.getElementById(id);
                if (btn) btn.disabled = !enabled;
            });
        }

        document.addEventListener('DOMContentLoaded', function () { filterItems('all'); });

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
            if (isHidden) {
                panel.classList.remove('hidden');
                panel.style.display = 'flex';
                panel.style.flexDirection = 'column';
                chevron.style.transform = 'rotate(180deg)';
            } else {
                panel.classList.add('hidden');
                panel.style.display = '';
                chevron.style.transform = '';
            }
        }
    </script>

</x-layouts.app>
