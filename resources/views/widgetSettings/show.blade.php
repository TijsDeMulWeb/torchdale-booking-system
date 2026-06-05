<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Instellingen: ' . auth()->user()->escaperoom->name, 'url' => route('escaperoom.show')],
        ['name' => 'Widget', 'url' => route('widgetSettings.show')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4 space-y-12">
        <div>
            <div class="px-4 sm:px-0">
                <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">Widgetkleuren</h3>
                <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">
                    Pas de kleuren van je widget aan. De wijzigingen zijn direct zichtbaar in de voorbeeld hieronder.
                </p>
            </div>

            <form method="POST" action="{{ route('widgetSettings.update') }}" id="color-form">
                @csrf
                @method('PUT')
                @php
                    $colorFields = [
                        'widget_color_primary' => ['label' => 'Primaire kleur', 'hint' => 'Knoppen, actieve filters en accenten.'],
                        'widget_color_primary_dark' => ['label' => 'Primaire kleur donker', 'hint' => 'Hover-staat van primaire knoppen.'],
                        'widget_color_background_dark' => ['label' => 'Achtergrond donker', 'hint' => 'Donkere achtergrond voor headers en footers.'],
                        'widget_color_text' => ['label' => 'Tekstkleur', 'hint' => 'Hoofdtekstkleur van de widget.'],
                        'widget_color_sale' => ['label' => 'Actieprijs kleur', 'hint' => 'Kleur voor kortingen en actieprijzen.'],
                        'widget_color_success' => ['label' => 'Succeskleur', 'hint' => 'Bevestigingen en successtatus.'],
                    ];
                @endphp

                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($colorFields as $name => $meta)
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-white/10 dark:bg-white/5">
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
                <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">Voorbeeld</h3>
                <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">
                    Zo ziet je widget er uit op je website.
                </p>
            </div>

            <div class="mt-6">
                <div class="border-b border-gray-200 dark:border-white/10">
                    <nav class="-mb-px flex space-x-6" aria-label="Widget types">
                        @foreach (['product' => 'Product', 'escaperoom' => 'Kamer', 'giftcard' => 'Cadeaubon'] as $type => $label)
                            <button type="button" data-tab="{{ $type }}"
                                class="widget-tab whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium transition-colors {{ $loop->first ? 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                @foreach (['product', 'escaperoom', 'giftcard'] as $type)
                    <div id="tab-panel-{{ $type }}" class="widget-panel mt-6 {{ $loop->first ? '' : 'hidden' }}">
                        <div data-tp-public-key="er_pub_38e302f5e7f3b591e4955dc1cc929ee7" data-tp-type="{{ $type }}"></div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script src="https://project.tijs.demul.kdgmt.be/tp-widget/widget-loader.js" defer></script>

    <script>
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

        const inputToVar = {
            'widget_color_primary': '--tp-primary-color',
            'widget_color_primary_dark': '--tp-primary-dark',
            'widget_color_background_dark': '--tp-background-dark',
            'widget_color_text': '--tp-color-text',
            'widget_color_sale': '--tp-color-sale',
            'widget_color_success': '--tp-color-success',
        };

        const overlaySelectors = [
            '.tp-cart-drawer',
            '.tp-cart-fab',
            '.tp-product-modal',
            '.tp-room-modal',
            '.tp-checkout-modal',
        ];

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