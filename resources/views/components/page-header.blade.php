@props([
    'title' => 'required',
    'create' => 'required',
    'createTitle' => 'Create',
    'count' => null,
])

<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight dark:text-white">
                {{ $title }}
            </h2>

            @if(!is_null($count))
                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-sm font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    {{ $count }} gebruikers
                </span>
            @endif
        </div>
    </div>

    <div class="mt-4 flex md:mt-0 md:ml-4">
        <a href="{{ $create }}"
           class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
            {{ $createTitle }}
        </a>
    </div>
</div>