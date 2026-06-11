<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('categories.breadcrumb_plural'), 'url' => route('categories.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('categories.breadcrumb_plural') }}</h1>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ __('categories.description') }}</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-3">
                <button command="show-modal" commandfor="drawer" type="button"
                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                    {{ __('categories.add_category') }}
                </button>
            </div>
        </div>
        @if($categories->count() > 0)
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
                                    {{ __('categories.assigned_count', ['count' => $category->products_count]) }}
                                </p>
                                <p class="mt-1 text-xs/5 text-gray-500 dark:text-gray-400">
                                    {{ __('categories.last_modified', ['date' => $category->updated_at->diffForHumans()]) }}
                                </p>
                            </div>
                            <el-dropdown class="relative flex-none">
                                <button
                                    class="relative block text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white cursor-pointer">
                                    <span class="absolute -inset-2.5"></span>
                                    <span class="sr-only">{{ __('common.open_options') }}</span>
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="size-5">
                                        <path
                                            d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                                    </svg>
                                </button>
                                <el-menu anchor="bottom end" popover
                                    class="w-32 origin-top-right rounded-md bg-white py-2 shadow-lg outline outline-gray-900/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden dark:text-white dark:focus:bg-white/5">{{ __('categories.edit_category') }}<span class="sr-only">, {{ $category->name }}</span></a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full px-3 py-1 text-left text-sm/6 text-gray-900 hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden dark:text-white dark:hover:bg-white/5 dark:focus:bg-white/5">
                                            {{ __('categories.delete_category') }}
                                            <span class="sr-only">, {{ $category->name }}</span>
                                        </button>
                                    </form>
                                </el-menu>
                            </el-dropdown>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <x-empty-state :name="__('common.noun_category')" />
        @endif
        {{ $categories->links() }}
        <el-dialog>
            <dialog id="drawer" aria-labelledby="drawer-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-hidden bg-transparent backdrop:bg-transparent">
                <div tabindex="0" class="absolute inset-0 pl-10 focus:outline-none sm:pl-16">
                    <el-dialog-panel
                        class="ml-auto block size-full max-w-2xl transform transition duration-500 ease-in-out data-closed:translate-x-full sm:duration-700">
                        <form method="POST" action="{{ route('categories.store') }}"
                            class="relative flex h-full flex-col overflow-y-auto bg-white shadow-xl dark:bg-gray-900">
                            @csrf
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="bg-gray-50 px-4 py-6 sm:px-6 dark:bg-gray-800">
                                    <div class="flex items-start justify-between space-x-3">
                                        <div class="space-y-1">
                                            <h2 id="drawer-title"
                                                class="text-base font-semibold text-gray-900 dark:text-white">{{ __('categories.new_category_title') }}</h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('categories.new_category_description') }}</p>
                                        </div>
                                        <div class="flex h-7 items-center">
                                            <button type="button" command="close" commandfor="drawer"
                                                class="relative rounded-md text-gray-400 hover:text-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:text-gray-500 dark:hover:text-gray-400">
                                                <span class="absolute -inset-2.5"></span>
                                                <span class="sr-only">{{ __('common.close_panel') }}</span>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                                                    class="size-6">
                                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Divider container -->
                                <div
                                    class="space-y-6 py-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0 dark:sm:divide-white/10">
                                    <!-- Category name -->
                                    <div
                                        class="space-y-2 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div>
                                            <label for="categoryName"
                                                class="block text-sm/6 font-medium text-gray-900 sm:mt-1.5 dark:text-white">{{ __('categories.category_name_label') }}</label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <input id="categoryName" type="text" name="name"
                                                placeholder="{{ __('categories.category_name_label') }}" value="{{ old('name') }}"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus-visible:outline-indigo-500" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action buttons -->
                            <div class="shrink-0 border-t border-gray-200 px-4 py-5 sm:px-6 dark:border-white/10">
                                <div class="flex justify-end space-x-3">
                                    <button type="button" command="close" commandfor="drawer"
                                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:inset-ring-white/20 dark:hover:bg-white/20">{{ __('common.cancel') }}</button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">{{ __('common.create') }}</button>
                                </div>
                            </div>
                        </form>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
    </div>
</x-layouts.app>