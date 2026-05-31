<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamer', 'url' => route('rooms.index')],
    ]" />
    <div class="overflow-hidden bg-gray-900">
        <h2 id="profile-overview-title" class="sr-only">Profile Overview</h2>
        <div class="bg-gray-800/75 p-6">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex sm:space-x-5">
                    <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                        <p class="text-xl font-bold text-white sm:text-2xl">{{ $customer->first_name }}
                            {{ $customer->last_name }}
                        </p>
                    </div>
                </div>
                <div class="mt-5 flex justify-center sm:mt-0">
                    <form method="POST" action="{{ route('customers.show.overview', $customer->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="flex items-center justify-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Ban
                            profile</button>
                    </form>
                </div>
            </div>
        </div>
        <div
            class="grid grid-cols-1 divide-y divide-white/10 border-t border-white/10 bg-gray-800/50 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
            <div class="px-6 py-5 text-center text-sm font-medium flex flex-col gap-1">
                <span class="text-xs text-gray-400 uppercase tracking-wide">Klantnummer</span>
                <span class="text-white text-lg font-semibold">#{{ $customer->id }}</span>
            </div>
            <div class="px-6 py-5 text-center text-sm font-medium flex flex-col gap-1">
                <span class="text-xs text-gray-400 uppercase tracking-wide">Volgende afspraak</span>
                <span class="text-white text-lg font-semibold">Geen</span>
            </div>
            <div class="px-6 py-5 text-center text-sm font-medium flex flex-col gap-1">
                <span class="text-xs text-gray-400 uppercase tracking-wide">Vorige afspraak</span>
                <span class="text-white text-lg font-semibold">DATUM</span>
            </div>
        </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="relative border-b border-white/10 pb-5 sm:pb-0">
            <div class="md:flex md:items-center md:justify-between">
                <h3 class="text-base font-semibold text-white">{{ $customer->first_name }} {{ $customer->last_name }}
                </h3>
                <div class="mt-3 flex md:absolute md:top-3 md:right-0 md:mt-0">
                    <button type="button"
                        class="ml-3 inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Aanpassen</button>
                </div>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-1 sm:hidden">
                    <select aria-label="Select a tab" onchange="window.location = this.value"
                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white/5 py-2 pr-8 pl-3 text-base text-white outline-1 -outline-offset-1 outline-white/10 *:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-white">
                        <option value="{{ route('customers.show.overview', $customer->id) }}"
                            @selected(request()->routeIs('customers.show.overview'))>Overzicht</option>
                        <option value="{{ route('customers.show.appointments', $customer->id) }}"
                            @selected(request()->routeIs('customers.show.appointments'))>Afspraken</option>
                        <option value="{{ route('customers.show.messages', $customer->id) }}"
                            @selected(request()->routeIs('customers.show.messages'))>Berichten</option>
                        <option value="{{ route('customers.show.purchases', $customer->id) }}"
                            @selected(request()->routeIs('customers.show.purchases'))>Aankopen</option>
                        <option value="{{ route('customers.show.gift-cards', $customer->id) }}"
                            @selected(request()->routeIs('customers.show.gift-cards'))>Kortingsbonnen</option>
                    </select>
                    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-400">
                        <path
                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" fill-rule="evenodd" />
                    </svg>
                </div>
                <!-- Tabs at small breakpoint and up -->
                <div class="hidden sm:block">
                    <nav class="-mb-px flex space-x-8">
                        <a href="{{ route('customers.show.overview', $customer->id) }}" aria-current="page"
                            class="border-b-2 border-indigo-400 px-1 pb-4 text-sm font-medium whitespace-nowrap text-indigo-400">Overzicht</a>
                        <a href="{{ route('customers.show.appointments', $customer->id) }}"
                            class="border-b-2 border-transparent px-1 pb-4 text-sm font-medium whitespace-nowrap text-gray-400 hover:border-white/20 hover:text-white">Afspraken</a>
                        <a href="{{ route('customers.show.messages', $customer->id) }}"
                            class="border-b-2 border-transparent px-1 pb-4 text-sm font-medium whitespace-nowrap text-gray-400 hover:border-white/20 hover:text-white">Berichten</a>
                        <a href="{{ route('customers.show.purchases', $customer->id) }}"
                            class="border-b-2 border-transparent px-1 pb-4 text-sm font-medium whitespace-nowrap text-gray-400 hover:border-white/20 hover:text-white">Aankopen</a>
                        <a href="{{ route('customers.show.gift-cards', $customer->id) }}"
                            class="border-b-2 border-transparent px-1 pb-4 text-sm font-medium whitespace-nowrap text-gray-400 hover:border-white/20 hover:text-white">Kortingsbonnen</a>
                    </nav>
                </div>
            </div>
        </div>
        <div>
            <dl class="grid grid-cols-1 sm:grid-cols-2">
                <div class="border-t border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-white">Volledige Naam</dt>
                    <dd class="mt-1 text-sm/6 text-gray-400 sm:mt-2">{{ ucfirst($customer->first_name) }}
                        {{ ucfirst($customer->last_name) }}
                    </dd>
                </div>
                <div class="border-t border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-white">Telefoonnummer</dt>
                    <dd class="mt-1 text-sm/6 text-gray-400 sm:mt-2">
                        {{ $customer->phone ?? 'Geen telefoonnummer opgegeven' }}
                    </dd>
                </div>
                <div class="border-t border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-white">Email</dt>
                    <dd class="mt-1 text-sm/6 text-gray-400 sm:mt-2">{{ $customer->email }}</dd>
                </div>
                <div class="border-t border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-white">Adres</dt>
                    <dd class="mt-1 text-sm/6 text-gray-400 sm:mt-2">{{ ucfirst($customer->street) }}
                        {{ $customer->house_number }}, {{ ucfirst($customer->city) }} {{ $customer->postal_code }},
                        {{ ucfirst($customer->country) }}</dd>
                </div>

                <div class="border-t border-white/10 px-4 py-6 sm:col-span-2 sm:px-0">
                    <dt class="text-sm/6 font-medium text-white">Aanmaakdatum</dt>
                    <dd class="mt-1 text-sm/6 text-gray-400 sm:mt-2">{{ $customer->created_at->format('d-m-Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</x-layouts.app>