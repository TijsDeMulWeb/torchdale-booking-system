<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamer', 'url' => route('rooms.index')],
        ['name' => $room->name, 'url' => route('rooms.edit', $room->id)],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div class="sm:flex sm:items-start sm:justify-between mb-8">
            <div>
                <h1 class="text-base font-semibold text-gray-900 dark:text-white">Tijdsloten — {{ $room->name }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Beheer beschikbare tijdslots per dag.</p>
                @if ($last_updated)
                    <x-last-updated :model="$last_updated" />
                @endif
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 dark:border-white/10 overflow-hidden">
            @foreach (['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'] as $dayIndex => $day)
                @php $daySlots = $slots[$dayIndex] ?? collect(); @endphp
                <div
                    class="grid grid-cols-[140px_1fr] {{ !$loop->last ? 'border-b border-gray-100 dark:border-white/10' : '' }}">

                    <div class="py-5 px-5 text-sm font-medium text-gray-900 dark:text-white flex items-start pt-6">
                        {{ $day }}
                    </div>
                    <div class="py-4 px-5 border-l border-gray-100 dark:border-white/10">
                        <div class="flex flex-wrap gap-3 items-center">
                            @foreach ($daySlots as $slot)
                                <div
                                    class="inline-flex items-center gap-3 bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-lg px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">{{ $slot->start_time->format('H:i') }} –
                                        {{ $slot->end_time->format('H:i') }}</span>
                                    <div
                                        class="flex items-center gap-2 ml-1 pl-3 border-l border-gray-200 dark:border-white/10">
                                        <button type="button"
                                            onclick="openModal({{ $dayIndex }}, '{{ $day }}', {{ $slot->id }}, '{{ $slot->start_time->format('H:i') }}', '{{ $slot->end_time->format('H:i') }}')"
                                            class="p-1 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-1.414a2 2 0 01.586-1.414z" />
                                            </svg>
                                        </button>
                                        <form method="POST"
                                            action="{{ route('rooms.timeslots.destroy', [$room->id, $slot->id]) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <button type="button" onclick="openModal({{ $dayIndex }}, '{{ $day }}')"
                                class="inline-flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500 border border-dashed border-gray-300 dark:border-white/20 rounded-lg px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-600 dark:hover:text-gray-300 hover:border-solid transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Toevoegen
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Modal --}}
        <div id="modal-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
            <div id="modal-box"
                class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-white/10 w-full max-w-md p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 id="modal-title" class="text-base font-semibold text-gray-900 dark:text-white"></h2>
                    <button type="button" onclick="closeModal()"
                        class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form id="modal-form" method="POST">
                    @csrf
                    <input type="hidden" id="modal-method" name="_method" value="POST" />
                    <input type="hidden" id="modal-day" name="day_of_week" />
                    <div class="mb-5">
                        <label class="block text-sm text-gray-500 dark:text-gray-400 mb-2">Dag</label>
                        <input type="text" id="modal-day-label" readonly
                            class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-lg text-gray-500 dark:text-gray-400" />
                    </div>
                    <div class="grid grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-sm text-gray-500 dark:text-gray-400 mb-2">Starttijd</label>
                            <input type="time" name="start_time" id="modal-start"
                                class="w-full px-4 py-2.5 text-sm border border-gray-300 dark:border-white/20 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-500 dark:text-gray-400 mb-2">Eindtijd</label>
                            <input type="time" name="end_time" id="modal-end"
                                class="w-full px-4 py-2.5 text-sm border border-gray-300 dark:border-white/20 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <button type="button" onclick="closeModal()"
                            class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                            Annuleren
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-500">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const storeUrl = '{{ route('rooms.timeslots.store', $room->id) }}';
        const updateUrl = '{{ route('rooms.timeslots.update', [$room->id, '__id__']) }}';

        function openModal(dayIndex, dayLabel, slotId = null, start = '10:00', end = '11:30') {
            document.querySelector('#modal-title').textContent = slotId ? 'Tijdslot wijzigen' : 'Tijdslot toevoegen';
            document.querySelector('#modal-day').value = dayIndex;
            document.querySelector('#modal-day-label').value = dayLabel;
            document.querySelector('#modal-start').value = start;
            document.querySelector('#modal-end').value = end;

            if (slotId) {
                document.querySelector('#modal-form').action = updateUrl.replace('__id__', slotId);
                document.querySelector('#modal-method').value = 'PATCH';
            } else {
                document.querySelector('#modal-form').action = storeUrl;
                document.querySelector('#modal-method').value = 'POST';
            }

            document.querySelector('#modal-overlay').classList.remove('hidden');
        }

        function closeModal() {
            document.querySelector('#modal-overlay').classList.add('hidden');
        }

        document.querySelector('#modal-overlay').addEventListener('click', function (e) {
            if (e.target === this) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>

</x-layouts.app>