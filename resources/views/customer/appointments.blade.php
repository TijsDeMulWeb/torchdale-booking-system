<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Kamer', 'url' => route('rooms.index')],
    ]" />
    <x-profile.header :customer="$customer" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />
        <ul role="list" class="divide-y divide-gray-200 dark:divide-white/5">
            @foreach ($appointments as $item)
                <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 dark:hover:bg-white/2.5 sm:px-6 lg:px-8">
                    <div class="flex min-w-0 gap-x-4">
                        <img src="{{ $item->timeslot->room->url ? Storage::url($item->timeslot->room->url) : 'https://placehold.co/400x400' }}"
                            alt=""
                            class="size-12 flex-none rounded-full bg-gray-200 dark:bg-gray-800 outline -outline-offset-1 outline-gray-300 dark:outline-white/10" />
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm/6 font-semibold text-gray-900 dark:text-white">
                                <a href="#">
                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                    {{ $item->timeslot->room->name }}
                                </a>
                            </p>
                            <p class="mt-1 flex text-xs/5 text-gray-600 dark:text-gray-400">
                                <a href="mailto:{{ $item->order->customer_email }}"
                                    class="relative truncate hover:underline">{{ $item->order->customer_email }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-x-4">
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm/6 text-gray-900 dark:text-white">Datum Afspraak: {{ $item->timeslot->start_time->format('d-m-Y H:i') }}</p>
                            <p class="mt-1 text-xs/5 text-gray-600 dark:text-gray-400">Geboekt op: {{ $item->order->created_at->format('d-m-Y H:i') }}</p>
                        </div>
                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                            class="size-5 flex-none text-gray-400 dark:text-gray-500">
                            <path
                                d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" fill-rule="evenodd" />
                        </svg>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-layouts.app>
