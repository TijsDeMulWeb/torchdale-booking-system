<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Chatbot', 'url' => route('chatbot.show')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div>
            <div class="px-4 sm:px-0">
                <h3 class="text-base/7 font-semibold text-gray-900 dark:text-white">Chatbot Informatie</h3>
                <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">Informatie over de chatbot.
                </p>
            </div>
            <div class="mt-6 border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Naam</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            Torchdale Support
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Prompt</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, eaque. Molestias,
                            voluptate. Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, eaque.
                            Molestias, voluptate.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-layouts.app>