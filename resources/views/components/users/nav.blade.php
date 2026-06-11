@php
    $tabs = [
        ['route' => 'users.index', 'pattern' => ['users.index', 'users.create', 'users.edit'], 'label' => __('nav.users'), 'permission' => 'view users'],
        ['route' => 'roles.index', 'pattern' => ['roles.index', 'roles.create', 'roles.edit'], 'label' => __('nav.roles'), 'permission' => 'view roles'],
    ];
    $tabs = array_filter($tabs, fn ($tab) => auth()->user()->can($tab['permission']));
@endphp

<div class="mb-6 border-b border-gray-200 dark:border-white/10">
    <nav class="-mb-px flex space-x-8">
        @foreach ($tabs as $tab)
            <a href="{{ route($tab['route']) }}" @class([
                'border-b-2 px-1 pb-4 text-sm font-medium whitespace-nowrap',
                'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' => request()->routeIs($tab['pattern']),
                'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-white/20 dark:hover:text-white' => !request()->routeIs($tab['pattern']),
            ])>
                {{ $tab['label'] }}
            </a>
        @endforeach
    </nav>
</div>
