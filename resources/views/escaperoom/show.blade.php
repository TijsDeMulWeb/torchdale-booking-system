<x-layouts.app>
    <x-success :message="session('message')" />
    <x-error name="message" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Instellingen: ' . auth()->user()->escaperoom->name, 'url' => route('escaperoom.show')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div>
            <div class="px-4 sm:px-0 sm:flex sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">Escaperoom Informatie</h3>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">Informatie over het escaperoom.
                    </p>
                </div>
                <a href="{{ route('escaperoom.edit') }}"
                    class="mt-4 sm:mt-0 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500">
                    Bewerken
                </a>
            </div>
            <div class="mt-6 border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Naam</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $escaperoom->name }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Telefoon</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $escaperoom->phone }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Email</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $escaperoom->email }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">BTW Nummer</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $escaperoom->vat_number }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Registratie Nummer</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $escaperoom->registration_number ?? 'Niet ingesteld' }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Escaperoom Key</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ Str::limit($escaperoom->escaperoomSetting->escaperoom_api_key ?? 'Niet ingesteld', 50) }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Mollie Key</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $escaperoom->escaperoomSetting->mollie_key ?? 'Niet ingesteld' }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">OpenAI Key</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ Str::limit($escaperoom->escaperoomSetting->openai_api_key ?? 'Niet ingesteld', 50) }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="px-4 sm:px-0 lg:px-0 my-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <h2 class="sr-only">Adressen</h2>
                    @foreach ($escaperoomAddresses as $escaperoomAddress)
                        <div
                            class="relative rounded-lg bg-gray-50 shadow-xs outline-1 outline-gray-900/5 dark:bg-gray-800/50 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                            <form method="POST" action="{{ route('escaperoomAddress.destroy', $escaperoomAddress->id) }}"
                                class="absolute top-4 right-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 dark:hover:text-red-400 cursor-pointer">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                            <dl class="flex flex-wrap">
                                <div class="flex-auto pt-6 pl-6">
                                    <dt class="text-sm/6 font-semibold text-gray-900 dark:text-gray-100">Adres</dt>
                                    <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $escaperoomAddress->street }} {{ $escaperoomAddress->house_number }}
                                    </dd>
                                </div>
                                <div class="flex-none self-end px-6 pt-4">
                                    <dt class="sr-only">Status</dt>
                                    @if ($escaperoomAddress->is_primary)
                                        <dd
                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 inset-ring inset-ring-green-600/20 dark:bg-green-500/15 dark:text-green-400 dark:inset-ring-green-500/20">

                                            Primary</dd>
                                    @endif
                                </div>
                                <div
                                    class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6 dark:border-white/5">
                                    <dt class="flex-none">
                                        <span class="sr-only">City</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"
                                            class="h-6 w-5 text-gray-400">
                                            <path fill-rule="evenodd"
                                                d="M10 2a6 6 0 0 0-6 6c0 4.25 6 10 6 10s6-5.75 6-10a6 6 0 0 0-6-6Zm0 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </dt>
                                    <dd class="text-sm/6 font-medium text-gray-900 dark:text-white">
                                        {{ $escaperoomAddress->postal_code }} {{ $escaperoomAddress->city }}
                                    </dd>
                                </div>
                                <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                                    <dt class="flex-none">
                                        <span class="sr-only">Country</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="h-6 w-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9Zm0 0c2.5 2.5 2.5 16.5 0 19m0-19c-2.5 2.5-2.5 16.5 0 19M3 12h18" />
                                        </svg>
                                    </dt>
                                    <dd class="text-sm/6 text-gray-500 dark:text-gray-300">
                                        {{ $escaperoomAddress->country->name }}
                                    </dd>
                                </div>
                            </dl>
                            <div class="mt-6 border-t border-gray-900/5 px-6 py-6 dark:border-white/5">
                                <a href="{{ route('escaperoomAddress.edit', $escaperoomAddress->id) }}"
                                    class="text-sm/6 font-semibold text-gray-900 hover:text-gray-700 dark:text-white dark:hover:text-gray-300">Bewerken
                                    <span aria-hidden="true">&rarr;</span></a>
                            </div>
                        </div>
                    @endforeach
                    <div
                        class="rounded-lg border-2 border-dashed border-gray-300 dark:border-white/20 flex flex-col items-center justify-center text-center px-6 py-10 hover:border-indigo-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-10 w-10 text-gray-400 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Nieuw adres
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Voeg een nieuw adres toe
                        </p>
                        <a href="{{ route('escaperoomAddress.create') }}"
                            class="mt-4 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                            Toevoegen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>