<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamer', 'url' => route('rooms.index')],
    ]" />
    <x-profile.header :customer="$customer" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="relative min-w-full divide-y divide-white/15">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-white sm:pl-6 lg:pl-8">
                                        ID</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Datum
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Omschrijving Aankoop
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Bedrag
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Status
                                    </th>
                                    <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10 bg-gray-900">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td
                                            class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-white sm:pl-6 lg:pl-8">
                                            {{ $order->id }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-400">
                                            {{ $order->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-400">
                                            {{ $order->orderedItems->pluck('item_name')->join(', ') }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-400">
                                            €{{ number_format($order->total, 2) }}
                                        </td>
                                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-400">
                                            {{ $order->status === 'paid' ? $order->payment_method : $order->status }}
                                        </td>
                                        <td
                                            class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">
                                            <a href="#" class="text-indigo-400 hover:text-indigo-300">Edit<span
                                                    class="sr-only">, {{ $order->id }}</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>