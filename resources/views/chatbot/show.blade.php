<x-layouts.app>
    <x-success :message="session('message')" />
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Chatbot', 'url' => route('chatbot.show')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div>
            <div class="px-4 sm:px-0 sm:flex sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">Chatbot Informatie</h3>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">Informatie over de chatbot.</p>
                </div>
                <a href="{{ route('chatbot.edit') }}"
                    class="mt-4 sm:mt-0 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500">
                    Bewerken
                </a>
            </div>
            <div class="mt-6 border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Naam</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $chatbot->name }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Key</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            {{ $setting->escaperoom_api_key }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Prompt</dt>
                        <dd
                            class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400 whitespace-pre-line max-h-64 overflow-y-auto">
                            {{ $chatbot->prompt }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-layouts.app>