<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('customers.breadcrumb_singular'), 'url' => route('customers.index')],
        ['name' => $customer->full_name, 'url' => route('customers.show.overview', $customer)],
    ]" />
    <x-profile.header :customer="$customer" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />

        @if ($vouchers->isEmpty())
            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('customers.no_giftcards') }}</p>
        @else
            <div class="mt-3 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-white/15">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">{{ __('customers.table_code') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('customers.table_giftcard') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('customers.table_value') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('customers.table_source') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('customers.table_delivery') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('customers.table_valid_until') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('customers.table_created') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('customers.table_status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-gray-900">
                                @foreach ($vouchers as $voucher)
                                    @php
                                        $isExpired = $voucher->valid_until && $voucher->valid_until->isPast() && $voucher->status === 'active';
                                    @endphp
                                    <tr>
                                        <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap sm:pl-6 lg:pl-8">
                                            <span class="font-mono tracking-widest text-gray-900 dark:text-white select-all">{{ $voucher->code }}</span>
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            {{ $voucher->giftCard->name ?? '—' }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                            {{ Number::currency($voucher->amount) }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap">
                                            @if ($voucher->source === 'cancellation')
                                                <span class="inline-flex items-center rounded-md bg-orange-50 dark:bg-orange-900/20 px-2 py-1 text-xs font-medium text-orange-700 dark:text-orange-400 ring-1 ring-inset ring-orange-600/20">{{ __('customers.source_cancellation') }}</span>
                                            @elseif ($voucher->source === 'manual')
                                                <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">{{ __('customers.source_manual') }}</span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/20 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-400 ring-1 ring-inset ring-blue-600/20">{{ __('customers.source_purchase') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap">
                                            @php
                                                $delivery = match($voucher->delivery_method) {
                                                    'post'   => ['label' => __('customers.delivery_post'),  'class' => 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 ring-purple-600/20'],
                                                    'pickup' => ['label' => __('customers.delivery_pickup'),   'class' => 'bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 ring-teal-600/20'],
                                                    default  => ['label' => __('customers.delivery_email'),    'class' => 'bg-sky-50 dark:bg-sky-900/20 text-sky-700 dark:text-sky-400 ring-sky-600/20'],
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $delivery['class'] }}">
                                                {{ $delivery['label'] }}
                                            </span>
                                            @if ($voucher->delivery_method === 'post' && $voucher->shipping_cost > 0)
                                                <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">
                                                    + {{ Number::currency($voucher->shipping_cost) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            @if ($voucher->valid_until)
                                                <span class="{{ $isExpired ? 'text-red-500 dark:text-red-400' : '' }}">
                                                    {{ $voucher->valid_until->format('d/m/Y') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            {{ $voucher->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap">
                                            @if ($isExpired)
                                                <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">{{ __('common.status_expired') }}</span>
                                            @elseif ($voucher->status === 'used')
                                                <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">
                                                    {{ __('common.status_redeemed') }}
                                                    @if ($voucher->used_at)
                                                        <span class="ml-1 text-gray-400">{{ $voucher->used_at->format('d/m/Y') }}</span>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">{{ __('common.status_active') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
