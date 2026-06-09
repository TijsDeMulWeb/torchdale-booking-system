<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Cadeaubon', 'url' => route('giftCards.index')],
        ['name' => $giftCard->name, 'url' => route('giftCards.edit', $giftCard->id)],
        ['name' => 'Wijzigen', 'url' => route('giftCards.edit', $giftCard->id)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('giftCards.update', $giftCard->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Cadeaubon</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over de Cadeaubon.</p>
                    <x-last-updated :model="$giftCard" />
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Cadeaubon
                                Naam</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="Cadeaubon Naam"
                                    value="{{ old('name', $giftCard->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="description"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschrijving</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <textarea id="description" name="description" rows="3"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">{{ old('description', $giftCard->description) }}</textarea>
                                <x-form.error name="description" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="discountValue"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Cadeaubonwaarde</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="discountValue" type="text" name="amount" placeholder="Cadeaubonwaarde"
                                    value="{{ old('amount', $giftCard->amount) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="amount" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="availableFrom"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschikbaar
                                vanaf</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="availableFrom" type="date" name="valid_from"
                                    value="{{ old('valid_from', $giftCard->valid_from->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="valid_from" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="availableUntil"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschikbaar
                                tot</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="availableUntil" type="date" name="valid_until"
                                    value="{{ old('valid_until', $giftCard->valid_until?->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="valid_until" />
                            </div>
                        </div>

                        {{-- Shipping cost --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="gc-shipping-cost" class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">
                                Verzendkosten
                                <span class="block mt-0.5 font-normal text-xs text-gray-500 dark:text-gray-400">Bij levering per post</span>
                            </label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="relative sm:max-w-xs">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">€</span>
                                    <input id="gc-shipping-cost" type="number" name="shipping_cost" min="0" max="99.99" step="0.01"
                                        value="{{ old('shipping_cost', number_format((float)($giftCard->shipping_cost ?? 0), 2, '.', '')) }}"
                                        class="block w-full pl-7 rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-xs sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Wordt automatisch toegepast wanneer "Per post" gekozen wordt bij een bon.</p>
                                <x-form.error name="shipping_cost" />
                            </div>
                        </div>

                        <x-form.actions route="giftCards.index" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>