<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Producten', 'url' => route('products.index')],
        ['name' => $product->name, 'url' => route('products.edit', $product->id)],
        ['name' => 'Edit', 'url' => route('products.edit', $product->id)],
    ]" />
    <div class="px-4 py-1 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('products.update', $product->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Product</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over het product {{ $product->name }}.</p>
                    <x-last-updated :model="$product" />
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
                                <button command="show-modal" commandfor="drawer" type="button"
                                    class="mt-1 inline-block text-xs text-gray-500 hover:text-indigo-500 dark:text-gray-400">
                                    Categorie niet gevonden? <span class="text-indigo-600 dark:text-indigo-400">+ Nieuwe
                                        categorie</span>
                                </button>
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
        <div class="px-4 sm:px-0 lg:px-0 my-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
                <h2 class="sr-only">Afbeeldingen</h2>
                @foreach ($product->product_images as $productImage)
                    <div
                        class="relative rounded-lg overflow-hidden bg-gray-50 shadow-xs outline-1 outline-gray-900/5 dark:bg-gray-800/50 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10 flex flex-col">
                        <img class="w-full object-cover" src="{{ $productImage->url }}" alt="Product afbeelding">
                        @if ($productImage->is_primary)
                            <div class="flex-none px-6 py-4">
                                <dt class="sr-only">Status</dt>
                                <dd
                                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 inset-ring inset-ring-green-600/20 dark:bg-green-500/15 dark:text-green-400 dark:inset-ring-green-500/20">
                                    Primary</dd>
                            </div>
                        @endif

                        <div class="border-t border-gray-900/5 px-6 py-6 dark:border-white/5">
                            <a href="{{ route('products.edit', $productImage->id) }}"
                                class="text-sm/6 font-semibold text-gray-900 hover:text-gray-700 dark:text-white dark:hover:text-gray-300">Bewerken
                                <span aria-hidden="true">&rarr;</span></a>
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
                        Nieuwe Afbeelding
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Voeg een nieuwe afbeelding toe
                    </p>
                    <a href="{{ route('escaperoomAddress.create') }}"
                        class="mt-4 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Toevoegen
                    </a>
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
                                                class="text-base font-semibold text-gray-900 dark:text-white">Nieuwe
                                                Categorie</h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Creëer hier een nieuwe
                                                categorie voor aan je product toe te voegen.</p>
                                        </div>
                                        <div class="flex h-7 items-center">
                                            <button type="button" command="close" commandfor="drawer"
                                                class="relative rounded-md text-gray-400 hover:text-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:text-gray-500 dark:hover:text-gray-400">
                                                <span class="absolute -inset-2.5"></span>
                                                <span class="sr-only">Close panel</span>
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
                                                class="block text-sm/6 font-medium text-gray-900 sm:mt-1.5 dark:text-white">Categorie
                                                Naam</label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <input id="categoryName" type="text" name="name"
                                                placeholder="Categorie Naam" value="{{ old('name') }}"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus-visible:outline-indigo-500" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action buttons -->
                            <div class="shrink-0 border-t border-gray-200 px-4 py-5 sm:px-6 dark:border-white/10">
                                <div class="flex justify-end space-x-3">
                                    <button type="button" command="close" commandfor="drawer"
                                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:inset-ring-white/20 dark:hover:bg-white/20">Annuleren</button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Aanmaken</button>
                                </div>
                            </div>
                        </form>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
    </div>
</x-layouts.app>