<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Chatbot', 'url' => route('chatbot.show')],
        ['name' => 'Edit', 'url' => route('chatbot.edit')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        hier komt edit
    </div>
</x-layouts.app>