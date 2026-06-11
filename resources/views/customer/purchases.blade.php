<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('customers.breadcrumb_singular'), 'url' => route('customers.index')],
        ['name' => $customer->full_name, 'url' => route('customers.show.overview', $customer)],
    ]" />
    <x-profile.header :customer="$customer" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6 lg:pl-8">
                                        ID</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ __('dashboard.date') }}
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ __('customers.table_purchase_description') }}
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ __('customers.table_amount') }}
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ __('customers.table_status') }}
                                    </th>
                                    <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                                        <span class="sr-only">{{ __('common.edit') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-gray-900">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td
                                            class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 dark:text-white sm:pl-6 lg:pl-8">
                                            {{ $order->id }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            {{ $order->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $order->orderedItems->pluck('item_name')->join(', ') }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            {{ Number::currency($order->total) }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap">
                                            @if ($order->status === 'paid' && $order->payment_method === 'cash')
                                                <span class="inline-flex items-center gap-1 rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">
                                                    {{ __('common.payment_cash') }}
                                                </span>
                                            @elseif ($order->status === 'paid' && $order->payment_method === 'online')
                                                <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 dark:bg-blue-900/20 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-400 ring-1 ring-inset ring-blue-600/20">
                                                    {{ __('common.payment_online') }}
                                                </span>
                                            @elseif ($order->status === 'paid')
                                                <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">
                                                    {{ __('common.status_paid') }}
                                                </span>
                                            @elseif ($order->status === 'pending')
                                                <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">
                                                    {{ __('common.status_open') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/20">
                                                    {{ $order->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td
                                            class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">
                                            @if ($order->invoice && $order->invoice->pdf_url)
                                                <a href="{{ route('orders.invoice', $order) }}" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('customers.show_invoice') }}<span
                                                        class="sr-only">, {{ $order->id }}</span></a>
                                            @elseif ($order->payment_link)
                                                <a href="{{ route('orders.payment-link', $order) }}" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('customers.show_payment_link') }}<span
                                                        class="sr-only">, {{ $order->id }}</span></a>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-600">{{ __('customers.no_invoice') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>