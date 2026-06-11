<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('nav.users'), 'url' => route('users.index')],
        ['name' => __('nav.roles'), 'url' => route('roles.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <x-users.nav />

        <x-page-header :title="__('nav.roles')" :create="route('roles.create')" createTitle="{{ __('roles.create_button') }}"
            count="{{ $roles->count() }}" countLabel="{{ Str::lower(__('roles.index_title')) }}" />

        <ul role="list" class="mt-3 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($roles as $role)
                <li
                    class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow-sm dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                    <div class="flex w-full items-center justify-between space-x-6 p-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $role->name }}
                                </h3>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ trans_choice('roles.permissions_count', $role->permissions_count, ['count' => $role->permissions_count]) }}
                                &middot;
                                {{ trans_choice('roles.users_count', $role->users_count, ['count' => $role->users_count]) }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="-mt-px flex divide-x divide-gray-200 dark:divide-white/10">
                            <div class="flex w-0 flex-1">
                                <a href="{{ route('roles.edit', $role) }}"
                                    class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-2 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-indigo-600 hover:bg-gray-50 dark:text-indigo-400 dark:hover:bg-white/5">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 text-indigo-500">
                                        <path
                                            d="M5.433 13.917 4 18l4.083-1.433L16.5 8.15a1.768 1.768 0 0 0-2.5-2.5l-8.567 8.267Z" />
                                    </svg>
                                    {{ __('common.edit') }}
                                </a>
                            </div>
                            @if ($role->name !== 'Admin')
                                <div class="-ml-px flex w-0 flex-1">
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative inline-flex w-full items-center justify-center gap-x-2 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 text-red-500">
                                                <path fill-rule="evenodd"
                                                    d="M8.75 2a.75.75 0 0 0-.75.75V4H5.5a.75.75 0 0 0 0 1.5h.443l.664 9.298A2.25 2.25 0 0 0 8.85 17h2.3a2.25 2.25 0 0 0 2.243-2.202l.664-9.298h.443a.75.75 0 0 0 0-1.5H12V2.75A.75.75 0 0 0 11.25 2h-2.5Zm1.5 2V3.5h-1.5V4h1.5Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ __('common.delete') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-layouts.app>
