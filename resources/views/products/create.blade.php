<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Producten', 'url' => route('products.index')],
        ['name' => 'Creëren', 'url' => route('products.create')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Product</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Deze informatie bevat alle info
                        over het product.</p>
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Product
                                Naam</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="Product Naam"
                                    value="{{ old('name') }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="sku"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">SKU</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="sku" type="text" name="sku" placeholder="SKU" value="{{ old('sku') }}"
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
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    Categorie niet gevonden? <span
                                        class="text-indigo-600 dark:text-indigo-400 cursor-pointer">+ Nieuwe
                                        categorie</span>
                                </button>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="about"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Details</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <textarea id="details" name="details" rows="10"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">{{ old('details') }}</textarea>
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
                                    value="{{ old('cost_price') }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="cost_price" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="sellingPrice"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Verkoopprijs</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="sellingPrice" type="text" name="selling_price" placeholder="Verkoopprijs"
                                    value="{{ old('selling_price') }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="selling_price" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6" id="variants-section">
                            <div class="sm:pt-1.5">
                                <label class="block text-sm/6 font-medium text-gray-900 dark:text-white">Variaties</label>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Bijv. maat S, M, L of kleur Rood, Blauw. Laat leeg als er geen variaties zijn.</p>
                            </div>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div id="variants-list" class="space-y-2 mb-3"></div>
                                <button type="button" onclick="addVariantRow()"
                                    class="inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 border border-indigo-300 dark:border-indigo-500/40 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Variatie toevoegen
                                </button>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Verzendkosten</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label for="shippingCostDomestic" class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Binnenland</label>
                                        <input id="shippingCostDomestic" type="text" name="shipping_cost_domestic" placeholder="0.00"
                                            value="{{ old('shipping_cost_domestic', '0.00') }}"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                        <x-form.error name="shipping_cost_domestic" />
                                    </div>
                                    <div class="flex-1">
                                        <label for="shippingCostInternational" class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Internationaal</label>
                                        <input id="shippingCostInternational" type="text" name="shipping_cost_international" placeholder="0.00"
                                            value="{{ old('shipping_cost_international', '0.00') }}"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                        <x-form.error name="shipping_cost_international" />
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Binnenland = zelfde land als het escaperoom adres. Laat 0 als er geen verzendkosten zijn.</p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="vatPercentage"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">BTW-percentage</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="vatPercentage" type="text" name="vat_percentage" placeholder="BTW-percentage"
                                    value="{{ old('vat_percentage') }}"
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
                                        <option value="" {{ old('discount_type') === null ? 'selected' : '' }}>Geen
                                            Korting</option>
                                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>
                                            Fixed</option>
                                        <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Percentage
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
                                    value="{{ old('discount_value') }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="discount_value" />
                            </div>
                        </div>
                        <div id="product-stock-row" class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="stockQuantity"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Stock</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="stockQuantity" type="text" name="stock_quantity" placeholder="Stock"
                                    value="{{ old('stock_quantity') }}"
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
                                    value="{{ old('available_from', now()->format('Y-m-d')) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                <x-form.error name="available_from" />
                            </div>
                        </div>
                        <x-form.actions route="products.index" />
                    </div>
                </div>
            </div>
        </form>
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

<script>
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
            '<input type="text" name="variants[' + idx + '][name]" placeholder="Naam (bijv. S, M, L)" value="' + (data.name || '') + '" required' +
            ' class="block w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10">' +
        '</div>' +
        '<div class="col-span-3">' +
            '<div class="relative"><span class="absolute inset-y-0 left-2.5 flex items-center text-xs text-gray-400">€</span>' +
            '<input type="number" name="variants[' + idx + '][selling_price]" min="0" step="0.01" placeholder="Prijs (leeg = product)" value="' + (data.selling_price !== null && data.selling_price !== undefined ? data.selling_price : '') + '"' +
            ' class="block w-full pl-6 pr-2 py-1.5 rounded-md bg-white text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10"></div>' +
        '</div>' +
        '<div class="col-span-2">' +
            '<input type="number" name="variants[' + idx + '][stock_quantity]" min="0" step="1" placeholder="Stock" value="' + (data.stock_quantity !== null && data.stock_quantity !== undefined ? data.stock_quantity : '') + '"' +
            ' class="block w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/5 dark:text-white dark:outline-white/10">' +
        '</div>' +
        '<div class="col-span-2">' +
            '<input type="text" name="variants[' + idx + '][sku]" placeholder="SKU" value="' + (data.sku || '') + '"' +
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
</script>
</x-layouts.app>