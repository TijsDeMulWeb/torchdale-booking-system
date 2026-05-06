<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => Auth()->user()->escaperoom->name, 'url' => route('escaperoom.show')],
        ['name' => $escaperoomAddress->street . ' ' . $escaperoomAddress->house_number, 'url' => route('escaperoom.show')],
        ['name' => 'Edit', 'url' => route('escaperoom.edit')],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">

    </div>
</x-layouts.app>