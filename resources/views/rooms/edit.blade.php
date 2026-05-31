<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamers', 'url' => route('rooms.index')],
        ['name' => $room->name, 'url' => route('rooms.edit', $room->id)],
        ['name' => 'Bewerken', 'url' => route('rooms.edit', $room->id)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Kamer</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over de kamer.</p>
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Kamer
                                Naam</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="Kamer Naam"
                                    value="{{ old('name', $room->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="discountType"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Adres</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="discountType" name="escaperoom_address_id"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        @foreach ($escaperoomAddresses as $escaperoomAddress)
                                            <option value="{{ $escaperoomAddress->id }}" {{ old('escaperoom_address_id', $room->escaperoom_address_id) == $escaperoomAddress->id ? 'selected' : '' }}>
                                                {{ $escaperoomAddress->street }} {{ $escaperoomAddress->house_number }},
                                                {{ $escaperoomAddress->postal_code }} {{ $escaperoomAddress->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4 dark:text-gray-400">
                                        <path
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="duration"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Duur (in
                                minuten)</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="duration" type="text" name="duration" placeholder="75"
                                    value="{{ old('duration', $room->duration) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="duration" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="minPlayers"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Minimale
                                aantal spelers</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="minPlayers" type="text" name="min_players" placeholder="2"
                                    value="{{ old('min_players', $room->min_players) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="min_players" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="maxPlayers"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Maximale
                                aantal spelers</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="maxPlayers" type="text" name="max_players" placeholder="6"
                                    value="{{ old('max_players', $room->max_players) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="max_players" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="minAge"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Minimale
                                leeftijd</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="minAge" type="text" name="min_age" placeholder="12"
                                    value="{{ old('min_age', $room->min_age) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="min_age" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">
                                Kamer Logo
                            </label>
                            <div class="mt-2 flex items-center gap-x-3">
                                <img id="logo-preview" src="{{ $room->url ? Storage::url($room->url) : 'https://placehold.co/400x400' }}" alt="Logo preview"
                                    class="max-h-24 w-auto rounded-lg object-contain border border-gray-200 dark:border-white/10">

                                <input id="logo" name="url" type="file" class="hidden" onchange="previewLogo(event)">

                                <button type="button" onclick="document.getElementById('logo').click()"
                                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">
                                    Aanpassen
                                </button>
                                <x-form.error name="url" />
                            </div>
                        </div>
                        <script>
                            function previewLogo(event) {
                                const file = event.target.files[0];
                                if (!file) return;

                                const img = document.getElementById('logo-preview');
                                img.src = URL.createObjectURL(file);
                            }
                        </script>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="activeFrom"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschikbaar
                                vanaf</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="activeFrom" type="date" name="active_from"
                                    value="{{ old('active_from', $room->active_from ? $room->active_from->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="active_from" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="activeUntil"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschikbaar
                                tot</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="activeUntil" type="date" name="active_until"
                                    value="{{ old('active_until', $room->active_until ? $room->active_until->format('Y-m-d') : null) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="active_until" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="maxBookingAdvance"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Maximmale
                                bookings tijd in toekomst ofzo (in dagen)</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="maxBookingAdvance" type="text" name="max_booking_advance" placeholder="30"
                                    value="{{ old('max_booking_advance', $room->max_booking_advance) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="max_booking_advance" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="color"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">
                                Kleur
                            </label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex items-center gap-3">
                                    <input id="color" type="color" name="color" value="{{ old('color', $room->color) }}"
                                        class="h-10 w-16 cursor-pointer rounded-md border border-gray-300 bg-white p-1 dark:border-white/10 dark:bg-white/5" />
                                    <span id="colorHex" class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ old('color') }}
                                    </span>
                                </div>
                                <x-form.error name="color" />
                            </div>
                        </div>
                        <script>
                            const colorInput = document.getElementById('color');
                            const colorHex = document.getElementById('colorHex');

                            colorInput.addEventListener('input', () => {
                                colorHex.textContent = colorInput.value;
                            });
                        </script>

                        <div class="my-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('rooms.index') }}"
                                class="text-sm/6 font-semibold text-gray-900 dark:text-white">Cancel</a>
                            <button type="submit"
                                class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>