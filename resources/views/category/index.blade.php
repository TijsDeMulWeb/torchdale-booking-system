<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Categories', 'url' => route('categories.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold text-gray-900 dark:text-white">Categories</h1>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Een lijst van alle categorieën.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-3">
                <a href="{{ route('categories.index') }}"
                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                    Categorie Toevoegen
                </a>
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-100 dark:divide-white/5">
            @foreach ($categories as $category)
                <li class="relative flex justify-between gap-x-6 py-5 items-center">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm/6 font-semibold text-gray-900 dark:text-white">
                                {{ $category->name }}
                            </p>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-x-6">
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm/6 text-gray-900 dark:text-white">
                                Aantal keer assigned: {{ $category->products_count }}
                            </p>
                            <p class="mt-1 text-xs/5 text-gray-500 dark:text-gray-400">
                                Laatst aangepast: {{ $category->updated_at->diffForHumans() }}
                            </p>
                        </div>
                        <el-dropdown class="relative flex-none">
                            <button
                                class="relative block text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white cursor-pointer">
                                <span class="absolute -inset-2.5"></span>
                                <span class="sr-only">Open options</span>
                                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                    class="size-5">
                                    <path
                                        d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                                </svg>
                            </button>
                            <el-menu anchor="bottom end" popover
                                class="w-32 origin-top-right rounded-md bg-white py-2 shadow-lg outline outline-gray-900/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden dark:text-white dark:focus:bg-white/5">Edit
                                    Category<span class="sr-only">, {{ $category->name }}</span></a>
                                <a href="#"
                                    class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden dark:text-white dark:focus:bg-white/5">Verwijder<span
                                        class="sr-only">, {{ $category->name }}</span></a>
                            </el-menu>
                        </el-dropdown>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-layouts.app>