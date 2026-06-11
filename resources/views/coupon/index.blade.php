<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('coupons.breadcrumb_plural'), 'url' => route('coupons.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('coupons.breadcrumb_plural') }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                        {{ __('coupons.description') }}
                    </p>
                </div>

                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex items-center gap-3">

                    {{-- Search field --}}
                    <form method="GET" action="{{ route('coupons.index') }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('coupons.search_placeholder') }}"
                            class="w-64 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 py-2 pl-10 pr-4 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" />

                        {{-- Search icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.25 11.25Z" />
                        </svg>
                    </form>

                    <a href="{{ route('coupons.create') }}"
                        class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                        {{ __('coupons.add_coupon') }}
                    </a>
                </div>
            </div>
            @if ($coupons->count() > 0)

                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8 dark:text-white">
                                            {{ __('customers.table_name') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('coupons.table_discount') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('coupons.table_valid_from') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('coupons.table_valid_to') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('coupons.table_code') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('coupons.table_times_used') }}</th>
                                        <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                                            <span class="sr-only">{{ __('common.actions') }}</span>
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
                                                        {{ Number::currency($coupon->discount_value) }}
                                                    @endif
                                                    @if ($coupon->discount_type == 'percentage')
                                                        {{ Number::percentage($coupon->discount_value) }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->valid_from->format('d-m-Y') }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->valid_to ?? __('coupons.always_valid') }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->code }}
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $coupon->times_used }}
                                            </td>
                                            <td
                                                class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">

                                                <div class="flex items-center justify-end gap-4">

                                                    <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        {{ __('common.edit') }}
                                                        <span class="sr-only">, {{ $coupon->name }}</span>
                                                    </a>

                                                    <form method="POST" action="{{ route('coupons.destroy', $coupon->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 cursor-pointer hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                            {{ __('common.delete') }}
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
            @else
                <x-empty-state :name="__('common.noun_coupon')" :route="route('coupons.create')" />
            @endif
            {{ $coupons->links() }}
        </div>

    </div>
</x-layouts.app>