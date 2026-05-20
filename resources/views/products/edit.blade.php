<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Producten', 'url' => route('products.index')],
        ['name' => $product->name, 'url' => route('products.edit', $product->id)],
        ['name' => 'Edit', 'url' => route('products.edit', $product->id)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('products.update', $product->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Product</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over het product {{ $product->name }}.</p>
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Product
                                Naam</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="Product Naam"
                                    value="{{ old('name', $product->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="sku"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">SKU</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="sku" type="text" name="sku" placeholder="SKU"
                                    value="{{ old('sku', $product->sku) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="sku" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="categoryId"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Categorie</label>
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
                                <a href="{{ route('products.index') }}"
                                    class="mt-1 inline-block text-xs text-gray-500 hover:text-indigo-500 dark:text-gray-400">
                                    Categorie niet gevonden? <span class="text-indigo-600 dark:text-indigo-400">+ Nieuwe
                                        categorie</span>
                                </a>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="about"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Details</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <textarea id="details" name="details" rows="10"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">{{ old('details', $product->details) }}</textarea>
                                <p class="mt-3 text-sm/6 text-gray-600 dark:text-gray-400">Beschrijf het product
                                    gedetailleerd.</p>
                                <x-form.error name="details" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="costPrice"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Inkoopprijs</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="costPrice" type="text" name="cost_price" placeholder="Inkoopprijs"
                                    value="{{ old('cost_price', $product->cost_price) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="cost_price" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="sellingPrice"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Verkoopprijs</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="sellingPrice" type="text" name="selling_price" placeholder="Verkoopprijs"
                                    value="{{ old('selling_price', $product->selling_price) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="selling_price" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="vatPercentage"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">BTW-percentage</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="vatPercentage" type="text" name="vat_percentage" placeholder="BTW-percentage"
                                    value="{{ old('vat_percentage', $product->vat_percentage) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="vat_percentage" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="discountType"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Kortings
                                Type</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="discountType" name="discount_type"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        <option value="" {{ old('discount_type', $product->discount_type) === null ? 'selected' : '' }}>Geen Korting</option>
                                        <option value="fixed" {{ old('discount_type', $product->discount_type) === 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ old('discount_type', $product->discount_type) === 'percentage' ? 'selected' : '' }}>Percentage
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
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Kortingswaarde</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="discountValue" type="text" name="discount_value" placeholder="Kortingswaarde"
                                    value="{{ old('discount_value', $product->discount_value) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="discount_value" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="stockQuantity"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Stock</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="stockQuantity" type="text" name="stock_quantity" placeholder="Stock"
                                    value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="stock_quantity" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="availableFrom"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Beschikbaar
                                vanaf</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="availableFrom" type="date" name="available_from"
                                    value="{{ old('available_from', $product->available_from?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="available_from" />
                            </div>
                        </div>

                        <div class="my-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('products.index') }}"
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