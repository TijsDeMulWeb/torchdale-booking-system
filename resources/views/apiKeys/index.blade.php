<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Instellingen: ' . auth()->user()->escaperoom->name, 'url' => route('escaperoom.show')],
        ['name' => 'API Keys', 'url' => route('apiKeys.index')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="h-[calc(100vh-186px)] overflow-y-auto sm:h-[calc(100vh-174px)]">
            <div
                class="rounded-2xl border border-gray-200 bg-white shadow-sm px-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div
                    class="flex flex-col justify-between gap-5 border-b border-gray-200 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white/90">API Keys</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            API keys worden gebruikt om requests te authenticeren naar de booking integratie.
                        </p>
                    </div>
                    <button id="open-modal-btn"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <path d="M5 10H15M10 5V15" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        API Key Toevoegen
                    </button>
                </div>
                <div class="overflow-x-auto pb-4">
                    @if ($apiKeys->count() > 0)
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="py-3 pr-5 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Naam</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Status</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Aangemaakt</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Laatste gebruik</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Allowed origin</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Acties</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($apiKeys as $key)
                                    <tr>
                                        <td class="py-4 pr-5 whitespace-nowrap">
                                            <div class="mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ $key->name }}
                                            </div>
                                            <div class="relative">
                                                <input type="text" value="{{ $key->public_key }}" readonly
                                                    class="h-10 w-full min-w-[320px] rounded-lg border border-gray-300 bg-gray-50 py-2 pr-24 pl-3.5 font-mono text-xs text-gray-600 select-all cursor-default dark:border-gray-700 dark:bg-gray-800/60 dark:text-gray-300">
                                                <button type="button" data-key="{{ $key->public_key }}"
                                                    class="copy-btn absolute top-1/2 right-0 inline-flex h-10 -translate-y-1/2 items-center gap-1.5 rounded-r-lg border-y border-r border-gray-300 bg-white px-3 text-xs font-medium text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <svg class="copy-icon size-3.5 fill-current" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.588 4.584a.5.5 0 0 1 .5-.5h8.327a.5.5 0 0 1 .5.5v8.329a.5.5 0 0 1-.5.5H7.088a.5.5 0 0 1-.5-.5V4.584ZM7.088 2.584A2.5 2.5 0 0 0 4.588 5.09v.51h-.504A2.5 2.5 0 0 0 1.585 8.094v8.322a2.5 2.5 0 0 0 2.5 2.5h8.32a2.5 2.5 0 0 0 2.5-2.5v-.513h.51a2.5 2.5 0 0 0 2.5-2.5V4.584a2.5 2.5 0 0 0-2.5-2.5H7.088Z" />
                                                    </svg>
                                                    <svg class="check-icon size-3.5 fill-current text-green-500 hidden"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 0 1 0 1.414l-8 8a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L8 12.586l7.293-7.293a1 1 0 0 1 1.414 0z" />
                                                    </svg>
                                                    <span class="copy-text">Copy</span>
                                                </button>
                                            </div>
                                            <p
                                                class="copy-feedback mt-1.5 hidden text-xs font-medium text-green-600 dark:text-green-400">
                                                ✓ Gekopieerd naar klembord
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @if ($key->is_active)
                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-green-200 dark:bg-green-500/15 dark:text-green-400 dark:ring-green-500/20">
                                                    <span class="size-1.5 rounded-full bg-green-500"></span>Actief
                                            </span>@else<span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-600 ring-1 ring-red-200 dark:bg-red-500/15 dark:text-red-400 dark:ring-red-500/20">
                                                    <span class="size-1.5 rounded-full bg-red-400"></span>Uitgeschakeld
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            {{ $key->created_at->format('d M, Y') }}
                                        </td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            {{ $key->last_used_at ? $key->last_used_at->diffForHumans() : '—' }}
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @if ($key->allowed_origin)
                                                <span
                                                    class="font-mono text-xs text-gray-600 dark:text-gray-400">{{ $key->allowed_origin }}</span>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-600">Alle origins</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <form method="POST" action="#" class="toggle-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label class="relative inline-flex cursor-pointer items-center">
                                                        <input type="checkbox" class="toggle-checkbox sr-only" {{ $key->is_active ? 'checked' : '' }}>
                                                        <div
                                                            class="toggle-track h-6 w-11 rounded-full transition-colors duration-200 {{ $key->is_active ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-white/10' }}">
                                                        </div>
                                                        <div
                                                            class="toggle-thumb absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform duration-200 {{ $key->is_active ? 'translate-x-5' : 'translate-x-0' }}">
                                                        </div>
                                                    </label>
                                                </form>
                                                <form method="POST" action="#" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="delete-btn text-gray-400 transition-colors hover:text-red-500 dark:text-gray-600 dark:hover:text-red-400"
                                                        title="Verwijderen">
                                                        <svg class="size-5 fill-current" viewBox="0 0 21 21"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex flex-col items-center justify-center py-20 text-center">
                            <div class="flex size-16 items-center justify-center rounded-2xl bg-gray-100 dark:bg-white/5">
                                <svg class="size-8 text-gray-400 dark:text-gray-600" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 7a5 5 0 1 1 3.61 4.804l-1.903 1.903A1 1 0 0 1 9 14H8v1a1 1 0 0 1-1 1H6v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-2a1 1 0 0 1 .293-.707L7.196 9.39A5.002 5.002 0 0 1 8 7Zm5-1a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25.75.75 0 0 1-1.5 0 .75.75 0 0 0-.75-.75A.75.75 0 0 1 13 6Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-sm font-semibold text-gray-900 dark:text-white">Geen API keys</h3>
                            <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">Maak een API key aan om je booking
                                integratie te koppelen.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="api-key-modal"
        class="pointer-events-none fixed inset-0 z-[9999] flex items-center justify-center p-5 opacity-0 transition-opacity duration-200">
        <div id="modal-backdrop" class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>
        <div
            class="relative z-10 w-full max-w-lg translate-y-2 rounded-2xl bg-white p-6 shadow-xl transition-transform duration-200 lg:p-8 dark:bg-gray-900 dark:ring-1 dark:ring-white/10">
            <button id="close-modal-btn"
                class="absolute top-4 right-4 flex size-8 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z" />
                </svg>
            </button>

            <h4 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">API Key Aanmaken</h4>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                Geef je API key een naam zodat je hem later makkelijk herkent.
            </p>

            <form method="POST" action="#">
                @csrf
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Naam van de applicatie
                </label>
                <input type="text" name="name" placeholder="bijv. Mijn Booking Widget"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-indigo-400">

                <label class="mb-1.5 mt-5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Website
                </label>
                <input type="text" name="allowed_origin" placeholder="bijv. https://mijnwebsite.be"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-indigo-400">
                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    De <strong class="text-gray-700 dark:text-gray-300">secret key</strong> wordt eenmalig getoond na
                    aanmaak. Bewaar het op een veilige plek.
                </p>
                <div class="mt-6 flex gap-3">
                    <button type="button" id="cancel-modal-btn"
                        class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Annuleren
                    </button>
                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-indigo-500">
                        Genereer API Key
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── Modal ──────────────────────────────────────────────
        const modal = document.getElementById('api-key-modal');
        const modalPanel = modal.querySelector('.relative.z-10');
        const backdrop = document.getElementById('modal-backdrop');

        function openModal() {
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('opacity-100');
            modalPanel.classList.remove('translate-y-2');
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modal.classList.remove('opacity-100');
            modalPanel.classList.add('translate-y-2');
            setTimeout(() => modal.classList.add('pointer-events-none'), 200);
        }

        document.getElementById('open-modal-btn').addEventListener('click', openModal);
        document.getElementById('close-modal-btn').addEventListener('click', closeModal);
        document.getElementById('cancel-modal-btn').addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

        // ── Copy ───────────────────────────────────────────────
        function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                return navigator.clipboard.writeText(text);
            }
            // Fallback voor HTTP (geen HTTPS)
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            return Promise.resolve();
        }

        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const feedback = this.closest('td').querySelector('.copy-feedback');
                const self = this;
                copyToClipboard(this.dataset.key).then(() => {
                    self.querySelector('.copy-icon').classList.add('hidden');
                    self.querySelector('.check-icon').classList.remove('hidden');
                    self.querySelector('.copy-text').textContent = 'Copied!';
                    if (feedback) feedback.classList.remove('hidden');

                    clearTimeout(self._copyTimer);
                    self._copyTimer = setTimeout(() => {
                        self.querySelector('.copy-icon').classList.remove('hidden');
                        self.querySelector('.check-icon').classList.add('hidden');
                        self.querySelector('.copy-text').textContent = 'Copy';
                        if (feedback) feedback.classList.add('hidden');
                    }, 2000);
                });
            });
        });

        // ── Toggle ─────────────────────────────────────────────
        document.querySelectorAll('.toggle-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const track = this.closest('label').querySelector('.toggle-track');
                const thumb = this.closest('label').querySelector('.toggle-thumb');
                if (this.checked) {
                    track.classList.add('bg-indigo-600');
                    track.classList.remove('bg-gray-200', 'dark:bg-white/10');
                    thumb.classList.add('translate-x-5');
                    thumb.classList.remove('translate-x-0');
                } else {
                    track.classList.remove('bg-indigo-600');
                    track.classList.add('bg-gray-200');
                    thumb.classList.remove('translate-x-5');
                    thumb.classList.add('translate-x-0');
                }
                this.closest('form').submit();
            });
        });
    </script>
</x-layouts.app>