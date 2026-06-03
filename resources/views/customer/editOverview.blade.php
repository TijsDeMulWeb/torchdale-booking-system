<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Klant', 'url' => route('customers.index')],
        ['name' => $customer->full_name, 'url' => route('customers.show.overview', $customer)],
    ]" />
    <x-profile.header :customer="$customer" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />
        <form action="{{ route('customers.update.overview', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div
                    class="space-y-8 border-b border-gray-200 dark:border-white/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-200 dark:sm:divide-white/10 sm:border-t sm:border-t-gray-200 dark:sm:border-t-white/10 sm:pb-0">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="firstName"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Voornaam</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="firstName" type="text" name="first_name"
                                value="{{ old('first_name', $customer->first_name) }}" autocomplete="given-name"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="first_name" />
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="lastName"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Achternaam</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="lastName" type="text" name="last_name"
                                value="{{ old('last_name', $customer->last_name) }}" autocomplete="family-name"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="last_name" />
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="email"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Email</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="email" type="email" name="email" value="{{ old('email', $customer->email) }}"
                                autocomplete="email"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="email" />
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="phone"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Telefoonnummer</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="phone" type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                                autocomplete="tel"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="phone" />
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="street"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Straat</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="street" type="text" name="street" value="{{ old('street', $customer->street) }}"
                                autocomplete="street-address"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                        </div>
                        <x-form.error name="street" />
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="houseNumber"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Huisnummer</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="houseNumber" type="text" name="house_number"
                                value="{{ old('house_number', $customer->house_number) }}"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="house_number" />
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="city"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Stad</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="city" type="text" name="city" value="{{ old('city', $customer->city) }}"
                                autocomplete="address-level2"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="city" />
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="postalCode"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Postcode</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="postalCode" type="text" name="postal_code"
                                value="{{ old('postal_code', $customer->postal_code) }}" autocomplete="postal-code"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="postal_code" />
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <label for="country"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white sm:pt-1.5">Land</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="country" type="text" name="country"
                                value="{{ old('country', $customer->country) }}" autocomplete="country"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            <x-form.error name="country" />
                        </div>
                    </div>
                </div>
            </div>
            <x-form.actions route="customers.show.overview" :params="[$customer->id]" />
        </form>
    </div>
</x-layouts.app>