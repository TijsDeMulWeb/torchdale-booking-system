<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('nav.settings') . ': ' . auth()->user()->escaperoom->name, 'url' => route('escaperoom.show')],
        ['name' => __('legalDocuments.title'), 'url' => route('legalDocuments.index')],
    ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <div class="px-4 sm:px-0">
            <h1 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('legalDocuments.title') }}</h1>
            <p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark:text-gray-400">{{ __('legalDocuments.description') }}</p>
        </div>

        @foreach (\App\Models\LegalDocument::TYPES as $type)
            @php $documents = $documentsByType[$type]; @endphp
            <div class="mt-10 border-t border-gray-100 dark:border-white/10 pt-8">
                <div class="px-4 sm:px-0 sm:flex sm:items-center sm:justify-between">
                    <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">{{ __('legalDocuments.type_' . $type) }}</h2>
                    <form method="POST" action="{{ route('legalDocuments.store') }}" enctype="multipart/form-data" class="mt-4 sm:mt-0 flex items-end gap-3">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div>
                            <label for="file_{{ $type }}" class="sr-only">{{ __('legalDocuments.file_label') }}</label>
                            <input id="file_{{ $type }}" name="file" type="file" accept="application/pdf"
                                class="block w-full text-sm text-gray-900 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-300 dark:file:bg-white/10 dark:file:text-white dark:hover:file:bg-white/20" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('legalDocuments.file_help') }}</p>
                        </div>
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500">
                            {{ __('legalDocuments.upload_button') }}
                        </button>
                    </form>
                </div>

                @if ($documents->isEmpty())
                    <p class="mt-4 px-4 sm:px-0 text-sm text-gray-500 dark:text-gray-400">{{ __('legalDocuments.no_documents') }}</p>
                @else
                    <ul role="list" class="mt-4 divide-y divide-gray-100 dark:divide-white/10 border-t border-gray-100 dark:border-white/10">
                        @foreach ($documents as $document)
                            <li class="flex items-center justify-between gap-x-6 px-4 py-4 sm:px-0">
                                <div class="flex items-center gap-x-3">
                                    <svg class="size-6 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ __('legalDocuments.version_label', ['version' => $document->version]) }}
                                            @if ($loop->first)
                                                <span class="ml-2 inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20">
                                                    {{ __('legalDocuments.current_version') }}
                                                </span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('legalDocuments.uploaded_at', ['date' => $document->created_at->format('d/m/Y H:i')]) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-x-4">
                                    <a href="{{ Storage::disk('public')->url($document->file_path) }}" target="_blank" rel="noopener"
                                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                                        {{ __('legalDocuments.view_button') }}
                                    </a>
                                    <form method="POST" action="{{ route('legalDocuments.destroy', $document->id) }}" onsubmit="return confirm('{{ __('legalDocuments.delete_confirm') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-500 dark:text-red-400">
                                            {{ __('legalDocuments.delete_button') }}
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
</x-layouts.app>
