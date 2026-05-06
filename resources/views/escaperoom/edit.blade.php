<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => $escaperoom->name, 'url' => route('escaperoom.show')],
        ['name' => 'Edit', 'url' => route('escaperoom.edit')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('escaperoom.update') }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Escaperoom</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over jouw bedrijf.</p>

                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Bedrijfsnaam</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="Bedrijfsnaam"
                                    value="{{ old('name', $escaperoom->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="phone"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Telefoonnummer</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="phone" type="text" name="phone" placeholder="Telefoonnummer"
                                    value="{{ old('phone', $escaperoom->phone) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="email"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Email</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="email" type="email" name="email" placeholder="Email"
                                    value="{{ old('email', $escaperoom->email) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="vat_number"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">BTW
                                Nummer</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="vat_number" type="text" name="vat_number" placeholder="BTW Nummer"
                                    value="{{ old('vat_number', $escaperoom->vat_number) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="registration_number"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Registratie
                                Nummer</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="registration_number" type="text" name="registration_number"
                                    placeholder="Registratie Nummer"
                                    value="{{ old('registration_number', $escaperoom->registration_number) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="mollie_api_key"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Mollie API
                                Key</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="mollie_api_key" type="text" name="mollie_api_key"
                                    placeholder="Mollie API Key"
                                    value="{{ old('mollie_api_key', $escaperoom->escaperoomSetting->mollie_api_key) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="openai_api_key"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">OpenAI API
                                Key</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="openai_api_key" type="text" name="openai_api_key"
                                    placeholder="OpenAI API Key"
                                    value="{{ old('openai_api_key', $escaperoom->escaperoomSetting->openai_api_key) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Adres Informatie</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Verander hier jouw adresinformatie.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Cancel</button>
                <button type="submit"
                    class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Save</button>
            </div>
        </form>
    </div>
</x-layouts.app>