<x-layouts.app>
    <x-success :message="session('message')" />
    <x-error name="message" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Profiel: ' . $user->first_name . ' ' . $user->last_name, 'url' => route('escaperoom.show')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="divide-y divide-gray-200 dark:divide-white/10">
            <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Persoonlijke Informatie</h2>
                </div>

                <form class="md:col-span-2" method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                        <div class="col-span-full flex items-center gap-x-8">
                            <img id="profilePicturePreview"
                                src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://placehold.co/400x400' }}"
                                alt="Profile picture"
                                class="size-24 flex-none rounded-lg bg-gray-100 object-cover outline -outline-offset-1 outline-black/5 dark:bg-gray-800 dark:outline-white/10" />
                            <input id="profilePicture" name="profile_picture" type="file" class="hidden" onchange="previewLogo(event)">

                            <button type="button" onclick="document.getElementById('profilePicture').click()"
                                class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring-1 inset-ring-gray-300 hover:bg-gray-100 dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">Aanpassen</button>
                            <p class="mt-2 text-xs/5 text-gray-500 dark:text-gray-400">JPG, GIF or PNG. 1MB max.</p>
                            <x-form.error name="profile_picture" />
                        </div>
                        <script>
                            function previewLogo(event) {
                                const file = event.target.files[0];
                                if (!file) return;

                                const img = document.querySelector('#profilePicturePreview');
                                img.src = URL.createObjectURL(file);
                            }
                        </script>

                        <div class="sm:col-span-3">
                            <label for="firstName"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Voornaam</label>
                            <div class="mt-2">
                                <input id="firstName" type="text" name="first_name" autocomplete="given-name"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="first_name" />
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="lastName"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Achternaam</label>
                            <div class="mt-2">
                                <input id="lastName" type="text" name="last_name" autocomplete="family-name"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="last_name" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="email"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Email</label>
                            <div class="mt-2">
                                <input id="email" type="email" name="email" autocomplete="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="email" />
                            </div>
                        </div>
                        <div class="col-span-full">
                            <label for="phone"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Telefoonnummer</label>
                            <div class="mt-2">
                                <input id="phone" type="tel" name="phone" autocomplete="tel"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="phone" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex">
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Opslaan</button>
                    </div>
                </form>
            </div>

            <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Wijzig wachtwoord</h2>
                    <p class="mt-1 text-sm/6 text-gray-500 dark:text-gray-400">Update jouw wachtwoord voor jouw account
                        hier.</p>
                </div>

                <form class="md:col-span-2" method="POST" action="{{ route('profile.password', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                        <div class="col-span-full">
                            <label for="currentPassword"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Huidig
                                wachtwoord</label>
                            <div class="mt-2">
                                <input id="currentPassword" type="password" name="current_password"
                                    autocomplete="current-password"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="current_password" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="newPassword"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Nieuw
                                wachtwoord</label>
                            <div class="mt-2">
                                <input id="newPassword" type="password" name="new_password" autocomplete="new-password"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="new_password" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="confirmPassword"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Bevestig
                                wachtwoord</label>
                            <div class="mt-2">
                                <input id="confirmPassword" type="password" name="confirm_password"
                                    autocomplete="new-password"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                                <x-form.error name="confirm_password" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex">
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Opslaan</button>
                    </div>
                </form>
            </div>

            <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Verwijder account</h2>
                    <p class="mt-1 text-sm/6 text-gray-500 dark:text-gray-400">Geen nood meer aan torchdaleplanner? Je
                        kan jouw account hier verwijderen. Deze actie is niet omkeerbaar. Alle informatie gerelateerd
                        tot dit account zal permanent verwijderd worden.</p>
                </div>

                <form class="flex items-start md:col-span-2" method="POST"
                    action="{{ route('profile.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 dark:bg-red-500 dark:shadow-none dark:hover:bg-red-400">Ja,
                        verwijder mijn account</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>