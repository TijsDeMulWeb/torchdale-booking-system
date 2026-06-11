<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('nav.products'), 'url' => route('products.index')],
        ['name' => $product->name, 'url' => route('products.edit', $product->id)],
        ['name' => __('common.edit'), 'url' => route('products.edit', $product->id)],
    ]" />
    <div class="px-4 py-1 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('products.update', $product->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('products.section_title') }}</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">{{ __('products.section_description_edit', ['name' => $product->name]) }}</p>
                    <x-last-updated :model="$product" />
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.name_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="{{ __('products.name_label') }}"
                                    value="{{ old('name', $product->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="sku"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.sku_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="sku" type="text" name="sku" placeholder="{{ __('products.sku_label') }}"
                                    value="{{ old('sku', $product->sku) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="sku" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="categoryId"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.category_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="categoryId" name="category_id"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
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
                                <button command="show-modal" commandfor="drawer" type="button"
                                    class="mt-1 inline-block text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('products.category_not_found') }} <span class="text-indigo-600 dark:text-indigo-400 cursor-pointer">{{ __('products.new_category_link') }}</span>
                                </button>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="about"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.details_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <textarea id="description" name="description" rows="10"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">{{ old('description', $product->description) }}</textarea>
                                <p class="mt-3 text-sm/6 text-gray-600 dark:text-gray-400">{{ __('products.details_helper') }}</p>
                                <x-form.error name="description" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="costPrice"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.cost_price_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="costPrice" type="text" name="cost_price" placeholder="{{ __('products.cost_price_label') }}"
                                    value="{{ old('cost_price', $product->cost_price) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="cost_price" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="sellingPrice"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.selling_price_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="sellingPrice" type="text" name="selling_price" placeholder="{{ __('products.selling_price_label') }}"
                                    value="{{ old('selling_price', $product->selling_price) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="selling_price" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6" id="variants-section">
                            <div class="sm:pt-1.5">
                                <label class="block text-sm/6 font-medium text-gray-900 dark:text-white">{{ __('products.variants_label') }}</label>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('products.variants_helper') }}</p>
                            </div>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div id="variants-list" class="space-y-2 mb-3"></div>
                                <button type="button" onclick="addVariantRow()"
                                    class="inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 border border-indigo-300 dark:border-indigo-500/40 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    {{ __('products.add_variant') }}
                                </button>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.shipping_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label for="shippingCostDomestic" class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('products.shipping_domestic') }}</label>
                                        <input id="shippingCostDomestic" type="text" name="shipping_cost_domestic" placeholder="0.00"
                                            value="{{ old('shipping_cost_domestic', $product->shipping_cost_domestic) }}"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                        <x-form.error name="shipping_cost_domestic" />
                                    </div>
                                    <div class="flex-1">
                                        <label for="shippingCostInternational" class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('products.shipping_international') }}</label>
                                        <input id="shippingCostInternational" type="text" name="shipping_cost_international" placeholder="0.00"
                                            value="{{ old('shipping_cost_international', $product->shipping_cost_international) }}"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                        <x-form.error name="shipping_cost_international" />
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('products.shipping_helper') }}</p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="vatPercentage"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.vat_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="vatPercentage" type="text" name="vat_percentage" placeholder="{{ __('products.vat_label') }}"
                                    value="{{ old('vat_percentage', $product->vat_percentage) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="vat_percentage" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="discountType"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.discount_type_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="discountType" name="discount_type"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        <option value="" {{ old('discount_type', $product->discount_type) === null ? 'selected' : '' }}>{{ __('products.discount_none') }}</option>
                                        <option value="fixed" {{ old('discount_type', $product->discount_type) === 'fixed' ? 'selected' : '' }}>{{ __('products.discount_fixed') }}</option>
                                        <option value="percentage" {{ old('discount_type', $product->discount_type) === 'percentage' ? 'selected' : '' }}>{{ __('products.discount_percentage') }}
                                        </option>
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
                            <label for="discountValue"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.discount_value_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="discountValue" type="text" name="discount_value" placeholder="{{ __('products.discount_value_label') }}"
                                    value="{{ old('discount_value', $product->discount_value) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="discount_value" />
                            </div>
                        </div>
                        <div id="product-stock-row" class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="stockQuantity"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.stock_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="stockQuantity" type="text" name="stock_quantity" placeholder="{{ __('products.stock_label') }}"
                                    value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="stock_quantity" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="availableFrom"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('products.available_from_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="availableFrom" type="date" name="available_from"
                                    value="{{ old('available_from', $product->available_from?->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="available_from" />
                            </div>
                        </div>
                        <x-form.actions route="products.index" />
                    </div>
                </div>
            </div>
        </form>
        <div class="px-4 sm:px-0 lg:px-0 my-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
                <h2 class="sr-only">{{ __('products.images_title') }}</h2>
                @foreach ($product->product_images as $productImage)
                    <div
                        class="relative rounded-lg overflow-hidden bg-gray-50 shadow-xs outline-1 outline-gray-900/5 dark:bg-gray-800/50 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10 flex flex-col">
                        <img class="w-full object-cover"
                            src="{{ $productImage->url ? Storage::url($productImage->url) : 'https://placehold.co/400x400' }}"
                            alt="{{ $productImage->alt_text ?? __('products.default_alt_text') }}">
                        @if ($productImage->is_primary)
                            <div class="flex-none px-6 py-4">
                                <dt class="sr-only">{{ __('customers.table_status') }}</dt>
                                <dd
                                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 inset-ring inset-ring-green-600/20 dark:bg-green-500/15 dark:text-green-400 dark:inset-ring-green-500/20">
                                    {{ __('products.primary_badge') }}</dd>
                            </div>
                        @endif

                        <div class="border-t border-gray-900/5 px-6 py-6 dark:border-white/5">
                            <form action="{{ route('products.images.destroy', ['id' => $product->id, 'imageId' => $productImage->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-sm/6 font-semibold text-gray-900 hover:text-gray-700 dark:text-white dark:hover:text-gray-300 cursor-pointer">{{ __('common.delete') }}
                                    <span aria-hidden="true">&rarr;</span></button>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div
                    class="rounded-lg border-2 border-dashed border-gray-300 dark:border-white/20 flex flex-col items-center justify-center text-center px-6 py-10 hover:border-indigo-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-10 w-10 text-gray-400 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ __('products.new_image_title') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('products.new_image_description') }}
                    </p>
                    <button command="show-modal" commandfor="add-image"
                        class="mt-4 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        {{ __('products.add_image') }}
                    </button>
                </div>
            </div>
        </div>

        <el-dialog>
            <dialog id="drawer" aria-labelledby="drawer-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-hidden bg-transparent backdrop:bg-transparent">
                <div tabindex="0" class="absolute inset-0 pl-10 focus:outline-none sm:pl-16">
                    <el-dialog-panel
                        class="ml-auto block size-full max-w-2xl transform transition duration-500 ease-in-out data-closed:translate-x-full sm:duration-700">
                        <form method="POST" action="{{ route('categories.store') }}"
                            class="relative flex h-full flex-col overflow-y-auto bg-white shadow-xl dark:bg-gray-900">
                            @csrf
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="bg-gray-50 px-4 py-6 sm:px-6 dark:bg-gray-800">
                                    <div class="flex items-start justify-between space-x-3">
                                        <div class="space-y-1">
                                            <h2 id="drawer-title"
                                                class="text-base font-semibold text-gray-900 dark:text-white">{{ __('categories.new_category_title') }}</h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('categories.new_category_description') }}</p>
                                        </div>
                                        <div class="flex h-7 items-center">
                                            <button type="button" command="close" commandfor="drawer"
                                                class="relative rounded-md text-gray-400 hover:text-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:text-gray-500 dark:hover:text-gray-400">
                                                <span class="absolute -inset-2.5"></span>
                                                <span class="sr-only">{{ __('common.close_panel') }}</span>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                                                    class="size-6">
                                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Divider container -->
                                <div
                                    class="space-y-6 py-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0 dark:sm:divide-white/10">
                                    <!-- Category name -->
                                    <div
                                        class="space-y-2 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div>
                                            <label for="categoryName"
                                                class="block text-sm/6 font-medium text-gray-900 sm:mt-1.5 dark:text-white">{{ __('categories.category_name_label') }}</label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <input id="categoryName" type="text" name="name"
                                                placeholder="{{ __('categories.category_name_label') }}" value="{{ old('name') }}"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus-visible:outline-indigo-500" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action buttons -->
                            <div class="shrink-0 border-t border-gray-200 px-4 py-5 sm:px-6 dark:border-white/10">
                                <div class="flex justify-end space-x-3">
                                    <button type="button" command="close" commandfor="drawer"
                                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:inset-ring-white/20 dark:hover:bg-white/20">{{ __('common.cancel') }}</button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">{{ __('common.create') }}</button>
                                </div>
                            </div>
                        </form>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
        <el-dialog>
            <dialog id="add-image" aria-labelledby="drawer-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-hidden bg-transparent backdrop:bg-transparent">
                <div tabindex="0" class="absolute inset-0 pl-10 focus:outline-none sm:pl-16">
                    <el-dialog-panel
                        class="ml-auto block size-full max-w-2xl transform transition duration-500 ease-in-out data-closed:translate-x-full sm:duration-700">
                        <form method="POST" action="{{ route('products.images.store', $product->id) }}"
                            enctype="multipart/form-data"
                            class="relative flex h-full flex-col overflow-y-auto bg-white shadow-xl dark:bg-gray-900">
                            @csrf
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="bg-gray-50 px-4 py-6 sm:px-6 dark:bg-gray-800">
                                    <div class="flex items-start justify-between space-x-3">
                                        <div class="space-y-1">
                                            <h2 id="drawer-title"
                                                class="text-base font-semibold text-gray-900 dark:text-white">{{ __('products.new_image_title') }}</h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('products.new_image_dialog_description') }}</p>
                                        </div>
                                        <div class="flex h-7 items-center">
                                            <button type="button" command="close" commandfor="add-image"
                                                class="relative rounded-md text-gray-400 hover:text-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:text-gray-500 dark:hover:text-gray-400">
                                                <span class="absolute -inset-2.5"></span>
                                                <span class="sr-only">{{ __('common.close_panel') }}</span>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                                                    class="size-6">
                                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product image -->
                                <div
                                    class="space-y-6 py-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0 dark:sm:divide-white/10">
                                    <div
                                        class="space-y-2 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div>
                                            <label for="productImage"
                                                class="block text-sm/6 font-medium text-gray-900 sm:mt-1.5 dark:text-white">
                                                {{ __('products.product_image_label') }}
                                            </label>
                                        </div>
                                        <div class="sm:col-span-2 space-y-4">
                                            <img id="productImagePreview"
                                                src="https://placehold.co/200x200?text=Preview" alt="Preview"
                                                class="size-24 rounded-xl bg-gray-100 object-cover shadow-sm ring-1 ring-black/5 dark:bg-gray-800 dark:ring-white/10" />

                                            <input id="productImage" name="product_image" type="file" accept="image/*"
                                                class="hidden" onchange="previewImage(event)">
                                            <button type="button"
                                                onclick="document.getElementById('productImage').click()"
                                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:ring-white/10 dark:hover:bg-white/20">
                                                {{ __('products.choose_image') }}
                                            </button>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ __('products.image_help') }}
                                            </p>
                                            <x-form.error name="product_image" />
                                        </div>
                                    </div>

                                    <div
                                        class="space-y-2 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div>
                                            <label for="altText"
                                                class="block text-sm/6 font-medium text-gray-900 sm:mt-1.5 dark:text-white">{{ __('products.alt_text_label') }}</label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <input id="altText" type="text" name="alt_text" placeholder="{{ __('products.alt_text_label') }}"
                                                value="{{ old('alt_text', $product->name) }}"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus-visible:outline-indigo-500" />
                                        </div>
                                    </div>

                                    <!-- Primary image -->
                                    <div
                                        class="space-y-2 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div>
                                            <label for="isPrimary"
                                                class="block text-sm/6 font-medium text-gray-900 sm:mt-1.5 dark:text-white">
                                                {{ __('products.primary_image_label') }}
                                            </label>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <div class="mt-4 sm:col-span-2 sm:mt-0">
                                                <div class="max-w-lg space-y-6">
                                                    <div class="flex gap-3">
                                                        <div class="flex h-6 shrink-0 items-center">
                                                            <div class="group grid size-4 grid-cols-1">
                                                                <input type="hidden" name="is_primary" value="0" />
                                                                <input id="isPrimary" type="checkbox" name="is_primary"
                                                                    value="1" {{ old('is_primary') == true ? 'checked' : '' }} aria-describedby="comments-description"
                                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 dark:border-white/10 dark:bg-white/5 dark:checked:border-indigo-500 dark:checked:bg-indigo-500 dark:indeterminate:border-indigo-500 dark:indeterminate:bg-indigo-500 dark:focus-visible:outline-indigo-500 dark:disabled:border-white/5 dark:disabled:bg-white/10 dark:disabled:checked:bg-white/10 forced-colors:appearance-auto" />
                                                                <svg viewBox="0 0 14 14" fill="none"
                                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25 dark:group-has-disabled:stroke-white/25">
                                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                                    <path d="M3 7H11" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="text-sm/6">
                                                            <label for="isPrimary"
                                                                class="font-medium text-gray-900 dark:text-white">{{ __('products.primary_image_label') }}</label>
                                                            <p id="isPrimary-description"
                                                                class="text-gray-500 dark:text-gray-400">
                                                                {{ __('products.primary_image_description') }}
                                                            </p>
                                                            <x-form.error name="is_primary" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function previewImage(event) {
                                        const file = event.target.files[0];

                                        if (!file) return;

                                        const img = document.getElementById('productImagePreview');

                                        img.src = URL.createObjectURL(file);
                                    }
                                </script>
                            </div>

                            <!-- Action buttons -->
                            <div class="shrink-0 border-t border-gray-200 px-4 py-5 sm:px-6 dark:border-white/10">
                                <div class="flex justify-end space-x-3">
                                    <button type="button" command="close" commandfor="add-image"
                                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-gray-100 dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">{{ __('common.cancel') }}</button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">{{ __('common.create') }}</button>
                                </div>
                            </div>
                        </form>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
    </div>

