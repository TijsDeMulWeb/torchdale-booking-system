<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kortingsbonnen', 'url' => route('coupons.index')],
        ['name' => $coupon->name, 'url' => route('coupons.edit', $coupon->id)],
        ['name' => 'Edit', 'url' => route('coupons.edit', $coupon->id)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('coupons.store') }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Kortingsbon</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over de kortingsbon.</p>
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Kortingsbon
                                Naam</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="Kortingsbon Naam"
                                    value="{{ old('name', $coupon->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="description"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschrijving</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <textarea id="description" name="description" rows="3"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">{{ old('description', $coupon->description) }}</textarea>
                                <x-form.error name="description" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="code"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Kortingsbon
                                CODE</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="code" type="text" name="code" placeholder="Kortingsbon CODE"
                                    value="{{ old('code', $coupon->code) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="code" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="discountType"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Kortings
                                Type</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="discountType" name="discount_type"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        <option value="fixed" {{ old('discount_type', $coupon->discount_type) === 'fixed' ? 'selected' : '' }}>
                                            Fixed</option>
                                        <option value="percentage" {{ old('discount_type', $coupon->discount_type) === 'percentage' ? 'selected' : '' }}>Percentage
                                        </option>
                                    </select>
                                    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4 dark:text-gray-400">
                                        <path
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="discountValue"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Kortingswaarde</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="discountValue" type="text" name="discount_value" placeholder="Kortingswaarde"
                                    value="{{ old('discount_value', $coupon->discount_value) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="discount_value" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="usageLimit"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Gebruikslimiet</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="usageLimit" type="text" name="usage_limit" placeholder="Gebruikslimiet"
                                    value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="usage_limit" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="availableFrom"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschikbaar
                                vanaf</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="availableFrom" type="date" name="valid_from"
                                    value="{{ old('valid_from', $coupon->valid_from->format('Y-m-d')) }}"
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
                                    value="{{ old('valid_until', $coupon->valid_until) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="valid_until" />
                            </div>
                        </div>

                        <div class="my-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('coupons.index') }}"
                                class="text-sm/6 font-semibold text-gray-900 dark:text-white">Cancel</a>
                            <button type="submit"
                                class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>