<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Klant', 'url' => route('customers.index')],
        ['name' => $customer->full_name, 'url' => route('customers.show.overview', $customer)],
    ]" />
    <x-profile.header :customer="$customer" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />
        <div>
            <dl class="grid grid-cols-1 sm:grid-cols-2">
                <div class="border-t border-gray-200 dark:border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Volledige Naam</dt>
                    <dd class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400 sm:mt-2">{{ $customer->full_name }}
                    </dd>
                </div>
                <div class="border-t border-gray-200 dark:border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Telefoonnummer</dt>
                    <dd class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400 sm:mt-2">
                        {{ $customer->phone ?? 'Geen telefoonnummer opgegeven' }}
                    </dd>
                </div>
                <div class="border-t border-gray-200 dark:border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Email</dt>
                    <dd class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400 sm:mt-2">{{ $customer->email }}</dd>
                </div>
                <div class="border-t border-gray-200 dark:border-white/10 px-4 py-6 sm:col-span-1 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Adres</dt>
                    <dd class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400 sm:mt-2">{{ $customer->full_address}}
                    </dd>
                </div>

                <div class="border-t border-gray-200 dark:border-white/10 px-4 py-6 sm:col-span-2 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Aanmaakdatum</dt>
                    <dd class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400 sm:mt-2">{{ $customer->created_at->format('d-m-Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</x-layouts.app>