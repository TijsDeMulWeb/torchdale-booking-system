<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('nav.users'), 'url' => route('users.index')],
        ['name' => $user->first_name . ' ' . $user->last_name, 'url' => route('users.edit', $user->id)],
        ['name' => __('common.edit'), 'url' => route('users.edit', $user->id)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <x-users.nav />

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('users.section_title') }}</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">{{ __('users.edit_description', ['name' => $user->first_name . ' ' . $user->last_name]) }}</p>
                    <x-last-updated :model="$user" />
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="firstName"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('users.label_first_name') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="firstName" type="text" name="first_name" placeholder="{{ __('users.label_first_name') }}"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="first_name" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="lastName"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('users.label_last_name') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="lastName" type="text" name="last_name" placeholder="{{ __('users.label_last_name') }}"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="last_name" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="phone"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('users.label_phone') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="phone" type="text" name="phone" placeholder="{{ __('users.label_phone') }}"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="phone" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="email"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('users.label_email') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="email" type="email" name="email" placeholder="{{ __('users.label_email') }}"
                                    value="{{ old('email', $user->email) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-md sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="email" />
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="language"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('nav.language') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="language" name="language"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        <option value="en" {{ old('language', $user->language) == 'en' ? 'selected' : '' }}>
                                            {{ __('users.lang_en') }}
                                        </option>
                                        <option value="nl" {{ old('language', $user->language) == 'nl' ? 'selected' : '' }}>
                                            {{ __('users.lang_nl') }}
                                        </option>
                                        <option value="de" {{ old('language', $user->language) == 'de' ? 'selected' : '' }}>
                                            {{ __('users.lang_de') }}
                                        </option>
                                        <option value="fr" {{ old('language', $user->language) == 'fr' ? 'selected' : '' }}>
                                            {{ __('users.lang_fr') }}
                                        </option>
                                    </select>
                                    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4 dark:text-gray-400">
                                        <path
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="role"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">{{ __('users.label_role') }}</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="grid grid-cols-1 sm:max-w-md">
                                    <select id="role" name="role"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                                        @foreach ($roles as $roleName)
                                            <option value="{{ $roleName }}" {{ old('role', $user->getRoleNames()->first()) == $roleName ? 'selected' : '' }}>
                                                {{ $roleName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4 dark:text-gray-400">
                                        <path
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                </div>
                                <x-form.error name="role" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-form.actions route="users.index" />
        </form>
    </div>
</x-layouts.app>