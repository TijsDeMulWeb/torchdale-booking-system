<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('categories.breadcrumb_plural'), 'url' => route('categories.index')],
        ['name' => $category->name, 'url' => route('categories.edit', $category->id)],
        ['name' => __('common.edit'), 'url' => route('categories.edit', $category->id)],
    ]" />
    <div class="px-4 py-1 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('categories.update', $category->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('categories.edit_title') }}</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">{{ __('categories.edit_description', ['name' => $category->name]) }}</p>
                    <x-last-updated :model="$category" />
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="name"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('categories.category_name_label') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" placeholder="{{ __('categories.category_name_label') }}"
                                    value="{{ old('name', $category->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="name" />
                            </div>
                        </div>
                        <x-form.actions route="categories.index" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>