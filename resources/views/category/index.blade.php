<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Categories', 'url' => route('categories.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8">
        <ul role="list" class="divide-y divide-gray-100 dark:divide-white/5">
            @foreach ($categories as $category)
                <li class="relative flex justify-between gap-x-6 py-5 items-center">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm/6 font-semibold text-gray-900 dark:text-white">
                                <a href="#">
                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                    {{ $category->name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-x-4">
                        <div class="hidden sm:flex sm:flex-col sm:items-end justify-center">
                            <p class="text-sm/6 text-gray-900 dark:text-white">
                                Aantal keer assigned: {{ $category->products_count }}
                            </p>
                            <p class="mt-1 text-xs/5 text-gray-500 dark:text-gray-400">
                                Laatst aangepast: {{ $category->updated_at->diffForHumans() }}
                            </p>
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