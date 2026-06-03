<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Klant', 'url' => route('customers.index')],
        ['name' => $customer->full_name, 'url' => route('customers.show.overview', $customer)],
    ]" />
    <x-profile.header :customer="$customer" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />
        <ul role="list" class="divide-y divide-white/5">
            <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-white/2.5 sm:px-6 lg:px-8">
                <div class="flex min-w-0 gap-x-4">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt=""
                        class="size-12 flex-none rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm/6 font-semibold text-white">
                            <a href="#">
                                <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                Leslie Alexander
                            </a>
                        </p>
                        <p class="mt-1 flex text-xs/5 text-gray-400">
                            <a href="mailto:leslie.alexander@example.com"
                                class="relative truncate hover:underline">leslie.alexander@example.com</a>
                        </p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-x-4">
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm/6 text-white">Co-Founder / CEO</p>
                        <p class="mt-1 text-xs/5 text-gray-400">Last seen <time datetime="2023-01-23T13:23Z">3h
                                ago</time></p>
                    </div>
                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                        class="size-5 flex-none text-gray-500">
                        <path
                            d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" fill-rule="evenodd" />
                    </svg>
                </div>
            </li>
        </ul>
    </div>
</x-layouts.app>