<x-layouts.app>
    <x-success :message="session('message')" />
    <x-error name="message" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Klanten', 'url' => route('customers.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">Klanten</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Een lijst van alle klanten.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-3">
                    <form method="GET" action="{{ route('customers.index') }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Zoek klant..."
                            class="w-64 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 py-2 pl-10 pr-4 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" />

                        {{-- Search icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.25 11.25Z" />
                        </svg>
                    </form>
                </div>
            </div>
            @if ($customers->count() > 0)
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8 dark:text-white">
                                                Klant ID</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Naam</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Adres</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Telefoon</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Email</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Aangemaakt</th>
                                            <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                                                <span class="sr-only">Acties</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-900">
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td
                                                    class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6 lg:pl-8 dark:text-white">
                                                    {{ $customer->id }}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customer->first_name }} {{ $customer->last_name }}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customer->street }}
                                                    {{ $customer->house_number }},
                                                    {{ $customer->postal_code }} {{ $customer->city }}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customer->phone ?? 'Niet opgegeven' }}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customer->email }}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customer->created_at->format('d-m-Y H:i') }}
                                                </td>
                                                <td
                                                    class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">
                                                    <div class="flex items-center justify-end gap-4">
                                                        <a href="{{ route('customers.show.overview', $customer->id) }}"
                                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                            Bekijken
                                                            <span class="sr-only">, {{ $customer->name }}</span>
                                                        </a>
                                                        <form method="POST" action="{{ route('rooms.destroy', $customer->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-red-600 cursor-pointer hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                                Verwijderen
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <x-empty-state name='customer' />
        @endif
        {{ $customers->links() }}
    </div>
</x-layouts.app>