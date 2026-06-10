<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => 'Gebruikers', 'url' => route('users.index')],
        ['name' => 'Rollen & rechten', 'url' => route('roles.index')],
        ['name' => $role->name, 'url' => route('roles.edit', $role)],
    ]" />
    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')
            @include('role._form')
            <x-form.actions route="roles.index" />
        </form>
    </div>
</x-layouts.app>
