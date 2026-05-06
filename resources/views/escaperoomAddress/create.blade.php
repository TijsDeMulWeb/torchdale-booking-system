<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Instellingen: ' . Auth()->user()->escaperoom->name, 'url' => route('escaperoom.show')],
        ['name' => 'Adres toevoegen', 'url' => route('escaperoomAddress.create')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('escaperoomAddress.store') }}">
            @csrf
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Escaperoom</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over jouw bedrijf.</p>
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="street"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Straat</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="street" type="text" name="street" placeholder="Straat"
                                    value="{{ old('street', $escaperoomAddress->street) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="street" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="house_number"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Huisnummer</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="house_number" type="text" name="house_number" placeholder="Huisnummer"
                                    value="{{ old('house_number', $escaperoomAddress->house_number) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="house_number" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="postal_code"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Postcode</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="postal_code" type="text" name="postal_code" placeholder="Postcode"
                                    value="{{ old('postal_code', $escaperoomAddress->postal_code) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="postal_code" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="city"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Stad</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="city" type="text" name="city" placeholder="Stad"
                                    value="{{ old('city', $escaperoomAddress->city) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="city" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="country"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Country</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="country" name="country_id" autocomplete="country-name"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', $escaperoomAddress->country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4 dark:text-gray-400">
                                        <path
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                    <x-form.error name="country_id" />
                                </div>
                            </div>
                        </div>
                        <fieldset>
                            <legend class="sr-only">Hoofdlocatie</legend>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:py-6">
                                <div aria-hidden="true" class="text-sm/6 font-semibold text-gray-900 dark:text-white">
                                    Hoofdlocatie</div>
                                <div class="mt-4 sm:col-span-2 sm:mt-0">
                                    <div class="max-w-lg space-y-6">
                                        <div class="flex gap-3">
                                            <div class="flex h-6 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input type="hidden" name="is_primary" value="0" />
                                                    <input id="isPrimary" type="checkbox" name="is_primary" value="1" {{ old('is_primary', $escaperoomAddress->is_primary) == true ? 'checked' : '' }} aria-describedby="comments-description"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 dark:border-white/10 dark:bg-white/5 dark:checked:border-indigo-500 dark:checked:bg-indigo-500 dark:indeterminate:border-indigo-500 dark:indeterminate:bg-indigo-500 dark:focus-visible:outline-indigo-500 dark:disabled:border-white/5 dark:disabled:bg-white/10 dark:disabled:checked:bg-white/10 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25 dark:group-has-disabled:stroke-white/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="text-sm/6">
                                                <label for="isPrimary"
                                                    class="font-medium text-gray-900 dark:text-white">Hoofdlocatie</label>
                                                <p id="isPrimary-description" class="text-gray-500 dark:text-gray-400">
                                                    Is dit de hoofdlocatie? Dit adres wordt gebruikt voor facturatie.
                                                </p>
                                                <x-form.error name="is_primary" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('escaperoom.show') }}"
                    class="text-sm/6 font-semibold text-gray-900 dark:text-white">Cancel</a>
                <button type="submit"
                    class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Save</button>
            </div>
        </form>
    </div>
</x-layouts.app>