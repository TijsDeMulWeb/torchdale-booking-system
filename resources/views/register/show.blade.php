<x-layouts.auth>
    <x-success :message="session('message')" />
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white">{{ __('auth.register_title') }}</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">{{ __('auth.label_company_name') }}</label>
                    <div class="mt-2">
                        <input id="name" type="text" name="name" autocomplete="name" value="{{ old('name') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="name" />
                </div>
                <div>
                    <label for="phone"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">{{ __('auth.label_phone') }}</label>
                    <div class="mt-2">
                        <input id="phone" type="text" name="phone" autocomplete="phone" value="{{ old('phone') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="phone" />
                </div>
                <div>
                    <label for="email"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">{{ __('auth.label_email') }}</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" autocomplete="email" value="{{ old('email') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="email" />
                </div>
                <div>
                    <label for="vatNumber" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">{{ __('auth.label_vat_number') }}</label>
                    <div class="mt-2">
                        <input id="vatNumber" type="text" name="vat_number" autocomplete="vatNumber"
                            value="{{ old('vat_number') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="vat_number" />
                </div>
                <div>
                    <label for="registrationNumber"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">{{ __('auth.label_registration_number_optional') }}
                    </label>
                    <div class="mt-2">
                        <input id="registrationNumber" type="text" name="registration_number"
                            autocomplete="registrationNumber" value="{{ old('registration_number') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="registration_number" />
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">{{ __('auth.submit_login') }}</button>
                </div>
            </form>
            <p class="mt-10 text-center text-sm/6 text-gray-500 dark:text-gray-400">
                {{ __('auth.already_account_text') }} <a href="{{ route('login') }}"
                    class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('auth.login_link') }}</a>
            </p>
        </div>
    </div>
</x-layouts.auth>