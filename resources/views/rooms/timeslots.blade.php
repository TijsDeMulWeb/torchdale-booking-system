<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamers', 'url' => route('rooms.index')],
        ['name' => $room->name, 'url' => route('rooms.edit', $room->id)],
        ['name' => 'Bewerken', 'url' => route('rooms.edit', $room->id)],
        ['name' => 'Tijdsloten', 'url' => route('rooms.timeslots.show', $room->id)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div class="sm:flex sm:items-start sm:justify-between mb-8">
            <div>
                <h1 class="text-base font-semibold text-gray-900 dark:text-white">Tijdsloten — {{ $room->name }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Beheer beschikbare tijdslots per dag.</p>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-white/10 overflow-hidden">
            @foreach (['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'] as $dayIndex => $day)
                @php $daySlots = $slots[$dayIndex] ?? collect(); @endphp
                <div
                    class="grid grid-cols-[100px_1fr] {{ !$loop->last ? 'border-b border-gray-100 dark:border-white/10' : '' }}">
                    <div class="py-4 px-4 text-sm font-medium text-gray-900 dark:text-white flex items-start pt-5">
                        {{ $day }}
                    </div>
                    <div class="py-3 px-4 border-l border-gray-100 dark:border-white/10">
                        <div class="flex flex-wrap gap-2 items-center">
                            @foreach ($daySlots as $slot)
                                <div
                                    class="inline-flex items-center gap-2 bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-lg px-3 py-1.5 text-xs text-gray-700 dark:text-gray-300">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ ($slot->start_time)->format('H:i') }} –
                                    {{ ($slot->end_time)->format('H:i') }}
                                    <div class="flex items-center gap-1 ml-1">
                                        <a href="{{ route('rooms.edit', [$room->id, $slot->id]) }}"
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-1.414a2 2 0 01.586-1.414z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('rooms.destroy', [$room->id, $slot->id]) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-500 dark:hover:text-red-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <a href="{{ route('rooms.create', [$room->id, 'day' => $dayIndex]) }}"
                                class="inline-flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500 border border-dashed border-gray-300 dark:border-white/20 rounded-lg px-3 py-1.5 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-600 dark:hover:text-gray-300 hover:border-solid transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Toevoegen
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>