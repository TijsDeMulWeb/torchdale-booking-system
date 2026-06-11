<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('giftCards.section_title'), 'url' => route('giftCards.index')],
        ['name' => $giftCard->name, 'url' => route('giftCards.edit', $giftCard->id)],
        ['name' => __('common.edit'), 'url' => route('giftCards.edit', $giftCard->id)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('giftCards.update', $giftCard->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('giftCards.section_title') }}</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">{{ __('giftCards.section_description') }}</p>
                    <x-last-updated :model="$giftCard" />
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('giftCards.name_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="{{ __('giftCards.name_label') }}"
                                    value="{{ old('name', $giftCard->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="description"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('giftCards.description_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <textarea id="description" name="description" rows="3"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">{{ old('description', $giftCard->description) }}</textarea>
                                <x-form.error name="description" />
                            </div>
                        </div>
                        {{-- Image --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">
                                {{ __('giftCards.image_label') }}
                                <span class="block mt-0.5 font-normal text-xs text-gray-500 dark:text-gray-400">{{ __('giftCards.image_helper') }}</span>
                            </label>
                            <div class="mt-2 flex items-center gap-x-3 sm:col-span-2 sm:mt-0">
                                <img id="gc-image-preview"
                                    src="{{ $giftCard->image ? Storage::url($giftCard->image) : 'https://placehold.co/400x400' }}"
                                    alt="Cadeaubon afbeelding preview"
                                    class="max-h-24 w-auto rounded-lg object-contain border border-gray-200 dark:border-white/10">
                                <input id="gc-image" name="image" type="file" accept="image/*" class="hidden" onchange="previewGiftCardImage(event)">

                                <button type="button" onclick="document.getElementById('gc-image').click()"
                                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">
                                    {{ __('common.edit') }}
                                </button>
                                <x-form.error name="image" />
                            </div>
                        </div>
                        <script>
                            function previewGiftCardImage(event) {
                                const file = event.target.files[0];
                                if (!file) return;

                                const img = document.getElementById('gc-image-preview');
                                img.src = URL.createObjectURL(file);
                            }
                        </script>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="discountValue"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('giftCards.amount_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="discountValue" type="text" name="amount" placeholder="{{ __('giftCards.amount_label') }}"
                                    value="{{ old('amount', $giftCard->amount) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="amount" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="availableFrom"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.available_from_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="availableFrom" type="date" name="valid_from"
                                    value="{{ old('valid_from', $giftCard->valid_from->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="valid_from" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="availableUntil"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('giftCards.available_until_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="availableUntil" type="date" name="valid_until"
                                    value="{{ old('valid_until', $giftCard->valid_until?->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="valid_until" />
                            </div>
                        </div>

                        {{-- Shipping cost --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="gc-shipping-cost" class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">
                                {{ __('products.shipping_label') }}
                                <span class="block mt-0.5 font-normal text-xs text-gray-500 dark:text-gray-400">{{ __('giftCards.shipping_cost_helper') }}</span>
                            </label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="relative sm:max-w-xs">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">€</span>
                                    <input id="gc-shipping-cost" type="number" name="shipping_cost" min="0" max="99.99" step="0.01"
                                        value="{{ old('shipping_cost', number_format((float)($giftCard->shipping_cost ?? 0), 2, '.', '')) }}"
                                        class="block w-full pl-7 rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-xs sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('giftCards.shipping_cost_note') }}</p>
                                <x-form.error name="shipping_cost" />
                            </div>
                        </div>

                        {{-- Delivery methods --}}
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">
                                {{ __('giftCards.delivery_methods_label') }}
                                <span class="block mt-0.5 font-normal text-xs text-gray-500 dark:text-gray-400">{{ __('giftCards.delivery_methods_helper') }}</span>
                            </label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0 space-y-3">
                                <div class="flex items-start gap-3">
                                    <input id="allow_mail_delivery" type="checkbox" name="allow_mail_delivery" value="1"
                                        {{ old('allow_mail_delivery', $giftCard->allow_mail_delivery) ? 'checked' : '' }}
                                        class="mt-1 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-white/10 dark:bg-white/5" />
                                    <label for="allow_mail_delivery" class="text-sm text-gray-700 dark:text-gray-300">{{ __('giftCards.delivery_email') }}</label>
                                </div>
                                <div class="flex items-start gap-3">
                                    <input id="allow_post_delivery" type="checkbox" name="allow_post_delivery" value="1"
                                        {{ old('allow_post_delivery', $giftCard->allow_post_delivery) ? 'checked' : '' }}
                                        class="mt-1 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-white/10 dark:bg-white/5" />
                                    <label for="allow_post_delivery" class="text-sm text-gray-700 dark:text-gray-300">{{ __('giftCards.delivery_post') }}</label>
                                </div>
                                <div class="flex items-start gap-3">
                                    <input id="allow_pickup_delivery" type="checkbox" name="allow_pickup_delivery" value="1"
                                        {{ old('allow_pickup_delivery', $giftCard->allow_pickup_delivery) ? 'checked' : '' }}
                                        class="mt-1 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-white/10 dark:bg-white/5" />
                                    <label for="allow_pickup_delivery" class="text-sm text-gray-700 dark:text-gray-300">{{ __('giftCards.delivery_pickup') }}</label>
                                </div>
                                <x-form.error name="allow_mail_delivery" />
                                <x-form.error name="allow_post_delivery" />
                                <x-form.error name="allow_pickup_delivery" />
                                <x-form.error name="allow_delivery_method" />
                            </div>
                        </div>

                        <x-form.actions route="giftCards.index" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>