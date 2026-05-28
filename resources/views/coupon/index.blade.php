<x-layouts.app>
    <x-success :message="session('message')" />
    <x-error name="message" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kortingsbonnen', 'url' => route('coupons.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        @if ($coupons->count() > 0)
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900 dark:text-white">Kortingsbonnen</h1>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Een lijst van alle kortingsbonnen.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-3">
                        <a href="{{ route('coupons.index') }}"
                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                            Kortingsbon Toevoegen
                        </a>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8 dark:text-white">
                                            Naam</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            Korting</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            Geldig van</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            Geldig tot</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            Code</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            Keer gebruikt</th>
                                        <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                                            <span class="sr-only">Acties</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-900">
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td
                                                class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6 lg:pl-8 dark:text-white">
                                                {{ $coupon->name }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                @if (!empty($coupon->discount_type))
                                                    @if ($coupon->discount_type == 'fixed')
                                                        &euro;{{ number_format($coupon->discount_amount, 2) }}
                                                    @endif
                                                    @if ($coupon->discount_type == 'percentage')
                                                        {{ number_format($coupon->discount_value, 0) }}%
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->valid_from->format('d-m-Y') }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->valid_to ?? 'Altijd geldig' }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->code }}
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->times_used }}
                                            </td>
                                            <td
                                                class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">

                                                <div class="flex items-center justify-end gap-4">

                                                    <a href="{{ route('products.edit', $coupon->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        Wijzigen
                                                        <span class="sr-only">, {{ $coupon->name }}</span>
                                                    </a>

                                                    <form method="POST" action="{{ route('products.destroy', $coupon->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 cursor-pointer hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                            Verwijderen
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <x-empty-state name='product' :route="route('products.create')" />
        @endif
        {{ $coupons->links() }}
    </div>
</x-layouts.app>