<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Chatbot', 'url' => route('chatbot.show')],
        ['name' => 'Edit', 'url' => route('chatbot.edit')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form  method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Chatbot Informatie</h2>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Informatie over de chatbot.</p>
                    <div
                        class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:border-t-gray-900/10 sm:pb-0 dark:border-white/10 dark:sm:divide-white/10 dark:sm:border-t-white/10">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="username"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Naam</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input id="name" type="text" name="name" value="{{ old('name', $chatbot->name) }}"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500" />
                            </div>
                            <x-form.error name="name" />
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="about"
                                class="block text-sm/6 font-medium text-gray-900 sm:pt-1.5 dark:text-white">Prompt</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <textarea id="prompt" name="prompt" rows="20"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:max-w-2xl sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500">{{ old('prompt', $chatbot->prompt) }}</textarea>
                                <p class="mt-3 text-sm/6 text-gray-600 dark:text-gray-400">Probeer een zo duidelijk mogelijk prompt te schrijven. Liefst in het Engels</p>
                            </div>
                        </div>

                        {{-- <div class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4 sm:py-6">
                            <label for="photo"
                                class="block text-sm/6 font-medium text-gray-900 dark:text-white">Photo</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex items-center gap-x-3">
                                    <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="size-12 text-gray-300 dark:text-gray-500">
                                        <path
                                            d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                    <button type="button"
                                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">Change</button>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('chatbot.show') }}" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Annuleren</a>
                <button type="submit"
                    class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Opslaan</button>
            </div>
        </form>

    </div>
</x-layouts.app>