<x-layouts.app>
    @php
        $typeLabel = match($type) {
            'product' => 'Producten',
            'gift-card' => 'Cadeaubonnen',
            'room_confirmation', 'room_reminder', 'room_cancellation' => $room->name,
        };

        $roomTabs = [
            'confirmation' => 'Bevestiging',
            'reminder'     => 'Herinnering',
            'cancellation' => 'Annulering',
        ];

        $roomDescriptions = [
            'confirmation' => 'Wordt automatisch verzonden bij een boeking van deze kamer.',
            'reminder'     => 'Wordt automatisch verzonden vóór de afspraak (zie instellingen voor het aantal dagen op voorhand).',
            'cancellation' => 'Wordt automatisch verzonden wanneer een boeking voor deze kamer geannuleerd wordt.',
        ];
    @endphp

    <x-navigation.breadcrumb :breadcrumbs="$room
        ? [
            ['name' => 'Kamers', 'url' => route('rooms.index')],
            ['name' => $room->name, 'url' => route('rooms.edit', $room->id)],
            ['name' => 'Mail-sjablonen', 'url' => route('mail-templates.room.index', [$room, $subtype])],
        ]
        : [
            ['name' => $type === 'product' ? 'Producten' : 'Cadeaubonnen', 'url' => $type === 'product' ? route('products.index') : route('giftCards.index')],
            ['name' => 'Mail-sjablonen', 'url' => route('mail-templates.index', $type)],
        ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-base font-semibold text-gray-900 dark:text-white">Mail-sjablonen — {{ $typeLabel }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Eén sjabloon per taal, geldig voor {{ $room ? 'deze kamer' : ($type === 'product' ? 'alle producten' : 'alle cadeaubonnen') }}.
                    {{ $room ? $roomDescriptions[$subtype] : 'Wordt automatisch verzonden bij een bestelling.' }}
                </p>
            </div>
            @if($templates->count() < count($locales))
                <a href="{{ $room ? route('mail-templates.room.create', [$room, $subtype]) : route('mail-templates.create', $type) }}"
                    class="mt-4 sm:mt-0 inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Sjabloon toevoegen
                </a>
            @endif
        </div>

        @if($room)
            <div class="mb-6 border-b border-gray-200 dark:border-white/10">
                <nav class="-mb-px flex gap-x-6">
                    @foreach($roomTabs as $tabKey => $tabLabel)
                        <a href="{{ route('mail-templates.room.index', [$room, $tabKey]) }}"
                            class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium {{ $subtype === $tabKey
                                ? 'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400'
                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            {{ $tabLabel }}
                        </a>
                    @endforeach
                </nav>
            </div>
        @endif

        @if($templates->isEmpty())
            <div class="text-center py-16 rounded-xl border border-dashed border-gray-300 dark:border-white/10">
                <svg class="mx-auto size-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Nog geen sjablonen. Maak er één aan om e-mails te versturen bij {{ $room ? 'boekingen' : 'bestellingen' }}.</p>
                <a href="{{ $room ? route('mail-templates.room.create', [$room, $subtype]) : route('mail-templates.create', $type) }}"
                    class="mt-4 inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                    Eerste sjabloon aanmaken
                </a>
            </div>
        @else
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Taal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Onderwerp</th>
                            @if(in_array($type, ['room_confirmation', 'room_reminder']))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Agenda-bijlage</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Bijgewerkt</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Acties</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5 bg-white dark:bg-transparent">
                        @foreach($templates as $template)
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 ring-1 ring-inset ring-indigo-700/10 dark:ring-indigo-500/20">
                                        {{ strtoupper($template->locale) }} — {{ $locales[$template->locale] ?? $template->locale }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $template->subject }}</td>
                                @if(in_array($type, ['room_confirmation', 'room_reminder']))
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $template->attach_ics ? 'Ja' : 'Nee' }}</td>
                                @endif
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $template->updated_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-right text-sm flex items-center justify-end gap-3">
                                    <a href="{{ $room ? route('mail-templates.room.edit', [$room, $subtype, $template]) : route('mail-templates.edit', [$type, $template]) }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Bewerken</a>
                                    <form method="POST" action="{{ $room ? route('mail-templates.room.destroy', [$room, $subtype, $template]) : route('mail-templates.destroy', [$type, $template]) }}"
                                        onsubmit="return confirm('Sjabloon verwijderen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
