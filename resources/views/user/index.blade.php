<x-layouts.app>
    <x-success :message="session('message')" />
    <x-error name="message" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Gebruikers', 'url' => route('users.index')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($users as $user)
                <li
                    class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow-sm dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                    <div class="flex w-full items-center justify-between space-x-6 p-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </h3>
                                <span
                                    class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 inset-ring inset-ring-green-600/20 dark:bg-green-500/10 dark:text-green-500 dark:inset-ring-green-500/10">{{ $user->getRoleNames()->first() }}</span>
                            </div>
                            </p>
                        </div>
                        <img src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : 'https://placehold.co/400x400' }}"
                            alt="Profile picture of {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" class=" size-10 shrink-0 rounded-full bg-gray-300 outline -outline-offset-1 outline-black/5
                                                                    dark:bg-gray-700 dark:outline-white/10" />
                    </div>
                    <div>
                        <div class="-mt-px flex divide-x divide-gray-200 dark:divide-white/10">
                            @if ($user->phone)
                                <div class="-ml-px flex w-0 flex-1">
                                    <a href="tel:{{ $user->phone }}"
                                        class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                            class="size-5 text-gray-400 dark:text-gray-500">
                                            <path
                                                d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z"
                                                clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                        Bellen
                                    </a>
                                </div>
                            @endif
                            <div class="flex w-0 flex-1">
                                <a href="{{ route('users.edit', $user) }}"
                                    class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-2 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-indigo-600 hover:bg-gray-50 dark:text-indigo-400 dark:hover:bg-white/5">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 text-indigo-500">
                                        <path
                                            d="M5.433 13.917 4 18l4.083-1.433L16.5 8.15a1.768 1.768 0 0 0-2.5-2.5l-8.567 8.267Z" />
                                    </svg>
                                    Bewerken
                                </a>
                            </div>
                            <div class="-ml-px flex w-0 flex-1">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="relative inline-flex w-full items-center justify-center gap-x-2 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 text-red-500">
                                            <path fill-rule="evenodd"
                                                d="M8.75 2a.75.75 0 0 0-.75.75V4H5.5a.75.75 0 0 0 0 1.5h.443l.664 9.298A2.25 2.25 0 0 0 8.85 17h2.3a2.25 2.25 0 0 0 2.243-2.202l.664-9.298h.443a.75.75 0 0 0 0-1.5H12V2.75A.75.75 0 0 0 11.25 2h-2.5Zm1.5 2V3.5h-1.5V4h1.5Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        {{ $users->links() }}
    </div>
</x-layouts.app>