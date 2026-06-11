<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('nav.settings') . ': ' . auth()->user()->escaperoom->name, 'url' => route('escaperoom.show')],
        ['name' => __('widgets.breadcrumb_widget'), 'url' => route('widgetSettings.show')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="border-b border-gray-200 dark:border-white/10">
            <nav class="-mb-px flex space-x-8">
                <button type="button" data-main-tab="kleuren"
                    class="main-tab whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium transition-colors border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400">
                    {{ __('widgets.tab_colors') }}
                </button>
                <button type="button" data-main-tab="integreren"
                    class="main-tab whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium transition-colors border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                    {{ __('widgets.tab_integrate') }}
                </button>
            </nav>
        </div>

        <div id="main-panel-kleuren" class="main-panel mt-10 space-y-12">
            <div>
                <div class="px-4 sm:px-0">
                    <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('widgets.colors_title') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">
                        {{ __('widgets.colors_description') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('widgetSettings.update') }}" id="color-form">
                    @csrf
                    @method('PUT')
                    @php
                        $colorFields = [
                            'widget_color_primary' => ['label' => __('widgets.color_primary_label'), 'hint' => __('widgets.color_primary_hint')],
                            'widget_color_primary_dark' => ['label' => __('widgets.color_primary_dark_label'), 'hint' => __('widgets.color_primary_dark_hint')],
                            'widget_color_background_dark' => ['label' => __('widgets.color_background_dark_label'), 'hint' => __('widgets.color_background_dark_hint')],
                            'widget_color_text' => ['label' => __('widgets.color_text_label'), 'hint' => __('widgets.color_text_hint')],
                            'widget_color_sale' => ['label' => __('widgets.color_sale_label'), 'hint' => __('widgets.color_sale_hint')],
                            'widget_color_success' => ['label' => __('widgets.color_success_label'), 'hint' => __('widgets.color_success_hint')],
                        ];
                    @endphp

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($colorFields as $name => $meta)
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-white/10 dark:bg-white/5">
                                <label for="{{ $name }}" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $meta['label'] }}
                                </label>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $meta['hint'] }}</p>
                                <div class="mt-3 flex items-center gap-3">
                                    <input type="color" id="{{ $name }}" name="{{ $name }}"
                                        value="{{ old($name, $widgetSettings[$name] ?? '#000000') }}"
                                        class="h-10 w-16 cursor-pointer rounded-md border border-gray-300 bg-white p-1 dark:border-white/10 dark:bg-white/5" />
                                    <input type="text" id="{{ $name }}_text"
                                        value="{{ old($name, $widgetSettings[$name] ?? '#000000') }}" maxlength="7"
                                        placeholder="#000000" data-for="{{ $name }}"
                                        class="hex-input block w-28 rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">
                                </div>
                                <x-form.error :name="$name" />
                            </div>
                        @endforeach
                    </div>

                    <x-form.actions route="widgetSettings.show" />
                </form>
            </div>

            <div>
                <div class="px-4 sm:px-0">
                    <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('widgets.preview_title') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">
                        {{ __('widgets.preview_description') }}
                    </p>
                </div>

                <div class="mt-6">
                    <div class="border-b border-gray-200 dark:border-white/10">
                        <nav class="-mb-px flex space-x-6" aria-label="Widget types">
                            @foreach (['product' => __('widgets.type_product'), 'escaperoom' => __('widgets.type_room'), 'giftcard' => __('widgets.type_giftcard')] as $type => $label)
                                <button type="button" data-tab="{{ $type }}"
                                    class="widget-tab whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium transition-colors {{ $loop->first ? 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </nav>
                    </div>

                    @if ($apiKeys->isNotEmpty())
                        @foreach (['product', 'escaperoom', 'giftcard'] as $type)
                            <div id="tab-panel-{{ $type }}" class="widget-panel mt-6 {{ $loop->first ? '' : 'hidden' }}">
                                <div data-tp-public-key="{{ $defaultApiKey->public_key }}" data-tp-type="{{ $type }}">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('widgets.no_api_key') }}
                            <a href="{{ route('apiKeys.index') }}" class="text-indigo-600 hover:underline dark:text-indigo-400">{{ __('widgets.create_one') }}</a>
                        </p>
                    @endif
                </div>
            </div>

        </div>

        <div id="main-panel-integreren" class="main-panel mt-10 hidden">

            <div class="px-4 sm:px-0">
                <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('widgets.install_title') }}</h3>
                <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">
                    {{ __('widgets.install_description') }}
                </p>
            </div>

            @if ($apiKeys->isNotEmpty())
                <div class="mt-6">
                    <label for="embed-key-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('widgets.api_key_label') }}
                    </label>
                    <select id="embed-key-select"
                        class="mt-1.5 block w-full max-w-sm rounded-md bg-white px-3 py-2 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500">
                        @foreach ($apiKeys as $key)
                            <option value="{{ $key->public_key }}" data-origin="{{ $key->allowed_origin }}">
                                {{ $key->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        {!! __('widgets.works_only_on', ['origin' => '<strong id="embed-origin">' . e($apiKeys->first()->allowed_origin) . '</strong>']) !!}
                    </p>
                </div>

                <div class="mt-6 space-y-4">
                    @foreach (['product' => __('widgets.type_product'), 'escaperoom' => __('widgets.type_room'), 'giftcard' => __('widgets.type_giftcard')] as $type => $label)
                        <div class="rounded-lg border border-gray-200 bg-gray-50 dark:border-white/10 dark:bg-white/5">
                            <div
                                class="flex items-center justify-between border-b border-gray-200 px-4 py-2.5 dark:border-white/10">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                <button type="button" onclick="copyCode(this)"
                                    data-type="{{ $type }}"
                                    class="embed-copy-btn flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-white/10 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-3.5">
                                        <path fill-rule="evenodd"
                                            d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M3 6a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H3Zm1.75 2.5a.75.75 0 0 0 0 1.5h2.5a.75.75 0 0 0 0-1.5h-2.5Zm0 3a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ __('widgets.copy_button') }}
                                </button>
                            </div>
                            <pre class="overflow-x-auto px-4 py-3 text-xs text-gray-800 dark:text-gray-200 leading-relaxed"><code class="embed-code" data-type="{{ $type }}">&lt;div data-tp-public-key="{{ $apiKeys->first()->public_key }}" data-tp-type="{{ $type }}"&gt;&lt;/div&gt;
