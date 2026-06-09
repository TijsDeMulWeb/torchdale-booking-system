<x-layouts.app>
    <style>
        .calendar-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgb(209 213 219) transparent;
        }

        .calendar-scrollbar::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        .calendar-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .calendar-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgb(209 213 219);
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .calendar-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: rgb(156 163 175);
        }

        .calendar-scrollbar::-webkit-scrollbar-corner {
            background: transparent;
        }

        @media (prefers-color-scheme: dark) {
            .calendar-scrollbar {
                scrollbar-color: rgb(75 85 99) transparent;
            }

            .calendar-scrollbar::-webkit-scrollbar-thumb {
                background-color: rgb(75 85 99);
            }

            .calendar-scrollbar::-webkit-scrollbar-thumb:hover {
                background-color: rgb(107 114 128);
            }
        }
    </style>

    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Planning</h1>
                <p id="period-label" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $periodLabel }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="inline-flex rounded-lg border border-gray-200 bg-white p-1 shadow-sm dark:border-white/10 dark:bg-white/5">
                    <button type="button" data-view="day" class="view-toggle rounded-md px-3 py-1.5 text-sm font-medium text-gray-600 transition-colors dark:text-gray-300">Dag</button>
                    <button type="button" data-view="week" class="view-toggle rounded-md px-3 py-1.5 text-sm font-medium text-gray-600 transition-colors dark:text-gray-300">Week</button>
                </div>

                <div class="inline-flex items-center gap-1">
                    <button type="button" data-nav="prev"
                        class="inline-flex size-9 items-center justify-center rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50 dark:border-white/10 dark:text-gray-400 dark:hover:bg-white/5">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 0 1 0 1.06L9.06 10l3.73 3.71a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button type="button" data-nav="today"
                        class="inline-flex items-center rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-white/10 dark:text-gray-200 dark:hover:bg-white/5">
                        Vandaag
                    </button>
                    <button type="button" data-nav="next"
                        class="inline-flex size-9 items-center justify-center rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50 dark:border-white/10 dark:text-gray-400 dark:hover:bg-white/5">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 0-1.06L10.94 10 7.21 6.29a.75.75 0 1 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                @if ($rooms->isNotEmpty())
                    <button type="button" id="open-new-booking-modal"
                        class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500 shadow-sm">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        Nieuwe afspraak
                    </button>
                    <button type="button" id="open-range-block-modal"
                        class="inline-flex items-center gap-2 rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-white/10 dark:text-gray-200 dark:hover:bg-white/5">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2ZM3.5 8.5v6.75c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25V8.5h-13Z" clip-rule="evenodd" />
                        </svg>
                        Periode blokkeren
                    </button>
                    <button type="button" id="open-range-unblock-modal"
                        class="inline-flex items-center gap-2 rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-white/10 dark:text-gray-200 dark:hover:bg-white/5">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2ZM3.5 8.5v6.75c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25V8.5h-13Zm2.5 3.25a.75.75 0 0 1 .75-.75h6.5a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>
                        Periode deblokkeren
                    </button>
                @endif
            </div>
        </div>

        {{-- Room selector --}}
        <div id="room-selector" class="mt-6 flex flex-wrap gap-2">
            @forelse ($rooms as $room)
                <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1.5 shadow-sm select-none hover:bg-gray-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10">
                    <input type="checkbox" {{ $loop->index < 4 ? 'checked' : '' }} class="room-toggle size-4 rounded border-gray-300 dark:border-white/20"
                        style="accent-color: {{ $room->color ?? '#6366f1' }}" data-room-id="{{ $room->id }}">
                    <span class="size-2.5 rounded-full" style="background-color: {{ $room->color ?? '#6366f1' }}"></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $room->name }}</span>
                </label>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Er zijn nog geen kamers aangemaakt.</p>
            @endforelse
        </div>
        @if ($rooms->count() > 4)
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Je kan maximaal 4 kamers tegelijk weergeven — vink er eerst één uit om een andere te kunnen tonen.</p>
        @endif

        {{-- Calendar --}}
        @if ($rooms->isNotEmpty())
            <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
                <div id="calendar-scroll" class="calendar-scrollbar max-h-[75vh] overflow-auto scroll-smooth">
                    <div class="flex">
                        {{-- Sticky time gutter --}}
                        <div class="flex w-14 shrink-0 flex-col sm:w-16">
                            <div class="sticky top-0 left-0 z-30 h-12 shrink-0 border-r border-b border-gray-200 bg-white/95 backdrop-blur dark:border-white/10 dark:bg-gray-900/95"></div>
                            <div class="sticky left-0 z-20 overflow-visible border-r border-gray-200 bg-white dark:border-white/10 dark:bg-gray-900" style="height: {{ 24 * 60 }}px">
                                @for ($hour = 0; $hour <= 24; $hour++)
                                    <div class="absolute right-2 -translate-y-1/2 text-xs whitespace-nowrap text-gray-400 dark:text-gray-500"
                                        style="top: {{ $hour * 60 }}px">
                                        {{ sprintf('%02d:00', $hour) }}
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Columns are rendered by JavaScript: rooms side-by-side in day view, days side-by-side in week view --}}
                        <div id="calendar-columns" class="flex flex-1"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Slot action menu, shown when clicking an available slot --}}
    <div id="slot-menu" class="hidden fixed z-40 w-60 rounded-lg border border-gray-200 bg-white p-1.5 text-sm shadow-lg dark:border-white/10 dark:bg-gray-800">
        <p id="slot-menu-label" class="truncate px-3 py-1.5 text-xs font-medium text-gray-400 dark:text-gray-500"></p>
        <button type="button" data-slot-action="book" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-gray-700 transition-colors hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-white/5">
            Nieuwe afspraak aanmaken
        </button>
        <button type="button" data-slot-action="block" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-gray-700 transition-colors hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-white/5">
            Tijdslot blokkeren
        </button>
        <button type="button" data-slot-action="unblock" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-red-600 transition-colors hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
            Tijdslot deblokkeren
        </button>
    </div>

    {{-- Unblock time slot form, submitted directly after a confirmation prompt --}}
    <form id="unblock-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- Block time slot modal --}}
    <div id="block-modal-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="w-full max-w-md rounded-xl border border-gray-200 bg-white p-8 dark:border-white/10 dark:bg-gray-900">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Tijdslot blokkeren</h2>
                <button type="button" data-close-modal="block" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="block-form" method="POST" action="{{ route('dashboard.timeslots.block') }}">
                @csrf
                <input type="hidden" name="room_id" id="block-room-id">
                <input type="hidden" name="date" id="block-date">
                <input type="hidden" name="start" id="block-start">
                <input type="hidden" name="end" id="block-end">
                <p id="block-summary" class="mb-5 text-sm text-gray-500 dark:text-gray-400"></p>
                <div class="mb-6">
                    <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Reden (optioneel)</label>
                    <input type="text" name="reason" maxlength="150" placeholder="Bv. onderhoud, privégebruik..."
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                </div>
                <div class="flex items-center justify-end gap-4">
                    <button type="button" data-close-modal="block" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Annuleren</button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-500">Blokkeren</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Block a period (one room, multiple days/timeslots at once) modal --}}
    <div id="range-block-modal-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="w-full max-w-md rounded-xl border border-gray-200 bg-white p-8 dark:border-white/10 dark:bg-gray-900">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Periode blokkeren</h2>
                <button type="button" data-close-modal="range-block" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="range-block-form" method="POST" action="{{ route('dashboard.timeslots.blockRange') }}">
                @csrf
                <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">Blokkeer in één keer meerdere dagen en/of tijdsloten voor een kamer — bijvoorbeeld voor onderhoud, verbouwing of een sluitingsperiode.</p>

                <div class="mb-5">
                    <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Kamer</label>
                    <select name="room_id" id="range-block-room" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Vanaf</label>
                        <input type="date" name="start_date" id="range-block-start-date" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Tot en met</label>
                        <input type="date" name="end_date" id="range-block-end-date" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                <label class="mb-5 flex cursor-pointer items-center gap-2 select-none">
                    <input type="checkbox" name="all_day" id="range-block-all-day" value="1"
                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-white/20">
                    <span class="text-sm text-gray-700 dark:text-gray-200">Hele dag(en) blokkeren</span>
                </label>

                <div id="range-block-time-fields" class="mb-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Van</label>
                        <input type="time" name="start" id="range-block-start"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Tot</label>
                        <input type="time" name="end" id="range-block-end"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <p class="-mt-3 mb-5 text-xs text-gray-400 dark:text-gray-500">Dit tijdsbereik wordt op elke dag in de gekozen periode toegepast. Overlapt het met een bestaande boeking of blokkade? Dan wordt er gewoon rond geblokkeerd — de bestaande boeking of blokkade blijft altijd staan.</p>

                <div class="mb-6">
                    <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Reden (optioneel)</label>
                    <input type="text" name="reason" maxlength="150" placeholder="Bv. onderhoud, verbouwing, sluitingsperiode..."
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                </div>
                <div class="flex items-center justify-end gap-4">
                    <button type="button" data-close-modal="range-block" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Annuleren</button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-500">Blokkeren</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Unblock a period (one room, all blocked slots in a date range at once) modal --}}
    <div id="range-unblock-modal-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="w-full max-w-md rounded-xl border border-gray-200 bg-white p-8 dark:border-white/10 dark:bg-gray-900">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Periode deblokkeren</h2>
                <button type="button" data-close-modal="range-unblock" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="range-unblock-form" method="POST" action="{{ route('dashboard.timeslots.unblockRange') }}">
                @csrf
                <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">Hef in één keer alle blokkades voor een kamer in een bepaalde periode op — handig om bijvoorbeeld een maandlange sluiting weer ongedaan te maken zonder elke dag apart te deblokkeren. Echte boekingen worden hierdoor nooit verwijderd.</p>

                <div class="mb-5">
                    <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Kamer</label>
                    <select name="room_id" id="range-unblock-room" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Vanaf</label>
                        <input type="date" name="start_date" id="range-unblock-start-date" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Tot en met</label>
                        <input type="date" name="end_date" id="range-unblock-end-date" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4">
                    <button type="button" data-close-modal="range-unblock" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Annuleren</button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-500">Deblokkeren</button>
                </div>
            </form>
        </div>
    </div>

    {{-- New appointment modal --}}
    <div id="booking-modal-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="w-full max-w-lg rounded-xl border border-gray-200 bg-white p-8 dark:border-white/10 dark:bg-gray-900 max-h-[90vh] overflow-y-auto">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Nieuwe afspraak aanmaken</h2>
                <button type="button" data-close-modal="booking" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="booking-form" method="POST" action="{{ route('dashboard.timeslots.book') }}">
                @csrf
                {{-- Timing & room --}}
                <div class="mb-5">
                    <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Kamer</label>
                    <select name="room_id" id="booking-room-id" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-5 grid grid-cols-3 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Datum</label>
                        <input type="date" name="date" id="booking-date" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Van</label>
                        <input type="time" name="start" id="booking-start" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Tot</label>
                        <input type="time" name="end" id="booking-end" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                {{-- Customer --}}
                <div class="mb-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Voornaam</label>
                        <input type="text" name="first_name" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Achternaam</label>
                        <input type="text" name="last_name" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="mb-5">
                    <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">E-mailadres</label>
                    <input type="email" name="email" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                </div>
                <div class="mb-5 grid grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Straat <span class="text-gray-400">(optioneel)</span></label>
                        <input type="text" name="street" placeholder="Kerkstraat" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Nr.</label>
                        <input type="text" name="house_number" placeholder="12" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="mb-5 grid grid-cols-3 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Postcode</label>
                        <input type="text" name="postal_code" placeholder="2000" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div class="col-span-2">
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Gemeente</label>
                        <input type="text" name="city" placeholder="Antwerpen" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="mb-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Telefoon (optioneel)</label>
                        <input type="tel" name="phone" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Aantal spelers</label>
                        <input type="number" name="players" id="booking-players" min="1" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                {{-- Language --}}
                <div class="mb-5">
                    <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Taal</label>
                    <select name="language_id" id="booking-language-id" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </select>
                </div>
                {{-- Pricing --}}
                <div class="mb-2">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm text-gray-500 dark:text-gray-400">Prijs (incl. BTW)</label>
                        <span id="booking-price-hint" class="text-xs text-gray-400 dark:text-gray-500"></span>
                    </div>
                    <input type="number" name="custom_price" id="booking-custom-price" step="0.01" min="0" placeholder="0.00"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                </div>
                <div class="mb-6 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Online te betalen</label>
                        <input type="number" name="amount_online" id="booking-amount-online" step="0.01" min="0" value="0"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-gray-500 dark:text-gray-400">Ter plekke te betalen</label>
                        <input type="number" name="amount_onsite" id="booking-amount-onsite" step="0.01" min="0" value="0"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/20 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4">
                    <button type="button" data-close-modal="booking" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Annuleren</button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-500">Afspraak aanmaken</button>
                </div>
            </form>
        </div>
    </div>

    @php
        $calendarDataJson = \Illuminate\Support\Js::from($calendarData);
    @endphp
    <script>
        (function () {
            const root = document.getElementById('calendar-columns');
            if (!root) {
                return;
            }

            const CALENDAR = {!! $calendarDataJson !!};
            const UNBLOCK_URL_TEMPLATE = {!! \Illuminate\Support\Js::from(route('dashboard.timeslots.unblock', ['timeSlot' => '__id__'])) !!};
            const HOUR_HEIGHT = 60;
            const DAY_HEIGHT = 24 * HOUR_HEIGHT;
            const FIXED_ROOM_COLUMN_WIDTH = 280;
            const WEEK_COLUMN_WIDTH = 200;
            const MAX_VISIBLE_ROOMS = 4;
            const ROOMS_BY_ID = new Map(CALENDAR.rooms.map((room) => [room.id, room]));
            const STORAGE_KEY = 'torchdale:dashboard-calendar';
            const DESKTOP_QUERY = '(min-width: 1024px)';

            let viewMode = 'day';

            /**
             * Preferences (view mode + visible rooms) are remembered in the
             * browser's localStorage, so the calendar reopens the way the user
             * left it last time.
             */
            function loadStoredPreferences() {
                try {
                    const raw = window.localStorage.getItem(STORAGE_KEY);
                    return raw ? JSON.parse(raw) : null;
                } catch (error) {
                    return null;
                }
            }

            function persistPreferences() {
                try {
                    window.localStorage.setItem(STORAGE_KEY, JSON.stringify({
                        view: viewMode,
                        visibleRoomIds: getVisibleRoomIds(),
                    }));
                } catch (error) {
                    // Storage unavailable (e.g. private browsing) — preferences simply won't persist.
                }
            }

            function resolveInitialView(stored) {
                const params = new URLSearchParams(window.location.search);
                if (params.has('view')) {
                    return params.get('view') === 'week' ? 'week' : 'day';
                }

                if (stored && (stored.view === 'day' || stored.view === 'week')) {
                    return stored.view;
                }

                // No explicit choice yet: default to day view on mobile, week view on larger screens.
                return window.matchMedia(DESKTOP_QUERY).matches ? 'week' : 'day';
            }

            function applyInitialRoomSelection(stored) {
                const allRoomIds = CALENDAR.rooms.map((room) => room.id);
                let visibleIds = allRoomIds.slice(0, MAX_VISIBLE_ROOMS);

                if (stored && Array.isArray(stored.visibleRoomIds)) {
                    const remembered = stored.visibleRoomIds.filter((id) => allRoomIds.includes(id));
                    if (remembered.length) {
                        visibleIds = remembered.slice(0, MAX_VISIBLE_ROOMS);
                    }
                }

                document.querySelectorAll('.room-toggle').forEach((checkbox) => {
                    checkbox.checked = visibleIds.includes(Number(checkbox.dataset.roomId));
                });
            }

            /**
             * Time helpers — reused by both the day view (rooms as columns)
             * and the week view (days as columns).
             */
            function timeToMinutes(time) {
                const [hours, minutes] = time.split(':').map(Number);
                return (hours * 60) + minutes;
            }

            function calculateEventTop(startTime) {
                return (timeToMinutes(startTime) / 60) * HOUR_HEIGHT;
            }

            function calculateEventHeight(startTime, endTime) {
                return ((timeToMinutes(endTime) - timeToMinutes(startTime)) / 60) * HOUR_HEIGHT;
            }

            /**
             * Groups events that overlap in time and assigns each one a column
             * index plus a column span, so overlapping events sit side-by-side
             * and never visually cover each other (Apple Calendar style).
             */
            function calculateOverlapLayout(events) {
                const layout = new Map();

                const sorted = [...events].sort((a, b) => {
                    const startDiff = timeToMinutes(a.start) - timeToMinutes(b.start);
                    return startDiff !== 0 ? startDiff : timeToMinutes(b.end) - timeToMinutes(a.end);
                });

                const clusters = [];
                let cluster = [];
                let clusterEnd = -Infinity;

                sorted.forEach((event) => {
                    const start = timeToMinutes(event.start);

                    if (cluster.length && start >= clusterEnd) {
                        clusters.push(cluster);
                        cluster = [];
                        clusterEnd = -Infinity;
                    }

                    cluster.push(event);
                    clusterEnd = Math.max(clusterEnd, timeToMinutes(event.end));
                });

                if (cluster.length) {
                    clusters.push(cluster);
                }

                clusters.forEach((clusterEvents) => {
                    const columnEnds = [];

                    clusterEvents.forEach((event) => {
                        const start = timeToMinutes(event.start);
                        const end = timeToMinutes(event.end);

                        let columnIndex = columnEnds.findIndex((columnEnd) => columnEnd <= start);
                        if (columnIndex === -1) {
                            columnIndex = columnEnds.length;
                        }
                        columnEnds[columnIndex] = end;

                        layout.set(event.id, { columnIndex, columnSpan: 1, totalColumns: 0 });
                    });

                    const totalColumns = columnEnds.length;

                    clusterEvents.forEach((event) => {
                        const placement = layout.get(event.id);
                        placement.totalColumns = totalColumns;

                        const start = timeToMinutes(event.start);
                        const end = timeToMinutes(event.end);

                        let span = 1;
                        for (let column = placement.columnIndex + 1; column < totalColumns; column++) {
                            const blocked = clusterEvents.some((other) => {
                                if (other.id === event.id) {
                                    return false;
                                }
                                const otherPlacement = layout.get(other.id);
                                if (otherPlacement.columnIndex !== column) {
                                    return false;
                                }
                                return timeToMinutes(other.start) < end && timeToMinutes(other.end) > start;
                            });

                            if (blocked) {
                                break;
                            }
                            span++;
                        }
                        placement.columnSpan = span;
                    });
                });

                return layout;
            }

            function withAlpha(hexColor, alpha) {
                return /^#[0-9a-f]{6}$/i.test(hexColor) ? `${hexColor}${alpha}` : hexColor;
            }

            function buildGridLines() {
                const fragment = document.createDocumentFragment();

                for (let hour = 0; hour < 24; hour++) {
                    const hourLine = document.createElement('div');
                    hourLine.className = 'pointer-events-none absolute inset-x-0 border-t border-gray-100 dark:border-white/5';
                    hourLine.style.top = `${hour * HOUR_HEIGHT}px`;
                    fragment.appendChild(hourLine);

                    const halfLine = document.createElement('div');
                    halfLine.className = 'pointer-events-none absolute inset-x-0 border-t border-dashed border-gray-50 dark:border-white/[0.04]';
                    halfLine.style.top = `${hour * HOUR_HEIGHT + 30}px`;
                    fragment.appendChild(halfLine);
                }

                return fragment;
            }

            function buildCurrentTimeLine() {
                const now = new Date();

                const line = document.createElement('div');
                line.className = 'current-time pointer-events-none absolute inset-x-0 z-20 border-t border-red-500';
                line.style.top = `${((now.getHours() * 60 + now.getMinutes()) / 60) * HOUR_HEIGHT}px`;

                const dot = document.createElement('span');
                dot.className = 'absolute -top-1 -left-1 size-2 rounded-full bg-red-500';
                line.appendChild(dot);

                return line;
            }

            function buildEventCard(event, color, subtitle) {
                const isAvailable = event.booked === false;
                const isBlocked = event.blocked === true;

                const isInteractive = isAvailable || isBlocked;

                const node = document.createElement('div');
                node.className = `calendar-event absolute overflow-hidden rounded-lg border px-2 py-1 text-xs transition-shadow hover:z-30 hover:shadow-md ${isInteractive ? 'cursor-pointer' : ''} ${isAvailable ? 'border-dashed' : 'border-solid shadow-sm'}`;
                node.style.top = `${calculateEventTop(event.start)}px`;
                node.style.height = `${Math.max(calculateEventHeight(event.start, event.end), 18)}px`;

                if (isAvailable) {
                    node.style.backgroundColor = withAlpha(color, '0d');
                    node.style.borderColor = withAlpha(color, '40');
                    node.style.color = withAlpha(color, 'b3');
                } else if (isBlocked) {
                    node.style.backgroundImage = 'repeating-linear-gradient(135deg, rgba(107, 114, 128, 0.16) 0 6px, rgba(107, 114, 128, 0.05) 6px 12px)';
                    node.style.backgroundColor = 'rgba(107, 114, 128, 0.08)';
                    node.style.borderColor = 'rgba(107, 114, 128, 0.4)';
                    node.style.color = 'rgb(107, 114, 128)';
                } else {
                    node.style.backgroundColor = withAlpha(color, '1a');
                    node.style.borderColor = withAlpha(color, '66');
                    node.style.color = color;
                }

                node.title = `${event.title} · ${event.start} - ${event.end}`;

                node.innerHTML = `
                    <p class="truncate font-semibold leading-tight ${isAvailable ? 'opacity-75' : ''}">${event.title}</p>
                    <p class="truncate leading-tight opacity-75">${subtitle}</p>
                `;

                if (isInteractive) {
                    node.addEventListener('click', (clickEvent) => {
                        clickEvent.stopPropagation();
                        openSlotMenu(clickEvent, event);
                    });
                }

                return node;
            }

            function placeEvents(container, events, colorOf, subtitleOf) {
                const layout = calculateOverlapLayout(events);

                events.forEach((event) => {
                    const placement = layout.get(event.id);
                    const widthPercent = (100 / placement.totalColumns) * placement.columnSpan;
                    const leftPercent = (100 / placement.totalColumns) * placement.columnIndex;

                    const node = buildEventCard(event, colorOf(event), subtitleOf(event));
                    node.style.left = `calc(${leftPercent}% + 2px)`;
                    node.style.width = `calc(${widthPercent}% - 4px)`;

                    container.appendChild(node);
                });
            }

            function buildColumn(headerNode) {
                const column = document.createElement('div');
                column.className = 'calendar-column relative flex shrink-0 flex-col border-r border-gray-100 last:border-r-0 dark:border-white/5';

                const header = document.createElement('div');
                header.className = 'sticky top-0 z-10 flex h-12 shrink-0 items-center gap-2 border-b border-gray-200 bg-white/95 px-3 backdrop-blur dark:border-white/10 dark:bg-gray-900/95';
                header.appendChild(headerNode);

                const body = document.createElement('div');
                body.className = 'relative';
                body.style.height = `${DAY_HEIGHT}px`;
                body.appendChild(buildGridLines());

                column.appendChild(header);
                column.appendChild(body);

                return { column, body };
            }

            function getVisibleRoomIds() {
                return Array.from(document.querySelectorAll('.room-toggle:checked'))
                    .map((checkbox) => Number(checkbox.dataset.roomId));
            }

            function applyFlexBasis(useFixedWidth, fixedWidth, count) {
                const flexBasis = count > 0 ? 100 / count : 100;

                Array.from(root.children).forEach((column) => {
                    column.style.flex = useFixedWidth
                        ? `0 0 ${fixedWidth}px`
                        : `1 1 ${flexBasis}%`;
                });
            }

            /**
             * Day view: rooms side-by-side. 1-3 visible rooms split the width
             * evenly, 4+ rooms get a fixed width with horizontal scrolling.
             */
            function renderDayView(visibleRooms) {
                visibleRooms.forEach((room) => {
                    const headerNode = document.createElement('div');
                    headerNode.className = 'flex min-w-0 items-center gap-2';
                    headerNode.innerHTML = `
                        <span class="size-2 shrink-0 rounded-full" style="background-color: ${room.color}"></span>
                        <span class="truncate text-sm font-semibold text-gray-900 dark:text-white">${room.name}</span>
                    `;

                    const { column, body } = buildColumn(headerNode);
                    body.dataset.roomId = room.id;
                    body.dataset.date   = CALENDAR.date;
                    body.style.cursor   = 'crosshair';
                    body.addEventListener('click', handleCalendarBodyClick);

                    const events = CALENDAR.events.filter((event) => event.roomId === room.id && event.date === CALENDAR.date);
                    placeEvents(body, events, () => room.color, (event) => `${event.start} - ${event.end}`);

                    if (CALENDAR.date === CALENDAR.today) {
                        body.appendChild(buildCurrentTimeLine());
                    }

                    root.appendChild(column);
                });

                applyFlexBasis(visibleRooms.length >= 4, FIXED_ROOM_COLUMN_WIDTH, visibleRooms.length);
            }

            /**
             * Week view: the seven days of the week side-by-side. Every column
             * shows the events of all visible rooms for that day, colour-coded
             * per room so they stay distinguishable.
             */
            function renderWeekView(visibleRooms) {
                const visibleRoomIds = visibleRooms.map((room) => room.id);
                const colorByRoomId = new Map(visibleRooms.map((room) => [room.id, room.color]));
                const nameByRoomId = new Map(visibleRooms.map((room) => [room.id, room.name]));

                CALENDAR.weekDays.forEach((day) => {
                    const headerNode = document.createElement('div');
                    headerNode.className = 'flex min-w-0 items-center gap-2';
                    headerNode.innerHTML = `
                        <span class="truncate text-sm font-semibold ${day.isToday ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-900 dark:text-white'}">${day.label}</span>
                    `;

                    const { column, body } = buildColumn(headerNode);
                    column.style.flex = `0 0 ${WEEK_COLUMN_WIDTH}px`;
                    body.dataset.date   = day.date;
                    body.dataset.roomId = ''; // room chosen in modal for week view
                    body.style.cursor   = 'crosshair';
                    body.addEventListener('click', handleCalendarBodyClick);

                    const events = CALENDAR.events.filter((event) => visibleRoomIds.includes(event.roomId) && event.date === day.date);
                    placeEvents(
                        body,
                        events,
                        (event) => colorByRoomId.get(event.roomId),
                        (event) => `${nameByRoomId.get(event.roomId)} · ${event.start} - ${event.end}`
                    );

                    if (day.date === CALENDAR.today) {
                        body.appendChild(buildCurrentTimeLine());
                    }

                    root.appendChild(column);
                });
            }

            function updatePeriodLabel() {
                const label = document.getElementById('period-label');
                if (label) {
                    label.textContent = viewMode === 'week' ? CALENDAR.weekLabel : CALENDAR.dayLabel;
                }
            }

            function updateViewToggleButtons() {
                document.querySelectorAll('.view-toggle').forEach((button) => {
                    const isActive = button.dataset.view === viewMode;
                    button.classList.toggle('bg-indigo-600', isActive);
                    button.classList.toggle('text-white', isActive);
                    button.classList.toggle('shadow-sm', isActive);
                    button.classList.toggle('text-gray-600', !isActive);
                    button.classList.toggle('dark:text-gray-300', !isActive);
                });
            }

            /**
             * Showing more than ~4 resources side-by-side stops being readable,
             * so once the limit is reached the remaining checkboxes are disabled
             * until the user frees up a slot.
             */
            function updateRoomToggleAvailability() {
                const limitReached = getVisibleRoomIds().length >= MAX_VISIBLE_ROOMS;

                document.querySelectorAll('.room-toggle').forEach((checkbox) => {
                    const shouldDisable = limitReached && !checkbox.checked;
                    checkbox.disabled = shouldDisable;

                    const label = checkbox.closest('label');
                    if (label) {
                        label.classList.toggle('opacity-40', shouldDisable);
                        label.classList.toggle('cursor-not-allowed', shouldDisable);
                        label.classList.toggle('cursor-pointer', !shouldDisable);
                    }
                });
            }

            function render() {
                root.innerHTML = '';

                const visibleRoomIds = getVisibleRoomIds();
                const visibleRooms = CALENDAR.rooms.filter((room) => visibleRoomIds.includes(room.id));

                if (viewMode === 'week') {
                    renderWeekView(visibleRooms);
                } else {
                    renderDayView(visibleRooms);
                }

                updatePeriodLabel();
                updateViewToggleButtons();
                updateRoomToggleAvailability();
                persistPreferences();
            }

            function setView(mode) {
                if (viewMode === mode) {
                    return;
                }
                viewMode = mode;
                render();
            }

            function navigate(dateString) {
                const url = new URL(CALENDAR.baseUrl, window.location.origin);
                url.searchParams.set('date', dateString);
                url.searchParams.set('view', viewMode);
                window.location.href = url.toString();
            }

            function shiftDate(direction) {
                const [year, month, day] = CALENDAR.date.split('-').map(Number);
                const current = new Date(year, month - 1, day);
                current.setDate(current.getDate() + (direction * (viewMode === 'week' ? 7 : 1)));

                const target = `${current.getFullYear()}-${String(current.getMonth() + 1).padStart(2, '0')}-${String(current.getDate()).padStart(2, '0')}`;
                navigate(target);
            }

            function scrollToRelevantTime() {
                const scrollContainer = document.getElementById('calendar-scroll');
                if (!scrollContainer) {
                    return;
                }

                const now = new Date();
                const showsToday = viewMode === 'week'
                    ? CALENDAR.weekDays.some((day) => day.date === CALENDAR.today)
                    : CALENDAR.date === CALENDAR.today;

                const referenceMinutes = showsToday ? (now.getHours() * 60 + now.getMinutes()) : (8 * 60);
                scrollContainer.scrollTop = Math.max((referenceMinutes / 60) * HOUR_HEIGHT - HOUR_HEIGHT * 2, 0);
            }

            let activeSlot = null;

            /**
             * Builds a human-readable label for a slot, e.g.
             * "Lockdown · maandag 8 juni · 09:00 - 10:00".
             */
            function formatSlotLabel(slot) {
                const room = ROOMS_BY_ID.get(slot.roomId);
                const date = new Date(`${slot.date}T00:00:00`);
                const dateLabel = new Intl.DateTimeFormat('nl-BE', { weekday: 'long', day: 'numeric', month: 'long' }).format(date);

                return `${room ? room.name + ' · ' : ''}${dateLabel} · ${slot.start} - ${slot.end}`;
            }

            function openSlotMenu(originEvent, slot) {
                activeSlot = slot;

                const menu = document.getElementById('slot-menu');
                document.getElementById('slot-menu-label').textContent = formatSlotLabel(slot);

                const isBlockedSlot = slot.blocked === true;
                menu.querySelector('[data-slot-action="book"]').classList.toggle('hidden', isBlockedSlot);
                menu.querySelector('[data-slot-action="block"]').classList.toggle('hidden', isBlockedSlot);
                menu.querySelector('[data-slot-action="unblock"]').classList.toggle('hidden', !isBlockedSlot);

                menu.classList.remove('hidden');

                const menuRect = menu.getBoundingClientRect();
                const left = Math.min(Math.max(originEvent.clientX, 16), window.innerWidth - menuRect.width - 16);
                const top = Math.min(Math.max(originEvent.clientY, 16), window.innerHeight - menuRect.height - 16);

                menu.style.left = `${left}px`;
                menu.style.top = `${top}px`;
            }

            function closeSlotMenu() {
                activeSlot = null;
                document.getElementById('slot-menu').classList.add('hidden');
            }

            function openActionModal(name) {
                document.getElementById(`${name}-modal-overlay`).classList.remove('hidden');
            }

            function closeActionModal(name) {
                document.getElementById(`${name}-modal-overlay`).classList.add('hidden');
            }

            function fillSlotFields(prefix, slot) {
                document.getElementById(`${prefix}-room-id`).value = slot.roomId;
                document.getElementById(`${prefix}-date`).value = slot.date;
                document.getElementById(`${prefix}-start`).value = slot.start;
                document.getElementById(`${prefix}-end`).value = slot.end;
            }

            function openBlockModal(slot) {
                const form = document.getElementById('block-form');
                form.reset();
                fillSlotFields('block', slot);
                document.getElementById('block-summary').textContent = formatSlotLabel(slot);
                openActionModal('block');
            }

            /**
             * Shows or hides the "from / to" time fields in the period-block
             * modal depending on whether "Hele dag(en) blokkeren" is checked —
             * blocking whole days doesn't need a time range.
             */
            function toggleRangeBlockTimeFields() {
                const allDay = document.getElementById('range-block-all-day').checked;
                const fields = document.getElementById('range-block-time-fields');
                const startInput = document.getElementById('range-block-start');
                const endInput = document.getElementById('range-block-end');

                fields.classList.toggle('hidden', allDay);
                startInput.required = !allDay;
                endInput.required = !allDay;
            }

            function openRangeBlockModal() {
                const form = document.getElementById('range-block-form');
                form.reset();

                const today = CALENDAR.today;
                document.getElementById('range-block-start-date').value = today;
                document.getElementById('range-block-start-date').min = today;
                document.getElementById('range-block-end-date').value = today;
                document.getElementById('range-block-end-date').min = today;

                toggleRangeBlockTimeFields();
                openActionModal('range-block');
            }

            function openRangeUnblockModal() {
                const form = document.getElementById('range-unblock-form');
                form.reset();

                const today = CALENDAR.today;
                document.getElementById('range-unblock-start-date').value = today;
                document.getElementById('range-unblock-end-date').value = today;

                openActionModal('range-unblock');
            }

            /**
             * Asks for confirmation (mentioning the room and period, since this
             * is a bulk, irreversible action) before submitting the period
             * unblock form — only blocked slots are removed, real bookings are
             * never affected.
             */
            function confirmRangeUnblock(event) {
                const roomSelect = document.getElementById('range-unblock-room');
                const room = ROOMS_BY_ID.get(Number(roomSelect.value));
                const roomLabel = room ? room.name : 'deze kamer';
                const startDate = document.getElementById('range-unblock-start-date').value;
                const endDate = document.getElementById('range-unblock-end-date').value;

                const confirmed = window.confirm(
                    `Weet je zeker dat je alle blokkades voor "${roomLabel}" tussen ${startDate} en ${endDate} wilt opheffen?\n\nEchte boekingen blijven gewoon staan — alleen geblokkeerde tijdsloten worden verwijderd.`
                );

                if (!confirmed) {
                    event.preventDefault();
                }
            }

            function openBookingModal(slot) {
                const form = document.getElementById('booking-form');
                form.reset();

                // Fill visible fields
                document.getElementById('booking-date').value  = slot.date  || CALENDAR.date;
                document.getElementById('booking-start').value = slot.start || '';
                document.getElementById('booking-end').value   = slot.end   || '';

                // Pre-select room
                const roomSelect = document.getElementById('booking-room-id');
                if (slot.roomId) {
                    roomSelect.value = slot.roomId;
                } else if (roomSelect.options.length > 0) {
                    const visibleIds = getVisibleRoomIds();
                    const first = visibleIds.length ? visibleIds[0] : Number(roomSelect.options[0].value);
                    roomSelect.value = first;
                }

                const roomId = Number(roomSelect.value);
                updateBookingPlayersConstraints(roomId);
                updateBookingLanguages(roomId);

                // Reset pricing fields
                document.getElementById('booking-custom-price').value   = '';
                document.getElementById('booking-amount-online').value  = '0.00';
                document.getElementById('booking-amount-onsite').value  = '0.00';
                document.getElementById('booking-price-hint').textContent = '';

                // Trigger price lookup if we have enough context
                schedulePriceLookup();

                openActionModal('booking');
            }

            function updateBookingPlayersConstraints(roomId) {
                const room = ROOMS_BY_ID.get(roomId);
                const playersInput = document.getElementById('booking-players');
                if (room && room.minPlayers) {
                    playersInput.min = room.minPlayers;
                    if (!playersInput.value || Number(playersInput.value) < room.minPlayers) {
                        playersInput.value = room.minPlayers;
                    }
                } else {
                    playersInput.min = 1;
                }
                if (room && room.maxPlayers) {
                    playersInput.max = room.maxPlayers;
                } else {
                    playersInput.removeAttribute('max');
                }
            }

            // ── Booking modal: price lookup + language + payment split ────────
            const ROOM_PRICE_URL = '{{ route('dashboard.roomPrice') }}';
            const ALL_LANGUAGES  = @json(\App\Models\Language::orderBy('name')->get(['id','name']));
            // Map room_id → language ids (loaded via CALENDAR.rooms which has no languages yet)
            // We'll fetch languages per room lazily and cache
            const roomLanguagesCache = new Map();

            async function fetchRoomLanguages(roomId) {
                if (roomLanguagesCache.has(roomId)) return roomLanguagesCache.get(roomId);
                // Languages for a room are embedded via a data attr on the select options
                // (server-rendered). We build a map from the CALENDAR data which includes
                // language ids if we add them. For now derive from the hidden map below.
                return roomLanguagesCache.get(roomId) ?? [];
            }

            // Embed room→language map from Blade
            const ROOM_LANGUAGE_MAP = @json(
                auth()->user()->escaperoom->rooms()->with('languages:id')->get()
                    ->mapWithKeys(fn($r) => [$r->id => $r->languages->pluck('id')->all()])
            );

            function updateBookingLanguages(roomId) {
                const select = document.getElementById('booking-language-id');
                const allowed = ROOM_LANGUAGE_MAP[roomId] ?? [];
                select.innerHTML = '';
                const list = allowed.length
                    ? ALL_LANGUAGES.filter(lang => allowed.includes(lang.id))
                    : ALL_LANGUAGES;
                list.forEach(lang => {
                    const opt = document.createElement('option');
                    opt.value = lang.id;
                    opt.textContent = lang.name;
                    select.appendChild(opt);
                });
            }

            let priceTimer = null;
            function schedulePriceLookup() {
                clearTimeout(priceTimer);
                priceTimer = setTimeout(doLookupPrice, 300);
            }

            async function doLookupPrice() {
                const roomId  = document.getElementById('booking-room-id').value;
                const date    = document.getElementById('booking-date').value;
                const players = document.getElementById('booking-players').value;
                const hint    = document.getElementById('booking-price-hint');
                const priceEl = document.getElementById('booking-custom-price');

                if (!roomId || !date || !players) return;

                hint.textContent = 'Prijs opzoeken…';
                try {
                    const res = await fetch(`${ROOM_PRICE_URL}?room_id=${roomId}&date=${date}&players=${players}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    });
                    const data = await res.json();
                    if (data.found) {
                        priceEl.value = parseFloat(data.price).toFixed(2);
                        hint.textContent = `Gevonden (${data.vat_percentage}% BTW)`;
                        applyPaymentLocation(data.payment_location, parseFloat(data.price));
                    } else {
                        hint.textContent = 'Geen prijs gevonden — vul manueel in';
                    }
                } catch {
                    hint.textContent = '';
                }
            }

            function applyPaymentLocation(location, total) {
                const onlineEl = document.getElementById('booking-amount-online');
                const onsiteEl = document.getElementById('booking-amount-onsite');
                if (location === 'online') {
                    onlineEl.value = total.toFixed(2);
                    onsiteEl.value = '0.00';
                } else if (location === 'onsite') {
                    onlineEl.value = '0.00';
                    onsiteEl.value = total.toFixed(2);
                } else {
                    onlineEl.value = total.toFixed(2);
                    onsiteEl.value = '0.00';
                }
            }

            function initBookingPriceListeners() {
                ['booking-room-id', 'booking-date', 'booking-players'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('change', () => {
                        if (id === 'booking-room-id') updateBookingLanguages(Number(el.value));
                        schedulePriceLookup();
                    });
                });
                // Sync: when price changes, put remainder in onsite
                document.getElementById('booking-custom-price')?.addEventListener('input', () => {
                    const total  = parseFloat(document.getElementById('booking-custom-price').value) || 0;
                    const online = parseFloat(document.getElementById('booking-amount-online').value) || 0;
                    document.getElementById('booking-amount-onsite').value = Math.max(0, total - online).toFixed(2);
                });
                document.getElementById('booking-amount-online')?.addEventListener('input', () => {
                    const total  = parseFloat(document.getElementById('booking-custom-price').value) || 0;
                    const online = parseFloat(document.getElementById('booking-amount-online').value) || 0;
                    document.getElementById('booking-amount-onsite').value = Math.max(0, total - online).toFixed(2);
                });
                document.getElementById('booking-amount-onsite')?.addEventListener('input', () => {
                    const total  = parseFloat(document.getElementById('booking-custom-price').value) || 0;
                    const onsite = parseFloat(document.getElementById('booking-amount-onsite').value) || 0;
                    document.getElementById('booking-amount-online').value = Math.max(0, total - onsite).toFixed(2);
                });
            }
            // ── End booking pricing ──────────────────────────────────────────

            function handleCalendarBodyClick(event) {
                // Ignore clicks that land on an existing event card
                if (event.target.closest('.calendar-event')) return;

                const body = event.currentTarget;
                const rect = body.getBoundingClientRect();
                const yFromTop = event.clientY - rect.top;

                // Snap to 15-minute grid
                const totalMinutes = Math.floor((yFromTop / HOUR_HEIGHT) * 60 / 15) * 15;
                const clamped = Math.max(0, Math.min(totalMinutes, 23 * 60 + 45));

                const startH = Math.floor(clamped / 60);
                const startM = clamped % 60;
                const endMin  = Math.min(clamped + 60, 24 * 60 - 1);
                const endH   = Math.floor(endMin / 60);
                const endM   = endMin % 60;

                const pad = (n) => String(n).padStart(2, '0');

                openBookingModal({
                    roomId: Number(body.dataset.roomId) || null,
                    date:   body.dataset.date || CALENDAR.date,
                    start:  `${pad(startH)}:${pad(startM)}`,
                    end:    `${pad(endH)}:${pad(endM)}`,
                });
            }

            function submitUnblock(timeSlotId) {
                if (!timeSlotId) {
                    return;
                }

                if (!window.confirm('Weet je zeker dat je dit tijdslot wilt deblokkeren?')) {
                    return;
                }

                const form = document.getElementById('unblock-form');
                form.action = UNBLOCK_URL_TEMPLATE.replace('__id__', timeSlotId);
                form.submit();
            }

            function initSlotActions() {
                document.querySelectorAll('#slot-menu [data-slot-action]').forEach((button) => {
                    button.addEventListener('click', () => {
                        if (!activeSlot) {
                            return;
                        }

                        const slot = activeSlot;
                        closeSlotMenu();

                        if (button.dataset.slotAction === 'block') {
                            openBlockModal(slot);
                        } else if (button.dataset.slotAction === 'unblock') {
                            submitUnblock(slot.timeSlotId);
                        } else {
                            openBookingModal(slot);
                        }
                    });
                });

                document.querySelectorAll('[data-close-modal]').forEach((button) => {
                    button.addEventListener('click', () => closeActionModal(button.dataset.closeModal));
                });

                ['block', 'booking', 'range-block', 'range-unblock'].forEach((name) => {
                    const overlay = document.getElementById(`${name}-modal-overlay`);
                    overlay.addEventListener('click', (event) => {
                        if (event.target === overlay) {
                            closeActionModal(name);
                        }
                    });
                });

                const openNewBookingButton = document.getElementById('open-new-booking-modal');
                if (openNewBookingButton) {
                    openNewBookingButton.addEventListener('click', () => {
                        openBookingModal({ roomId: null, date: CALENDAR.date, start: '10:00', end: '11:00' });
                    });
                }

                const openRangeBlockButton = document.getElementById('open-range-block-modal');
                if (openRangeBlockButton) {
                    openRangeBlockButton.addEventListener('click', () => {
                        closeSlotMenu();
                        openRangeBlockModal();
                    });
                }

                const openRangeUnblockButton = document.getElementById('open-range-unblock-modal');
                if (openRangeUnblockButton) {
                    openRangeUnblockButton.addEventListener('click', () => {
                        closeSlotMenu();
                        openRangeUnblockModal();
                    });
                }

                const rangeBlockAllDay = document.getElementById('range-block-all-day');
                if (rangeBlockAllDay) {
                    rangeBlockAllDay.addEventListener('change', toggleRangeBlockTimeFields);
                }

                const rangeBlockStartDate = document.getElementById('range-block-start-date');
                const rangeBlockEndDate = document.getElementById('range-block-end-date');
                if (rangeBlockStartDate && rangeBlockEndDate) {
                    rangeBlockStartDate.addEventListener('change', () => {
                        rangeBlockEndDate.min = rangeBlockStartDate.value;
                        if (rangeBlockEndDate.value && rangeBlockEndDate.value < rangeBlockStartDate.value) {
                            rangeBlockEndDate.value = rangeBlockStartDate.value;
                        }
                    });
                }

                const rangeUnblockStartDate = document.getElementById('range-unblock-start-date');
                const rangeUnblockEndDate = document.getElementById('range-unblock-end-date');
                if (rangeUnblockStartDate && rangeUnblockEndDate) {
                    rangeUnblockStartDate.addEventListener('change', () => {
                        rangeUnblockEndDate.min = rangeUnblockStartDate.value;
                        if (rangeUnblockEndDate.value && rangeUnblockEndDate.value < rangeUnblockStartDate.value) {
                            rangeUnblockEndDate.value = rangeUnblockStartDate.value;
                        }
                    });
                }

                const rangeUnblockForm = document.getElementById('range-unblock-form');
                if (rangeUnblockForm) {
                    rangeUnblockForm.addEventListener('submit', confirmRangeUnblock);
                }

                document.addEventListener('click', (event) => {
                    const menu = document.getElementById('slot-menu');
                    if (!menu.classList.contains('hidden') && !menu.contains(event.target)) {
                        closeSlotMenu();
                    }
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        closeSlotMenu();
                        closeActionModal('block');
                        closeActionModal('booking');
                        closeActionModal('range-block');
                        closeActionModal('range-unblock');
                    }
                });

                const scrollContainer = document.getElementById('calendar-scroll');
                if (scrollContainer) {
                    scrollContainer.addEventListener('scroll', closeSlotMenu, { passive: true });
                }
            }

            function init() {
                const stored = loadStoredPreferences();
                viewMode = resolveInitialView(stored);
                applyInitialRoomSelection(stored);

                render();
                scrollToRelevantTime();
                initSlotActions();
                initBookingPriceListeners();

                document.querySelectorAll('.room-toggle').forEach((checkbox) => {
                    checkbox.addEventListener('change', render);
                });

                document.querySelectorAll('.view-toggle').forEach((button) => {
                    button.addEventListener('click', () => setView(button.dataset.view));
                });

                document.querySelectorAll('[data-nav]').forEach((button) => {
                    button.addEventListener('click', () => {
                        if (button.dataset.nav === 'today') {
                            navigate(CALENDAR.today);
                        } else {
                            shiftDate(button.dataset.nav === 'next' ? 1 : -1);
                        }
                    });
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>
</x-layouts.app>
