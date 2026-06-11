<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('nav.rooms'), 'url' => route('rooms.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        @if ($rooms->count() > 0)
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('nav.rooms') }}</h1>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ __('rooms.description') }}</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-3">
                        <a href="{{ route('rooms.create') }}"
                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                            {{ __('rooms.add_room') }}
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
                                            {{ __('customers.table_name') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('rooms.table_duration') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('rooms.address') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('rooms.table_min_age') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('rooms.table_active_from') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ __('rooms.table_color') }}</th>
                                        <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                                            <span class="sr-only">{{ __('common.actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-900">
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td
                                                class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6 lg:pl-8 dark:text-white">
                                                {{ $room->name }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ __('rooms.duration_minutes', ['duration' => $room->duration]) }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $room->escaperoomAddress->full_address }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ __('rooms.min_age_years', ['age' => $room->min_age]) }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $room->active_from->format('d-m-Y') }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                <span class="inline-block w-3 h-3 rounded-full"
                                                    style="background-color: {{ $room->color }}"></span>
                                            </td>
                                            <td
                                                class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">
                                                <div class="flex items-center justify-end gap-4">
                                                    <a href="{{ route('rooms.edit', $room->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        {{ __('rooms.edit') }}
                                                        <span class="sr-only">, {{ $room->name }}</span>
                                                    </a>
                                                    <a href="{{ route('rooms.prices.show', $room->id) }}"
                                                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                                        {{ __('rooms.prices') }}
                                                        <span class="sr-only">, {{ $room->name }}</span>
                                                    </a>
                                                    <a href="{{ route('rooms.timeslots.show', $room->id) }}"
                                                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                                        {{ __('rooms.timeslots') }}
                                                        <span class="sr-only">, {{ $room->name }}</span>
                                                    </a>
                                                    <form method="POST" action="{{ route('rooms.destroy', $room->id) }}">
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
            </div>
        @else
            <x-empty-state :name="__('common.noun_room')" :route="route('rooms.create')" />
        @endif
        {{ $rooms->links() }}
    </div>
</x-layouts.app>