<script>
const I18N = {!! \Illuminate\Support\Js::from([
    'variant_name_placeholder' => __('products.variant_name_placeholder'),
    'variant_price_placeholder' => __('products.variant_price_placeholder'),
    'variant_stock_placeholder' => __('products.variant_stock_placeholder'),
    'variant_sku_placeholder' => __('products.variant_sku_placeholder'),
]) !!};

var variantCount = 0;

function syncStockRow() {
    var hasVariants = document.querySelectorAll('.variant-row').length > 0;
    var row   = document.getElementById('product-stock-row');
    var input = document.getElementById('stockQuantity');
    row.style.display   = hasVariants ? 'none' : '';
    input.disabled      = hasVariants;
    if (hasVariants) input.value = '';
}

function addVariantRow(data) {
    data = data || {};
    var idx = variantCount++;
    var row = document.createElement('div');
    row.className = 'variant-row grid grid-cols-12 gap-2 items-center';
    row.innerHTML =
        (data.id ? '<input type="hidden" name="variants[' + idx + '][id]" value="' + data.id + '">' : '') +
        '<div class="col-span-4">' +
            '<input type="text" name="variants[' + idx + '][name]" placeholder="' + I18N.variant_name_placeholder + '" value="' + (data.name || '') + '" required' +
            ' class="block w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10">' +
        '</div>' +
        '<div class="col-span-3">' +
            '<div class="relative"><span class="absolute inset-y-0 left-2.5 flex items-center text-xs text-gray-400">€</span>' +
            '<input type="number" name="variants[' + idx + '][selling_price]" min="0" step="0.01" placeholder="' + I18N.variant_price_placeholder + '" value="' + (data.selling_price !== null && data.selling_price !== undefined ? data.selling_price : '') + '"' +
            ' class="block w-full pl-6 pr-2 py-1.5 rounded-md bg-white text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10"></div>' +
        '</div>' +
        '<div class="col-span-2">' +
            '<input type="number" name="variants[' + idx + '][stock_quantity]" min="0" step="1" placeholder="' + I18N.variant_stock_placeholder + '" value="' + (data.stock_quantity !== null && data.stock_quantity !== undefined ? data.stock_quantity : '') + '"' +
            ' class="block w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10">' +
        '</div>' +
        '<div class="col-span-2">' +
            '<input type="text" name="variants[' + idx + '][sku]" placeholder="' + I18N.variant_sku_placeholder + '" value="' + (data.sku || '') + '"' +
            ' class="block w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10">' +
        '</div>' +
        '<div class="col-span-1 flex justify-end">' +
            '<button type="button" onclick="this.closest(\'.variant-row\').remove(); syncStockRow();" class="rounded-md p-1 text-gray-400 hover:text-red-500 transition-colors">' +
                '<svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>' +
            '</button>' +
        '</div>';
    document.getElementById('variants-list').appendChild(row);
    syncStockRow();
}

// Pre-load existing variants
var existingVariants = @json($product->variants);
existingVariants.forEach(function(v) { addVariantRow(v); });
</script>
</x-layouts.app>