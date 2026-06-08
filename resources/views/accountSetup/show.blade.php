<x-layouts.auth>
    <x-success :message="session('message')" />
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white">
                Maak je account aan
            </h2>
            <p class="mt-2 text-center text-sm/6 text-gray-500 dark:text-gray-400">
                Welkom <strong class="text-gray-900 dark:text-white">{{ $escaperoom->name }}</strong>! Maak hieronder
                je persoonlijke account aan om in te loggen op het dashboard.
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="{{ route('accountSetup.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="key" value="{{ $key }}" />

                <div>
                    <label for="firstName"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Voornaam</label>
                    <div class="mt-2">
                        <input id="firstName" type="text" name="first_name" autocomplete="given-name"
                            value="{{ old('first_name') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="first_name" />
                </div>

                <div>
                    <label for="lastName"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Achternaam</label>
                    <div class="mt-2">
                        <input id="lastName" type="text" name="last_name" autocomplete="family-name"
                            value="{{ old('last_name') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="last_name" />
                </div>

                <div>
                    <label for="email"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Email</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" autocomplete="email" value="{{ old('email') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="email" />
                </div>

                <div>
                    <label for="phone"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Telefoonnummer <span
                            class="text-gray-400 dark:text-gray-500 font-normal">(optioneel)</span></label>
                    <div class="mt-2">
                        <input id="phone" type="text" name="phone" autocomplete="tel" value="{{ old('phone') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="phone" />
                </div>

                <div>
                    <label for="password"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Wachtwoord</label>
                    <div class="mt-2">
                        <input id="password" type="password" name="password" autocomplete="new-password"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                    <x-form.error name="password" />
                </div>

                <div>
                    <label for="passwordConfirmation"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Bevestig
                        wachtwoord</label>
                    <div class="mt-2">
                        <input id="passwordConfirmation" type="password" name="password_confirmation"
                            autocomplete="new-password"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                        Account aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>
