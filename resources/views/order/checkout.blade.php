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

                <button id="place-order-btn" onclick="submitOrder()" disabled class="w-full rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    Bestelling plaatsen
                </button>

                
                </div>

                <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-start lg:gap-6">
                    <div class="flex-1 min-w-0 flex flex-col gap-4">
                        <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Klant</label>
                                <button onclick="openNewCustomerForm()" type="button" id="btn-new-customer"
                                    class="flex items-center gap-1 rounded-md bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Klant toevoegen
                                </button>
                            </div>

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

                            {{-- Nieuwe klant aanmaken (inline) --}}
                            <div id="new-customer-form" class="hidden mt-3 rounded-lg border border-indigo-200 dark:border-indigo-500/30 bg-indigo-50/50 dark:bg-indigo-900/10 p-3 space-y-2.5">
                                <p class="text-xs font-semibold text-indigo-700 dark:text-indigo-300">Nieuwe klant aanmaken</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Voornaam <span class="text-red-500">*</span></label>
                                        <input id="nc-first-name" type="text" placeholder="Jan"
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Achternaam <span class="text-red-500">*</span></label>
                                        <input id="nc-last-name" type="text" placeholder="Janssen"
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">E-mailadres <span class="text-red-500">*</span></label>
                                    <input id="nc-email" type="email" placeholder="jan@voorbeeld.be"
                                        class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Telefoon <span class="text-gray-400">(optioneel)</span></label>
                                    <input id="nc-phone" type="tel" placeholder="+32 470 00 00 00"
                                        class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="col-span-2">
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Straat <span class="text-gray-400">(optioneel)</span></label>
                                        <input id="nc-street" type="text" placeholder="Kerkstraat"
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nr.</label>
                                        <input id="nc-house-number" type="text" placeholder="12"
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Postcode</label>
                                        <input id="nc-postal-code" type="text" placeholder="2000"
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Gemeente</label>
                                        <input id="nc-city" type="text" placeholder="Antwerpen"
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                </div>
                                <div class="relative">
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Land</label>
                                    <input id="nc-country-search" type="text" placeholder="Zoek land…" autocomplete="off"
                                        class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    <input id="nc-country" type="hidden" value="" />
                                    <ul id="nc-country-dropdown" class="hidden absolute z-30 mt-1 w-full max-h-44 overflow-y-auto rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 shadow-lg"></ul>
                                </div>
                                <p id="nc-error" class="hidden text-xs text-red-500"></p>
                                <div class="flex gap-2 pt-0.5">
                                    <button onclick="cancelNewCustomer()" type="button"
                                        class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 py-2 text-xs font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                        Annuleren
                                    </button>
                                    <button onclick="saveNewCustomer()" type="button" id="nc-save-btn"
                                        class="flex-1 rounded-lg bg-indigo-600 py-2 text-xs font-semibold text-white hover:bg-indigo-500 transition-colors disabled:opacity-50">
                                        Aanmaken
                                    </button>
                                </div>
                            </div>

                            {{-- Business toggle + fields (shown after customer is selected) --}}
                            <div id="business-section" class="hidden mt-3 border-t border-gray-100 dark:border-white/5 pt-3 space-y-3">
                                <button type="button" onclick="toggleBusiness()" id="business-toggle"
                                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                    <span id="business-toggle-icon" class="flex h-5 w-5 items-center justify-center rounded border-2 border-gray-300 dark:border-white/20 transition-colors">
                                    </span>
                                    Zakelijke klant
                                </button>

                                <div id="business-fields" class="hidden space-y-2.5">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Bedrijfsnaam <span class="text-red-500">*</span></label>
                                        <input id="business-company-name" type="text" placeholder="Bedrijfsnaam..."
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">BTW-nummer <span class="text-red-500">*</span></label>
                                        <input id="business-vat-number" type="text" placeholder="BE0123456789..."
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ondernemingsnummer <span class="text-gray-400">(optioneel)</span></label>
                                        <input id="business-reg-number" type="text" placeholder="0123.456.789..."
                                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 py-2 px-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                                    </div>
                                </div>
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
                                    @php
                                        $hasVariants = $product->variants->isNotEmpty();
                                        $variantsJson = $hasVariants ? $product->variants->map(fn($v) => [
                                            'id'             => $v->id,
                                            'name'           => $v->name,
                                            'selling_price'  => $v->selling_price,
                                            'stock_quantity' => $v->stock_quantity,
                                        ])->toJson() : '[]';
                                        $clickHandler = $hasVariants
                                            ? 'openVariantModal(this)'
                                            : (($product->shipping_cost_domestic > 0 || $product->shipping_cost_international > 0) ? 'openProductModal(this)' : 'addToCart(this)');
                                    @endphp
                                    <button
                                        @if(!$outOfStock) onclick="{{ $clickHandler }}" @endif
                                        data-type="product"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $effectivePrice }}"
                                        data-original-price="{{ $sellingPrice }}"
                                        data-discount-type="{{ $hasDiscount ? $discountType : '' }}"
                                        data-discount-value="{{ $hasDiscount ? $discountValue : 0 }}"
                                        data-vat="{{ $product->vat_percentage ?? 0 }}"
                                        data-stock="{{ $product->stock_quantity ?? -1 }}"
                                        data-shipping-domestic="{{ $product->shipping_cost_domestic ?? 0 }}"
                                        data-shipping-international="{{ $product->shipping_cost_international ?? 0 }}"
                                        data-variants="{{ $variantsJson }}"
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
                                        onclick="openGiftCardModal(this)"
                                        data-type="giftcard"
                                        data-id="{{ $giftCard->id }}"
                                        data-name="{{ $giftCard->name }}"
                                        data-price="{{ $giftCard->amount ?? 0 }}"
                                        data-vat="0"
                                        data-stock="-1"
                                        data-shipping-cost="{{ $giftCard->shipping_cost ?? 0 }}"
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
                            <div class="grid grid-cols-2 gap-2">
                                {{-- <button data-method="kaart" onclick="selectPayment('kaart')" class="payment-btn flex flex-col items-center gap-1.5 rounded-lg border-2 border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 p-3 text-xs font-medium text-indigo-700 dark:text-indigo-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                    </svg>
                                    Kaart
                                </button> --}}
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

                        <button id="place-order-btn-mobile" onclick="submitOrder()" disabled class="w-full rounded-xl bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                            Bestelling plaatsen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gift card delivery modal --}}
    <div id="gc-modal-backdrop" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" onclick="closeGiftCardModal(event)">
        <div class="w-full max-w-sm rounded-2xl bg-white dark:bg-gray-900 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/10 px-5 py-4">
                <h3 id="gc-modal-title" class="text-sm font-semibold text-gray-900 dark:text-white"></h3>
                <button onclick="closeGiftCardModal()" class="rounded-md p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-5 py-4 space-y-4">
                <p class="text-xs text-gray-500 dark:text-gray-400">Kies hoe deze cadeaubon bezorgd wordt.</p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach ([
                        ['value' => 'mail',   'label' => 'E-mail',   'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
                        ['value' => 'post',   'label' => 'Per post', 'icon' => 'M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.235 2.235 0 00-.1.661z'],
                        ['value' => 'pickup', 'label' => 'Afhalen',  'icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z'],
                    ] as $opt)
                        <label class="relative flex flex-col items-center gap-1.5 rounded-lg border-2 px-3 py-3 cursor-pointer transition-colors
                            has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/20
                            border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20">
                            <input type="radio" name="gc_delivery_method" value="{{ $opt['value'] }}"
                                onchange="gcToggleShipping(this.value)"
                                class="sr-only gc-delivery-radio">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $opt['icon'] }}"/>
                            </svg>
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $opt['label'] }}</span>
                        </label>
                    @endforeach
                </div>

                <div id="gc-modal-shipping-field" class="hidden">
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Verzendkosten</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">€</span>
                        <input type="number" id="gc-modal-shipping-cost" min="0" max="99.99" step="0.01"
                            placeholder="0.00"
                            class="w-full pl-7 pr-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-white/15 bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-white/10 px-5 py-4 flex gap-3">
                <button onclick="closeGiftCardModal()" class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">Annuleren</button>
                <button onclick="addGiftCardToCart()" class="flex-1 rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">Toevoegen</button>
            </div>
        </div>
    </div>

    {{-- Product variant modal --}}
    <div id="variant-modal-backdrop" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" onclick="closeVariantModal(event)">
        <div class="w-full max-w-sm rounded-2xl bg-white dark:bg-gray-900 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/10 px-5 py-4">
                <div>
                    <h3 id="variant-modal-title" class="text-sm font-semibold text-gray-900 dark:text-white"></h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kies een variatie</p>
                </div>
                <button onclick="closeVariantModal()" class="rounded-md p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-5 py-4">
                <div id="variant-modal-list" class="space-y-2"></div>
                <div id="variant-modal-shipping" class="mt-4 hidden">
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Verzendkosten</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">€</span>
                        <input type="number" id="variant-modal-shipping-cost" min="0" step="0.01" placeholder="0.00"
                            class="w-full pl-7 pr-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-white/15 bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-white/10 px-5 py-4 flex gap-3">
                <button onclick="closeVariantModal()" class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">Annuleren</button>
                <button onclick="addVariantToCart()" id="variant-modal-add-btn" class="flex-1 rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">Toevoegen</button>
            </div>
        </div>
    </div>

    {{-- Product shipping modal --}}
    <div id="prod-modal-backdrop" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" onclick="closeProductModal(event)">
        <div class="w-full max-w-sm rounded-2xl bg-white dark:bg-gray-900 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/10 px-5 py-4">
                <div>
                    <h3 id="prod-modal-title" class="text-sm font-semibold text-gray-900 dark:text-white"></h3>
                    <p id="prod-modal-price" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5"></p>
                </div>
                <button onclick="closeProductModal()" class="rounded-md p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-5 py-4 space-y-3">
                <p class="text-xs text-gray-500 dark:text-gray-400">Pas de verzendkosten aan indien nodig.</p>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Verzendkosten</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">€</span>
                        <input type="number" id="prod-modal-shipping-cost" min="0" step="0.01"
                            placeholder="0.00"
                            class="w-full pl-7 pr-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-white/15 bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500" id="prod-modal-shipping-hint"></p>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-white/10 px-5 py-4 flex gap-3">
                <button onclick="closeProductModal()" class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">Annuleren</button>
                <button onclick="addProductFromModal()" class="flex-1 rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">Toevoegen</button>
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

    <form id="order-form" method="POST" action="{{ route('orders.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="customer_id"        id="form-customer-id">
        <input type="hidden" name="cart"               id="form-cart">
        <input type="hidden" name="payment_method"     id="form-payment-method">
        <input type="hidden" name="payment_term"       id="form-payment-term">
        <input type="hidden" name="coupon_id"          id="form-coupon-id">
        <input type="hidden" name="totals"             id="form-totals">
        <input type="hidden" name="business"           id="form-business">
        <input type="hidden" name="idempotency_key"    id="form-idempotency-key">
    </form>

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
                var emptyLi = document.createElement('li');
                emptyLi.className = 'px-4 py-3 text-sm text-gray-400 dark:text-gray-500';
                emptyLi.textContent = 'Geen klanten gevonden.';
                dropdown.appendChild(emptyLi);
            } else {
                customers.forEach(function (c) {
                    var li = document.createElement('li');
                    li.className = 'dd-item flex flex-col px-4 py-2.5 cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/20 border-b border-gray-100 dark:border-white/5 last:border-0';
                    li.innerHTML = '<span class="text-sm font-medium text-gray-900 dark:text-white">' + escHtml(c.name) + '</span>'
                                 + '<span class="text-xs text-gray-400 dark:text-gray-500">' + escHtml(c.email) + '</span>';
                    li.addEventListener('click', function () { selectCustomer(c); });
                    dropdown.appendChild(li);
                });
            }

            // Always show "Nieuwe klant aanmaken" at the bottom
            var newLi = document.createElement('li');
            newLi.className = 'flex items-center gap-2 px-4 py-2.5 cursor-pointer text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 border-t border-gray-100 dark:border-white/5 text-sm font-medium';
            newLi.innerHTML = '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Nieuwe klant aanmaken';
            newLi.addEventListener('click', function () { openNewCustomerForm(); });
            dropdown.appendChild(newLi);

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

        var isBusiness = false;

        function selectCustomer(c) {
            selectedCustomerId = c.id;
            selectedCustomerCountryIso = c.country_iso || null;
            selectedName.textContent  = c.name;
            selectedEmail.textContent = c.email;
            selectedChip.classList.remove('hidden');
            searchWrap.classList.add('hidden');
            document.getElementById('business-section').classList.remove('hidden');
            closeDropdown();
            recalculateProductShipping();
            renderCart();
            updatePlaceOrderBtn();
        }

        function clearCustomer() {
            selectedCustomerId = null;
            selectedCustomerCountryIso = null;
            searchInput.value = '';
            selectedChip.classList.add('hidden');
            searchWrap.classList.remove('hidden');
            searchInput.focus();
            // Reset business
            isBusiness = false;
            document.getElementById('business-section').classList.add('hidden');
            document.getElementById('business-fields').classList.add('hidden');
            document.getElementById('business-toggle-icon').innerHTML = '';
            document.getElementById('business-toggle-icon').classList.remove('border-indigo-500', 'bg-indigo-500');
            document.getElementById('business-toggle-icon').classList.add('border-gray-300', 'dark:border-white/20');
            document.getElementById('business-company-name').value = '';
            document.getElementById('business-vat-number').value   = '';
            document.getElementById('business-reg-number').value   = '';
            recalculateProductShipping();
            renderCart();
            updatePlaceOrderBtn();
        }

        function toggleBusiness() {
            isBusiness = !isBusiness;
            var icon   = document.getElementById('business-toggle-icon');
            var fields = document.getElementById('business-fields');
            fields.classList.toggle('hidden', !isBusiness);
            if (isBusiness) {
                icon.classList.remove('border-gray-300', 'dark:border-white/20');
                icon.classList.add('border-indigo-500', 'bg-indigo-500');
                icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3 text-white"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" /></svg>';
                document.getElementById('business-company-name').focus();
            } else {
                icon.classList.add('border-gray-300', 'dark:border-white/20');
                icon.classList.remove('border-indigo-500', 'bg-indigo-500');
                icon.innerHTML = '';
            }
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
        var escaperoomCountryIso = '{{ $escaperoomCountryIso ?? '' }}';
        var selectedCustomerCountryIso = null;

        function resolveProductShipping(btn) {
            var domestic      = parseFloat(btn.dataset.shippingDomestic) || 0;
            var international = parseFloat(btn.dataset.shippingInternational) || 0;
            if (domestic === 0 && international === 0) return 0;
            if (!selectedCustomerCountryIso || !escaperoomCountryIso) return domestic;
            return selectedCustomerCountryIso.toUpperCase() === escaperoomCountryIso.toUpperCase()
                ? domestic
                : international;
        }

        function recalculateProductShipping() {
            cart.forEach(function (item) {
                if (!item.shippingDomestic && !item.shippingInternational) return;
                var domestic      = item.shippingDomestic || 0;
                var international = item.shippingInternational || 0;
                if (!selectedCustomerCountryIso || !escaperoomCountryIso) {
                    item.shippingCost = domestic;
                } else {
                    item.shippingCost = selectedCustomerCountryIso.toUpperCase() === escaperoomCountryIso.toUpperCase()
                        ? domestic
                        : international;
                }
            });
        }

        function addToCart(btn) {
            var id            = btn.dataset.type + '_' + btn.dataset.id;
            var price         = parseFloat(btn.dataset.price) || 0;
            var originalPrice = parseFloat(btn.dataset.originalPrice || btn.dataset.price) || 0;
            var discountType  = btn.dataset.discountType || '';
            var discountValue = parseFloat(btn.dataset.discountValue) || 0;
            var vat           = parseFloat(btn.dataset.vat)   || 0;
            var stock         = parseInt(btn.dataset.stock, 10); // -1 = unlimited
            var existing      = cart.find(function (i) { return i.id === id; });
            var currentQty    = existing ? existing.qty : 0;

            if (stock !== -1 && currentQty >= stock) return;

            if (existing) {
                existing.qty++;
            } else {
                var shippingDomestic      = parseFloat(btn.dataset.shippingDomestic) || 0;
                var shippingInternational = parseFloat(btn.dataset.shippingInternational) || 0;
                var shippingCost          = (shippingDomestic > 0 || shippingInternational > 0)
                    ? resolveProductShipping(btn)
                    : 0;
                cart.push({ id: id, name: btn.dataset.name, price: price, originalPrice: originalPrice, discountType: discountType, discountValue: discountValue, vat: vat, qty: 1, stock: stock, shippingDomestic: shippingDomestic, shippingInternational: shippingInternational, shippingCost: shippingCost });
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
                var shipping  = item.shippingCost > 0 && (!item.deliveryMethod || item.deliveryMethod === 'post') ? item.shippingCost * item.qty : 0;
                var lineTotal = item.price * item.qty + shipping;
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
                    var shipping  = item.shippingCost > 0 && (!item.deliveryMethod || item.deliveryMethod === 'post') ? item.shippingCost * item.qty : 0;
                    var lineTotal = item.price * item.qty + shipping;
                    var isRoom = item.id.indexOf('room_') === 0;

                    var hasDiscount = item.originalPrice && item.originalPrice > item.price;
                    var isGiftCard = item.id.indexOf('giftcard_') === 0;
                    var subLabel;
                    if (isRoom) {
                        subLabel = '';
                    } else if (isGiftCard) {
                        var dmLabels = { mail: 'E-mail', post: 'Per post', pickup: 'Afhalen' };
                        var dmColors = { mail: 'text-sky-600 dark:text-sky-400', post: 'text-purple-600 dark:text-purple-400', pickup: 'text-teal-600 dark:text-teal-400' };
                        var dm = item.deliveryMethod || 'mail';
                        subLabel = '<span class="text-xs ' + (dmColors[dm] || 'text-gray-400') + '">' + (dmLabels[dm] || dm) + '</span>';
                        if (dm === 'post' && item.shippingCost > 0) {
                            subLabel += '<span class="text-xs text-gray-400 dark:text-gray-500"> + ' + fmt(item.shippingCost) + ' verzending</span>';
                        }
                    } else if (hasDiscount) {
                        var stockSuffix = item.stock !== -1 ? ' · max ' + item.stock : ' / stuk';
                        subLabel = '<span class="text-xs line-through text-gray-400 dark:text-gray-500">' + fmt(item.originalPrice) + '</span>' +
                                   '<span class="text-xs text-green-600 dark:text-green-400 font-medium ml-1">' + fmt(item.price) + '</span>' +
                                   '<span class="text-xs text-gray-400 dark:text-gray-500">' + stockSuffix + '</span>';
                        if (item.shippingCost > 0) {
                            subLabel += '<span class="text-xs text-indigo-500 dark:text-indigo-400"> + ' + fmt(item.shippingCost) + ' verzending</span>';
                        }
                    } else {
                        var perUnitLabel = item.stock !== -1 ? fmt(item.price) + ' · max ' + item.stock : fmt(item.price) + ' / stuk';
                        subLabel = '<span class="text-xs text-gray-400 dark:text-gray-500">' + perUnitLabel + '</span>';
                        if (item.shippingCost > 0) {
                            subLabel += '<span class="text-xs text-indigo-500 dark:text-indigo-400"> + ' + fmt(item.shippingCost) + ' verzending</span>';
                        }
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

        var orderSubmitting = false;

        function submitOrder() {
            if (orderSubmitting) return;
            orderSubmitting = true;

            var btns = [
                document.getElementById('place-order-btn'),
                document.getElementById('place-order-btn-mobile'),
            ];
            btns.forEach(function(btn) {
                if (!btn) return;
                btn.disabled = true;
                btn.textContent = 'Bezig...';
            });

            // Unique key per submit attempt — prevents duplicate orders on multi-click or back+resubmit
            var key = 'ik-' + Date.now() + '-' + Math.random().toString(36).slice(2, 10);
            document.getElementById('form-idempotency-key').value = key;
            // Gather cart totals
            var totaalInclBtw = 0, itemCount = 0;
            var btwPerRate = {};
            cart.forEach(function (item) {
                var shipping  = item.shippingCost > 0 && (!item.deliveryMethod || item.deliveryMethod === 'post') ? item.shippingCost * item.qty : 0;
                var lineTotal = item.price * item.qty + shipping;
                var btwAmount = lineTotal * (item.vat / (100 + item.vat));
                totaalInclBtw += lineTotal;
                itemCount += item.qty;
                if (item.vat > 0) {
                    var key = String(item.vat);
                    btwPerRate[key] = (btwPerRate[key] || 0) + btwAmount;
                }
            });
            var totalBtw = Object.values(btwPerRate).reduce(function (s, v) { return s + v; }, 0);
            var subtotaalExcl = totaalInclBtw - totalBtw;
            var discount = 0;
            if (selectedCoupon && subtotaalExcl > 0) {
                discount = selectedCoupon.discount_type === 'percentage'
                    ? subtotaalExcl * parseFloat(selectedCoupon.discount_value) / 100
                    : Math.min(parseFloat(selectedCoupon.discount_value), subtotaalExcl);
            }
            var discountedExcl = subtotaalExcl - discount;
            var scale = subtotaalExcl > 0 ? discountedExcl / subtotaalExcl : 1;
            var scaledBtw = {};
            Object.keys(btwPerRate).forEach(function (rate) { scaledBtw[rate] = btwPerRate[rate] * scale; });
            var totaal = discountedExcl + Object.values(scaledBtw).reduce(function (s, v) { return s + v; }, 0);

            // Active payment method
            var activeMethod = document.querySelector('.payment-btn[class*="border-indigo"]');
            var paymentMethod = activeMethod ? activeMethod.dataset.method : 'kaart';
            var paymentTerm   = paymentMethod === 'online'
                ? document.getElementById('payment_term').value
                : null;

            document.getElementById('form-customer-id').value    = selectedCustomerId;
            document.getElementById('form-cart').value           = JSON.stringify(cart);
            document.getElementById('form-payment-method').value = paymentMethod;
            document.getElementById('form-payment-term').value   = paymentTerm || '';
            document.getElementById('form-coupon-id').value      = selectedCoupon ? selectedCoupon.id : '';
            document.getElementById('form-totals').value         = JSON.stringify({
                subtotaal_excl:  Math.round(subtotaalExcl  * 100) / 100,
                discount:        Math.round(discount        * 100) / 100,
                btw:             scaledBtw,
                totaal_incl_btw: Math.round(totaal          * 100) / 100,
            });
            document.getElementById('form-business').value       = JSON.stringify(isBusiness ? {
                is_business:         true,
                company_name:        document.getElementById('business-company-name').value,
                vat_number:          document.getElementById('business-vat-number').value,
                registration_number: document.getElementById('business-reg-number').value,
            } : { is_business: false });

            document.getElementById('order-form').submit();
        }

        // ── Quick new customer ────────────────────────────────────────────────
        var countriesList = @json($countries);
        var quickStoreUrl = '{{ route('customers.quickStore') }}';
        var csrfToken     = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

        function openNewCustomerForm() {
            closeDropdown();
            document.getElementById('new-customer-form').classList.remove('hidden');
            // Pre-select België
            var defaultCountry = countriesList.find(function (c) { return c.name === 'België'; });
            if (defaultCountry) {
                document.getElementById('nc-country-search').value = defaultCountry.name;
                document.getElementById('nc-country').value = defaultCountry.name;
            }
            document.getElementById('nc-first-name').focus();
        }

        function cancelNewCustomer() {
            document.getElementById('new-customer-form').classList.add('hidden');
            clearNewCustomerFields();
        }

        function clearNewCustomerFields() {
            ['nc-first-name', 'nc-last-name', 'nc-email', 'nc-phone', 'nc-street', 'nc-house-number', 'nc-postal-code', 'nc-city'].forEach(function (id) {
                document.getElementById(id).value = '';
            });
            document.getElementById('nc-country-search').value = '';
            document.getElementById('nc-country').value = '';
            document.getElementById('nc-country-dropdown').classList.add('hidden');
            var err = document.getElementById('nc-error');
            err.textContent = '';
            err.classList.add('hidden');
        }

        // Country search-select
        (function () {
            var searchEl   = document.getElementById('nc-country-search');
            var hiddenEl   = document.getElementById('nc-country');
            var ddEl       = document.getElementById('nc-country-dropdown');
            var focusIdx   = -1;

            function renderCountries(list) {
                ddEl.innerHTML = '';
                focusIdx = -1;
                if (!list.length) {
                    ddEl.innerHTML = '<li class="px-3 py-2 text-xs text-gray-400">Geen resultaten</li>';
                    ddEl.classList.remove('hidden');
                    return;
                }
                list.forEach(function (c) {
                    var li = document.createElement('li');
                    li.className = 'px-3 py-2 text-sm text-gray-900 dark:text-white cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/20';
                    li.textContent = c.name;
                    li.addEventListener('mousedown', function (e) {
                        e.preventDefault(); // don't blur the input first
                        selectCountry(c);
                    });
                    ddEl.appendChild(li);
                });
                ddEl.classList.remove('hidden');
            }

            function selectCountry(c) {
                searchEl.value  = c.name;
                hiddenEl.value  = c.name;
                ddEl.classList.add('hidden');
            }

            searchEl.addEventListener('input', function () {
                var q = this.value.trim().toLowerCase();
                if (!q) { ddEl.classList.add('hidden'); hiddenEl.value = ''; return; }
                var filtered = countriesList.filter(function (c) {
                    return c.name.toLowerCase().includes(q);
                });
                renderCountries(filtered);
            });

            searchEl.addEventListener('focus', function () {
                var q = this.value.trim().toLowerCase();
                var list = q
                    ? countriesList.filter(function (c) { return c.name.toLowerCase().includes(q); })
                    : countriesList;
                renderCountries(list);
            });

            searchEl.addEventListener('keydown', function (e) {
                var items = ddEl.querySelectorAll('li');
                if (!items.length) return;
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    focusIdx = Math.min(focusIdx + 1, items.length - 1);
                    items.forEach(function (li, i) { li.classList.toggle('bg-indigo-50', i === focusIdx); li.classList.toggle('dark:bg-indigo-900/20', i === focusIdx); });
                    items[focusIdx].scrollIntoView({ block: 'nearest' });
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    focusIdx = Math.max(focusIdx - 1, 0);
                    items.forEach(function (li, i) { li.classList.toggle('bg-indigo-50', i === focusIdx); li.classList.toggle('dark:bg-indigo-900/20', i === focusIdx); });
                    items[focusIdx].scrollIntoView({ block: 'nearest' });
                } else if (e.key === 'Enter' && focusIdx >= 0) {
                    e.preventDefault();
                    var name = items[focusIdx].textContent;
                    var found = countriesList.find(function (c) { return c.name === name; });
                    if (found) selectCountry(found);
                } else if (e.key === 'Escape') {
                    ddEl.classList.add('hidden');
                }
            });

            searchEl.addEventListener('blur', function () {
                // If typed text doesn't match any country exactly, reset hidden value
                setTimeout(function () {
                    ddEl.classList.add('hidden');
                    var match = countriesList.find(function (c) { return c.name.toLowerCase() === searchEl.value.trim().toLowerCase(); });
                    if (match) {
                        searchEl.value = match.name;
                        hiddenEl.value = match.name;
                    } else if (!hiddenEl.value) {
                        searchEl.value = '';
                    }
                }, 150);
            });

            document.addEventListener('click', function (e) {
                if (!searchEl.parentElement.contains(e.target)) ddEl.classList.add('hidden');
            });
        })();

        function saveNewCustomer() {
            var firstName = document.getElementById('nc-first-name').value.trim();
            var lastName  = document.getElementById('nc-last-name').value.trim();
            var email     = document.getElementById('nc-email').value.trim();
            var phone     = document.getElementById('nc-phone').value.trim();
            var errEl     = document.getElementById('nc-error');
            var saveBtn   = document.getElementById('nc-save-btn');

            errEl.classList.add('hidden');
            errEl.textContent = '';

            if (!firstName || !lastName || !email) {
                errEl.textContent = 'Voornaam, achternaam en e-mail zijn verplicht.';
                errEl.classList.remove('hidden');
                return;
            }

            saveBtn.disabled = true;
            saveBtn.textContent = 'Bezig…';

            var street      = document.getElementById('nc-street').value.trim();
            var houseNumber = document.getElementById('nc-house-number').value.trim();
            var postalCode  = document.getElementById('nc-postal-code').value.trim();
            var city        = document.getElementById('nc-city').value.trim();
            var country     = document.getElementById('nc-country').value.trim();

            fetch(quickStoreUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    first_name:   firstName,
                    last_name:    lastName,
                    email:        email,
                    phone:        phone || null,
                    street:       street || null,
                    house_number: houseNumber || null,
                    postal_code:  postalCode || null,
                    city:         city || null,
                    country:      country || null,
                }),
            })
            .then(function (r) {
                if (!r.ok) {
                    return r.json().then(function (data) {
                        var msg = 'Er ging iets mis.';
                        if (data && data.errors) {
                            msg = Object.values(data.errors).flat().join(' ');
                        } else if (data && data.message) {
                            msg = data.message;
                        }
                        throw new Error(msg);
                    });
                }
                return r.json();
            })
            .then(function (customer) {
                document.getElementById('new-customer-form').classList.add('hidden');
                clearNewCustomerFields();
                selectCustomer(customer);
            })
            .catch(function (err) {
                errEl.textContent = err.message;
                errEl.classList.remove('hidden');
            })
            .finally(function () {
                saveBtn.disabled = false;
                saveBtn.textContent = 'Aanmaken';
            });
        }
        // ── End quick new customer ────────────────────────────────────────────

        // ── Gift card delivery modal ──────────────────────────────────
        var gcModalItem = null;

        function openGiftCardModal(btn) {
            gcModalItem = {
                id:           btn.dataset.type + '_' + btn.dataset.id,
                name:         btn.dataset.name,
                price:        parseFloat(btn.dataset.price) || 0,
                vat:          0,
                qty:          1,
                stock:        -1,
                shippingCost: parseFloat(btn.dataset.shippingCost) || 0,
            };
            document.getElementById('gc-modal-title').textContent = btn.dataset.name;

            // Reset to mail
            document.querySelectorAll('.gc-delivery-radio').forEach(function (r) {
                r.checked = r.value === 'mail';
            });
            document.getElementById('gc-modal-shipping-field').classList.add('hidden');
            document.getElementById('gc-modal-shipping-cost').value = '';

            document.getElementById('gc-modal-backdrop').classList.remove('hidden');
            document.getElementById('gc-modal-backdrop').classList.add('flex');
        }

        function closeGiftCardModal(e) {
            if (e && e.target !== document.getElementById('gc-modal-backdrop')) return;
            document.getElementById('gc-modal-backdrop').classList.add('hidden');
            document.getElementById('gc-modal-backdrop').classList.remove('flex');
            gcModalItem = null;
        }

        function gcToggleShipping(value) {
            var field = document.getElementById('gc-modal-shipping-field');
            var input = document.getElementById('gc-modal-shipping-cost');
            if (value === 'post') {
                field.classList.remove('hidden');
                if (gcModalItem && gcModalItem.shippingCost > 0) {
                    input.value = gcModalItem.shippingCost.toFixed(2);
                }
            } else {
                field.classList.add('hidden');
                input.value = '';
            }
        }

        function addGiftCardToCart() {
            if (!gcModalItem) return;
            var deliveryMethod = document.querySelector('.gc-delivery-radio:checked')?.value || 'mail';
            var shippingCost   = deliveryMethod === 'post'
                ? parseFloat(document.getElementById('gc-modal-shipping-cost').value) || 0
                : 0;

            var item = Object.assign({}, gcModalItem, { deliveryMethod: deliveryMethod, shippingCost: shippingCost });
            var existing = cart.find(function (i) { return i.id === item.id && i.deliveryMethod === deliveryMethod; });
            if (existing) {
                existing.qty++;
            } else {
                cart.push(item);
            }

            renderCart();
            document.getElementById('gc-modal-backdrop').classList.add('hidden');
            document.getElementById('gc-modal-backdrop').classList.remove('flex');
            gcModalItem = null;
        }

        // ── Product variant modal ────────────────────────────────────────────
        var variantModalBase = null;
        var selectedVariant  = null;

        function openVariantModal(btn) {
            var variants = JSON.parse(btn.dataset.variants || '[]');
            if (!variants.length) { addToCart(btn); return; }

            variantModalBase = {
                productId:             btn.dataset.id,
                name:                  btn.dataset.name,
                basePrice:             parseFloat(btn.dataset.price) || 0,
                originalPrice:         parseFloat(btn.dataset.originalPrice || btn.dataset.price) || 0,
                discountType:          btn.dataset.discountType || '',
                discountValue:         parseFloat(btn.dataset.discountValue) || 0,
                vat:                   parseFloat(btn.dataset.vat) || 0,
                shippingDomestic:      parseFloat(btn.dataset.shippingDomestic) || 0,
                shippingInternational: parseFloat(btn.dataset.shippingInternational) || 0,
                variants:              variants,
            };
            selectedVariant = null;

            var hasShipping = variantModalBase.shippingDomestic > 0 || variantModalBase.shippingInternational > 0;
            document.getElementById('variant-modal-title').textContent = btn.dataset.name;
            document.getElementById('variant-modal-shipping').classList.toggle('hidden', !hasShipping);

            if (hasShipping) {
                var computed = (selectedCustomerCountryIso && escaperoomCountryIso &&
                    selectedCustomerCountryIso.toUpperCase() === escaperoomCountryIso.toUpperCase())
                    ? variantModalBase.shippingDomestic
                    : variantModalBase.shippingInternational || variantModalBase.shippingDomestic;
                document.getElementById('variant-modal-shipping-cost').value = computed > 0 ? computed.toFixed(2) : '';
            }

            var fmt = function (n) { return '€ ' + n.toFixed(2).replace('.', ','); };
            var listEl = document.getElementById('variant-modal-list');
            listEl.innerHTML = '';
            variants.forEach(function (v) {
                var price   = v.selling_price !== null ? parseFloat(v.selling_price) : variantModalBase.basePrice;
                var stock   = v.stock_quantity;
                var outOfStock = stock !== null && stock <= 0;
                var label = document.createElement('label');
                label.className = 'flex items-center justify-between rounded-lg border-2 px-4 py-3 cursor-pointer transition-colors ' +
                    (outOfStock
                        ? 'border-gray-100 dark:border-white/5 opacity-40 cursor-not-allowed'
                        : 'border-gray-200 dark:border-white/10 hover:border-indigo-300 dark:hover:border-indigo-500 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/20');
                label.innerHTML =
                    '<div class="flex items-center gap-3">' +
                        '<input type="radio" name="variant_select" value="' + v.id + '" data-price="' + price + '" data-stock="' + (stock !== null ? stock : -1) + '"' +
                        (outOfStock ? ' disabled' : '') +
                        ' class="accent-indigo-600">' +
                        '<span class="text-sm font-medium text-gray-900 dark:text-white">' + v.name + '</span>' +
                    '</div>' +
                    '<div class="text-right">' +
                        '<span class="text-sm text-gray-700 dark:text-gray-300">' + fmt(price) + '</span>' +
                        (stock !== null ? '<span class="block text-xs text-gray-400 dark:text-gray-500">' + (outOfStock ? 'Uitverkocht' : stock + ' op voorraad') + '</span>' : '') +
                    '</div>';
                listEl.appendChild(label);
            });

            document.getElementById('variant-modal-backdrop').classList.remove('hidden');
            document.getElementById('variant-modal-backdrop').classList.add('flex');
        }

        function closeVariantModal(e) {
            if (e && e.target !== document.getElementById('variant-modal-backdrop')) return;
            document.getElementById('variant-modal-backdrop').classList.add('hidden');
            document.getElementById('variant-modal-backdrop').classList.remove('flex');
            variantModalBase = null;
            selectedVariant  = null;
        }

        function addVariantToCart() {
            if (!variantModalBase) return;
            var checked = document.querySelector('input[name="variant_select"]:checked');
            if (!checked) { alert('Kies eerst een variatie.'); return; }

            var variantId    = parseInt(checked.value, 10);
            var variantPrice = parseFloat(checked.dataset.price) || variantModalBase.basePrice;
            var variantStock = parseInt(checked.dataset.stock, 10);
            var variantObj   = variantModalBase.variants.find(function (v) { return v.id === variantId; });

            var hasShipping  = variantModalBase.shippingDomestic > 0 || variantModalBase.shippingInternational > 0;
            var shippingCost = hasShipping ? (parseFloat(document.getElementById('variant-modal-shipping-cost').value) || 0) : 0;

            var id = 'product_' + variantModalBase.productId + '_v' + variantId;
            var existing = cart.find(function (i) { return i.id === id; });
            if (existing) {
                if (variantStock !== -1 && existing.qty >= variantStock) { closeVariantModal(); return; }
                existing.qty++;
                existing.shippingCost = shippingCost;
            } else {
                cart.push({
                    id:                    id,
                    name:                  variantModalBase.name + ' – ' + (variantObj ? variantObj.name : ''),
                    price:                 variantPrice,
                    originalPrice:         variantPrice,
                    discountType:          '',
                    discountValue:         0,
                    vat:                   variantModalBase.vat,
                    qty:                   1,
                    stock:                 variantStock,
                    shippingDomestic:      variantModalBase.shippingDomestic,
                    shippingInternational: variantModalBase.shippingInternational,
                    shippingCost:          shippingCost,
                    productId:             variantModalBase.productId,
                    variantId:             variantId,
                    variantName:           variantObj ? variantObj.name : '',
                });
            }

            renderCart();
            document.getElementById('variant-modal-backdrop').classList.add('hidden');
            document.getElementById('variant-modal-backdrop').classList.remove('flex');
            variantModalBase = null;
            selectedVariant  = null;
        }

        // ── Product shipping modal ────────────────────────────────────────────
        var prodModalItem = null;

        function openProductModal(btn) {
            var domestic      = parseFloat(btn.dataset.shippingDomestic) || 0;
            var international = parseFloat(btn.dataset.shippingInternational) || 0;
            var computed      = resolveProductShipping(btn);

            prodModalItem = {
                id:                    btn.dataset.type + '_' + btn.dataset.id,
                name:                  btn.dataset.name,
                price:                 parseFloat(btn.dataset.price) || 0,
                originalPrice:         parseFloat(btn.dataset.originalPrice || btn.dataset.price) || 0,
                discountType:          btn.dataset.discountType || '',
                discountValue:         parseFloat(btn.dataset.discountValue) || 0,
                vat:                   parseFloat(btn.dataset.vat) || 0,
                qty:                   1,
                stock:                 parseInt(btn.dataset.stock, 10),
                shippingDomestic:      domestic,
                shippingInternational: international,
                shippingCost:          computed,
            };

            var fmt = function (n) { return '€ ' + n.toFixed(2).replace('.', ','); };
            document.getElementById('prod-modal-title').textContent = btn.dataset.name;
            document.getElementById('prod-modal-price').textContent = fmt(prodModalItem.price) + ' / stuk';
            document.getElementById('prod-modal-shipping-cost').value = computed > 0 ? computed.toFixed(2) : '';

            var hint = '';
            if (domestic > 0 || international > 0) {
                hint = 'Binnenland: ' + fmt(domestic) + ' · Internationaal: ' + fmt(international);
            }
            document.getElementById('prod-modal-shipping-hint').textContent = hint;

            document.getElementById('prod-modal-backdrop').classList.remove('hidden');
            document.getElementById('prod-modal-backdrop').classList.add('flex');
            document.getElementById('prod-modal-shipping-cost').focus();
        }

        function closeProductModal(e) {
            if (e && e.target !== document.getElementById('prod-modal-backdrop')) return;
            document.getElementById('prod-modal-backdrop').classList.add('hidden');
            document.getElementById('prod-modal-backdrop').classList.remove('flex');
            prodModalItem = null;
        }

        function addProductFromModal() {
            if (!prodModalItem) return;
            var shippingCost = parseFloat(document.getElementById('prod-modal-shipping-cost').value) || 0;
            var item = Object.assign({}, prodModalItem, { shippingCost: shippingCost });

            var existing = cart.find(function (i) { return i.id === item.id; });
            if (existing) {
                if (item.stock !== -1 && existing.qty >= item.stock) {
                    closeProductModal();
                    return;
                }
                existing.qty++;
                existing.shippingCost = shippingCost;
            } else {
                cart.push(item);
            }

            renderCart();
            document.getElementById('prod-modal-backdrop').classList.add('hidden');
            document.getElementById('prod-modal-backdrop').classList.remove('flex');
            prodModalItem = null;
        }
        // ─────────────────────────────────────────────────────────────

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
