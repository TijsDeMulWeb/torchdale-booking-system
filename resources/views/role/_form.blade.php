@php
    $rolePermissions ??= [];
    $selectedPermissions = old('permissions', $rolePermissions);
@endphp

<div class="space-y-12 sm:space-y-16">
    <div>
        <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('roles.section_title_role') }}</h2>
        <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">{{ __('roles.section_description_role') }}</p>
        <div
            class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                <label for="name"
                    class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('roles.label_name') }}</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <input id="name" type="text" name="name" placeholder="{{ __('roles.placeholder_name') }}"
                        value="{{ old('name', $role->name ?? '') }}"
                        @if (($role->name ?? null) === 'Admin') readonly @endif
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    <x-form.error name="name" />
                </div>
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('roles.section_title_permissions') }}</h2>
        <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">{{ __('roles.section_description_permissions') }}</p>

        <div class="mt-10 grid grid-cols-1 gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($permissionGroups as $group => $permissions)
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('roles.permission_groups')[$group] ?? $group }}</h3>
                    <div class="mt-3 space-y-2">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center gap-2">
                                <input id="permission-{{ Str::slug($permission) }}" type="checkbox" name="permissions[]"
                                    value="{{ $permission }}"
                                    @checked(in_array($permission, $selectedPermissions))
                                    class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-white/10 dark:bg-white/5" />
                                <label for="permission-{{ Str::slug($permission) }}"
                                    class="text-sm text-gray-700 dark:text-gray-300">{{ __('roles.permission_labels')[$permission] ?? $permission }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <x-form.error name="permissions" />
    </div>
</div>