&lt;script src="https://project.tijs.demul.kdgmt.be/tp-widget/widget-loader.js" defer&gt;&lt;/script&gt;</code></pre>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('widgets.no_api_key') }}
                    <a href="{{ route('apiKeys.index') }}" class="text-indigo-600 hover:underline dark:text-indigo-400">{{ __('widgets.create_one') }}</a>
                </p>
            @endif

        </div>
    </div>
    <script src="https://project.tijs.demul.kdgmt.be/tp-widget/widget-loader.js" defer></script>
    <script>
        const I18N = {!! \Illuminate\Support\Js::from([
            'copied' => __('widgets.copied_js'),
        ]) !!};

        const MAIN_BASE = 'main-tab whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium transition-colors';
        const MAIN_ACTIVE = MAIN_BASE + ' border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400';
        const MAIN_INACTIVE = MAIN_BASE + ' border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white';

        document.querySelectorAll('.main-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.mainTab;
                document.querySelectorAll('.main-tab').forEach(t => {
                    t.className = t.dataset.mainTab === target ? MAIN_ACTIVE : MAIN_INACTIVE;
                });
                document.querySelectorAll('.main-panel').forEach(panel => {
                    panel.classList.toggle('hidden', panel.id !== `main-panel-${target}`);
                });
            });
        });

        // ── Copy embed code ───────────────────────────────────────────────────
        function copyCode(btn) {
            const type = btn.dataset.type;
            const code = document.querySelector(`.embed-code[data-type="${type}"]`).textContent;
            navigator.clipboard.writeText(code).then(() => {
                const original = btn.innerHTML;
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-3.5"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg> ' + I18N.copied;
                setTimeout(() => { btn.innerHTML = original; }, 2000);
            });
        }

        // ── Embed key selector ────────────────────────────────────────────────
        const embedSelect = document.getElementById('embed-key-select');
        if (embedSelect) {
            embedSelect.addEventListener('change', () => {
                const publicKey = embedSelect.value;
                const origin = embedSelect.selectedOptions[0].dataset.origin;

                document.querySelectorAll('.embed-code').forEach(code => {
                    const type = code.dataset.type;
                    code.textContent = `<div data-tp-public-key="${publicKey}" data-tp-type="${type}"></div>\n<script src="https://project.tijs.demul.kdgmt.be/tp-widget/widget-loader.js" defer><\/script>`;
                });

                const originEl = document.getElementById('embed-origin');
                if (originEl) originEl.textContent = origin ?? '—';
            });
        }

        // ── Color pickers ─────────────────────────────────────────────────────
        document.querySelectorAll('input[type="color"]').forEach(picker => {
            const textInput = document.querySelector(`.hex-input[data-for="${picker.id}"]`);
            if (!textInput) return;

            picker.addEventListener('input', () => {
                textInput.value = picker.value;
                applyPreviewColors();
            });

            textInput.addEventListener('input', () => {
                const val = textInput.value.trim();
                if (/^#[0-9a-fA-F]{6}$/.test(val)) {
                    picker.value = val;
                    applyPreviewColors();
                }
            });
        });

        // ── Live preview ──────────────────────────────────────────────────────
        const inputToVar = {
            'widget_color_primary': '--tp-primary-color',
            'widget_color_primary_dark': '--tp-primary-dark',
            'widget_color_background_dark': '--tp-background-dark',
            'widget_color_text': '--tp-color-text',
            'widget_color_sale': '--tp-color-sale',
            'widget_color_success': '--tp-color-success',
        };

        const overlaySelectors = ['.tp-cart-drawer', '.tp-cart-fab', '.tp-product-modal', '.tp-room-modal', '.tp-checkout-modal'];

        function applyPreviewColors() {
            const containers = document.querySelectorAll('[data-tp-public-key]');
            Object.entries(inputToVar).forEach(([inputName, cssVar]) => {
                const picker = document.getElementById(inputName);
                if (!picker) return;
                containers.forEach(el => el.style.setProperty(cssVar, picker.value));
                overlaySelectors.forEach(sel => {
                    document.querySelectorAll(sel).forEach(el => el.style.setProperty(cssVar, picker.value));
                });
            });
        }

        window.addEventListener('load', () => setTimeout(applyPreviewColors, 500));

        // ── Widget type tabs ──────────────────────────────────────────────────
        const TAB_BASE = 'widget-tab whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium transition-colors';
        const TAB_ACTIVE = TAB_BASE + ' border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400';
        const TAB_INACTIVE = TAB_BASE + ' border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white';

        document.querySelectorAll('.widget-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.tab;
                document.querySelectorAll('.widget-tab').forEach(t => {
                    t.className = t.dataset.tab === target ? TAB_ACTIVE : TAB_INACTIVE;
                });
                document.querySelectorAll('.widget-panel').forEach(panel => {
                    panel.classList.toggle('hidden', panel.id !== `tab-panel-${target}`);
                });
                setTimeout(applyPreviewColors, 300);
            });
        });
    </script>
</x-layouts.app>