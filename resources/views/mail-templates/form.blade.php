<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => $type === 'product' ? 'Producten' : 'Cadeaubonnen', 'url' => $type === 'product' ? route('products.index') : route('giftCards.index')],
        ['name' => 'Mail-sjablonen', 'url' => route('mail-templates.index', $type)],
        isset($template)
            ? ['name' => 'Bewerken', 'url' => route('mail-templates.edit', [$type, $template])]
            : ['name' => 'Nieuw sjabloon', 'url' => route('mail-templates.create', $type)],
    ]" />

    <div class="px-4 py-1 sm:px-6 lg:px-8 my-10">
        <form method="POST"
            action="{{ isset($template) ? route('mail-templates.update', [$type, $template]) : route('mail-templates.store', $type) }}">
            @csrf
            @if(isset($template))
                @method('PUT')
            @endif

            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">
                        {{ isset($template) ? 'Sjabloon bewerken' : 'Nieuw mail-sjabloon' }}
                    </h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">
                        Gebruik <code class="rounded bg-gray-100 dark:bg-white/10 px-1 text-xs">&#123;&#123;variabele&#125;&#125;</code> om dynamische waarden in te voegen.
                    </p>

                    <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">

                        {{-- Locale --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="locale" class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Taal</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                @if(isset($template))
                                    <input type="hidden" name="locale" value="{{ $template->locale }}" />
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-sm font-medium bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 ring-1 ring-inset ring-indigo-700/10 dark:ring-indigo-500/20">
                                        {{ strtoupper($template->locale) }} — {{ $locales[$template->locale] ?? $template->locale }}
                                    </span>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Taal kan niet worden gewijzigd. Verwijder dit sjabloon als u een andere taal wilt.</p>
                                @else
                                    <div class="grid grid-cols-1 sm:max-w-xs">
                                        <select id="locale" name="locale"
                                            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                            @foreach($locales as $code => $label)
                                                @if(!in_array($code, $usedLocales ?? []))
                                                    <option value="{{ $code }}" {{ old('locale') === $code ? 'selected' : '' }}>
                                                        {{ strtoupper($code) }} — {{ $label }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <svg viewBox="0 0 16 16" fill="currentColor" class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4 dark:text-gray-400">
                                            <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <x-form.error name="locale" />
                                @endif
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="subject" class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Onderwerp</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="subject" type="text" name="subject"
                                    placeholder="bijv. Uw bestelling — &#123;&#123;product_name&#125;&#125;"
                                    value="{{ old('subject', $template->subject ?? '') }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="subject" />
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="body" class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Inhoud</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="mb-2 flex items-center gap-3">
                                    <button type="button" onclick="document.getElementById('image-upload-input').click()"
                                        class="inline-flex items-center gap-1.5 rounded-md bg-white px-2.5 py-1.5 text-xs font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:inset-ring-white/20 dark:hover:bg-white/20 transition-colors">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 16.5V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18v-1.5m-18 0V6A2.25 2.25 0 015.25 3.75h13.5A2.25 2.25 0 0121 6v10.5m-18 0h18M8.25 8.25a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/></svg>
                                        Afbeelding invoegen
                                    </button>
                                    <span id="image-upload-status" class="text-xs text-gray-500 dark:text-gray-400"></span>
                                    <input type="file" id="image-upload-input" accept="image/*" class="hidden" onchange="uploadImage(this)" />
                                </div>
                                <textarea id="body" name="body" rows="16"
                                    placeholder="Beste &#123;&#123;customer_name&#125;&#125;,&#10;&#10;Bedankt voor uw bestelling..."
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500 font-mono text-xs">{{ old('body', $template->body ?? '') }}</textarea>
                                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">HTML is toegestaan. Gebruik variabelen zoals <code class="rounded bg-gray-100 dark:bg-white/10 px-1">&#123;&#123;customer_name&#125;&#125;</code>. Plaats de cursor op de gewenste positie en klik op "Afbeelding invoegen" om daar een afbeelding te plaatsen.</p>
                                <x-form.error name="body" />
                            </div>
                        </div>

                        {{-- Variable hints --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <div class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschikbare variabelen</div>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="rounded-lg border border-gray-200 dark:border-white/10 divide-y divide-gray-100 dark:divide-white/5 overflow-hidden">
                                    @foreach($variables as $variable => $description)
                                        <div class="flex items-start gap-4 px-4 py-3">
                                            <button type="button"
                                                onclick="insertVariable('{{ $variable }}')"
                                                class="shrink-0 font-mono text-xs rounded bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors cursor-pointer">
                                                {{ $variable }}
                                            </button>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $description }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Klik op een variabele om deze in te voegen op de cursorpositie.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('mail-templates.index', $type) }}"
                    class="text-sm/6 font-semibold text-gray-900 dark:text-white hover:underline">Annuleren</a>
                <button type="submit"
                    class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
                    Opslaan
                </button>
            </div>
        </form>
    </div>

    <script>
        var lastCursorPosition = null;

        document.getElementById('body').addEventListener('keyup', rememberCursorPosition);
        document.getElementById('body').addEventListener('click', rememberCursorPosition);

        function rememberCursorPosition() {
            var textarea = document.getElementById('body');
            lastCursorPosition = { start: textarea.selectionStart, end: textarea.selectionEnd };
        }

        function insertAtCursor(text) {
            var textarea = document.getElementById('body');
            var start = lastCursorPosition ? lastCursorPosition.start : textarea.value.length;
            var end = lastCursorPosition ? lastCursorPosition.end : textarea.value.length;
            var before = textarea.value.substring(0, start);
            var after = textarea.value.substring(end);
            textarea.value = before + text + after;
            var newPosition = start + text.length;
            textarea.focus();
            textarea.selectionStart = textarea.selectionEnd = newPosition;
            lastCursorPosition = { start: newPosition, end: newPosition };
        }

        function insertVariable(variable) {
            insertAtCursor(variable);
        }

        function uploadImage(input) {
            var file = input.files[0];
            if (!file) {
                return;
            }

            var status = document.getElementById('image-upload-status');
            status.textContent = 'Bezig met uploaden...';

            var formData = new FormData();
            formData.append('image', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}');

            fetch('{{ route('mail-templates.upload-image', $type) }}', {
                method: 'POST',
                body: formData,
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Upload mislukt');
                    }
                    return response.json();
                })
                .then(function (data) {
                    insertAtCursor('<img src="' + data.url + '" alt="" style="max-width:100%;">');
                    status.textContent = '';
                })
                .catch(function () {
                    status.textContent = 'Uploaden mislukt.';
                })
                .finally(function () {
                    input.value = '';
                });
        }
    </script>
</x-layouts.app>
