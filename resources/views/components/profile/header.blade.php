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
                @if (empty($customer->banned_at))
                    <form method="POST" action="{{ route('customers.ban', $customer->id) }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500">Ban
                            profile</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('customers.unban', $customer->id) }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">Unban
                            profile</button>
                    </form>
                @endif
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
            <span class="text-white text-lg font-semibold">
                {{ $customer->next_appointment?->format('d/m/Y H:i') ?? 'Geen afspraak' }}
            </span>
        </div>
        <div class="px-6 py-5 text-center text-sm font-medium flex flex-col gap-1">
            <span class="text-xs text-gray-400 uppercase tracking-wide">Vorige afspraak</span>
            <span class="text-white text-lg font-semibold">
                {{ $customer->previous_appointment?->format('d/m/Y H:i') ?? 'Geen afspraak' }}
            </span>
        </div>
    </div>
</div>