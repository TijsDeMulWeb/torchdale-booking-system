<div class="relative border-b border-white/10 pb-5 sm:pb-0">
    <div class="md:flex md:items-center md:justify-between">
        <h3 class="text-base font-semibold text-white">{{ $customer->first_name }} {{ $customer->last_name }}
        </h3>
        <div class="mt-3 flex md:absolute md:top-3 md:right-0 md:mt-0">
            <a href="{{ route('customers.edit.overview', $customer->id) }}"
                class="ml-3 inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Aanpassen</a>
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
                @php
                    $tabs = [
                        'customers.show.overview' => 'Overzicht',
                        'customers.show.appointments' => 'Afspraken',
                        'customers.show.messages' => 'Berichten',
                        'customers.show.purchases' => 'Aankopen',
                        'customers.show.gift-cards' => 'Kortingsbonnen',
                    ];
                @endphp

                @foreach ($tabs as $routeName => $label)
                    <a href="{{ route($routeName, $customer->id) }}" @class([
                        'border-b-2 px-1 pb-4 text-sm font-medium whitespace-nowrap',
                        'border-indigo-400 text-indigo-400' => request()->routeIs($routeName),
                        'border-transparent text-gray-400 hover:border-white/20 hover:text-white' => !request()->routeIs($routeName),
                    ])>
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>
</div>