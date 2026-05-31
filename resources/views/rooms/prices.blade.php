<x-layouts.app>
    <x-success :message="session('message')" />
    <x-error name="message" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamer', 'url' => route('rooms.index')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="sm:flex sm:items-start sm:justify-between mb-8">
            <div>
                <h1 class="text-base font-semibold text-gray-900 dark:text-white">Prijzen — {{ $room->name }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Stel per dag een basisprijs en prijs per speler
                    in.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('rooms.prices.store', $room->id) }}">
            @csrf
            @php
                $days = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'];
                $playerRange = range($room->min_players, $room->max_players);
            @endphp

            @foreach ($days as $dayIndex => $day)
                @php $pricing = $pricings[$dayIndex] ?? null; @endphp
                <div class="mt-3 rounded-xl border border-gray-200 dark:border-white/10 overflow-hidden">
                    <button type="button"
                        class="w-full flex items-center justify-between px-5 py-4 bg-gray-50 dark:bg-white/5 text-left">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $day }}</span>
                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                €{{ number_format($pricings[$dayIndex]['base_price'] ?? 0, 2) }} basis
                            </span>
                        </div>
                    </button>
                    <div>
                        <div class="p-5 bg-white dark:bg-gray-900">
                            <div class="flex items-center gap-4 pb-5 mb-5 border-b border-gray-100 dark:border-white/10">
                                <label class="text-sm text-gray-500 dark:text-gray-400 shrink-0">Basisprijs</label>
                                <div
                                    class="flex items-center border border-gray-300 dark:border-white/20 rounded-lg overflow-hidden">
                                    <span
                                        class="px-3 py-2 text-sm text-gray-400 bg-gray-50 dark:bg-white/5 border-r border-gray-300 dark:border-white/20">€</span>
                                    <input type="text" name="pricings[{{ $dayIndex }}][base_price]"
                                        value="{{ number_format($pricings[$dayIndex]['base_price'] ?? 0, 2, '.', '') }}"
                                        class="w-24 px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-900 border-none outline-none focus:ring-0" />
                                </div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 shrink-0">BTW</label>
                                <div
                                    class="flex items-center border border-gray-300 dark:border-white/20 rounded-lg overflow-hidden">
                                    <input type="text" name="pricings[{{ $dayIndex }}][vat_percentage]"
                                        value="{{ number_format($pricings[$dayIndex]['vat_percentage'] ?? 21, 2, '.', '') }}"
                                        class="w-16 px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-900 border-none outline-none focus:ring-0" />
                                    <span
                                        class="px-3 py-2 text-sm text-gray-400 bg-gray-50 dark:bg-white/5 border-l border-gray-300 dark:border-white/20">%</span>
                                </div>
                            </div>

                            {{-- Per speler --}}
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wide">
                                Prijs per persoon</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                                @foreach ($playerRange as $players)
                                    @php $playerPricing = $pricings[$dayIndex]['players'][$players] ?? null; @endphp
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="inline-flex items-center gap-1 text-xs text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 rounded px-2 py-0.5 w-fit">
                                            {{ $players }} spelers
                                        </span>
                                        <div
                                            class="flex items-center border border-gray-300 dark:border-white/20 rounded-lg overflow-hidden">
                                            <span
                                                class="px-3 py-2 text-sm text-gray-400 bg-gray-50 dark:bg-white/5 border-r border-gray-300 dark:border-white/20">€</span>
                                            <input type="text"
                                                name="pricings[{{ $dayIndex }}][players][{{ $players }}]"
                                                value="{{ number_format($playerPricing?->price ?? 0, 2, '.', '') }}"
                                                class="w-full px-2 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-900 border-none outline-none focus:ring-0" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>