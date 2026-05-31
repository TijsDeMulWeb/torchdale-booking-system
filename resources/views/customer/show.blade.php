<x-layouts.app>
    <x-success :message="session('message')" />
    <x-error name="message" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamer', 'url' => route('rooms.index')],
    ]" />
    <x-profile.header :customer="$customer" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />
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
                        {{ ucfirst($customer->country) }}
                    </dd>
                </div>

                <div class="border-t border-white/10 px-4 py-6 sm:col-span-2 sm:px-0">
                    <dt class="text-sm/6 font-medium text-white">Aanmaakdatum</dt>
                    <dd class="mt-1 text-sm/6 text-gray-400 sm:mt-2">{{ $customer->created_at->format('d-m-Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</x-layouts.app>