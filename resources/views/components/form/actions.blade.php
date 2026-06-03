@props(['route', 'params' => []])

<div class="my-6 flex items-center justify-end gap-x-6">
    <a href="{{ route($route, $params) }}" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Annuleren</a>
    <button type="submit"
        class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Opslaan</button>
</div>