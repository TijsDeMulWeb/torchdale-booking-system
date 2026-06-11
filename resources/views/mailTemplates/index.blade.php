<x-layouts.app>
    @php
        $typeLabel = match($type) {
            'product' => __('nav.products'),
            'gift-card' => __('giftCards.breadcrumb_plural'),
            'room_confirmation', 'room_reminder', 'room_cancellation' => $room->name,
        };

        $roomTabs = [
            'confirmation' => __('mailTemplates.tab_confirmation'),
            'reminder'     => __('mailTemplates.tab_reminder'),
            'cancellation' => __('mailTemplates.tab_cancellation'),
        ];

        $roomDescriptions = [
            'confirmation' => __('mailTemplates.desc_confirmation'),
            'reminder'     => __('mailTemplates.desc_reminder'),
            'cancellation' => __('mailTemplates.desc_cancellation'),
        ];
    @endphp

    <x-navigation.breadcrumb :breadcrumbs="$room
        ? [
            ['name' => __('nav.rooms'), 'url' => route('rooms.index')],
            ['name' => $room->name, 'url' => route('rooms.edit', $room->id)],
            ['name' => __('mailTemplates.breadcrumb_plural'), 'url' => route('mail-templates.room.index', [$room, $subtype])],
        ]
        : [
            ['name' => $type === 'product' ? __('nav.products') : __('giftCards.breadcrumb_plural'), 'url' => $type === 'product' ? route('products.index') : route('giftCards.index')],
            ['name' => __('mailTemplates.breadcrumb_plural'), 'url' => route('mail-templates.index', $type)],
        ]" />

    <div class="px-4 sm:px-6 lg:px-8 my-10">
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('mailTemplates.breadcrumb_plural') }} — {{ $typeLabel }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('mailTemplates.subtitle_scope', ['scope' => $room ? __('mailTemplates.scope_room') : ($type === 'product' ? __('mailTemplates.scope_products') : __('mailTemplates.scope_giftcards'))]) }}
                    {{ $room ? $roomDescriptions[$subtype] : __('mailTemplates.desc_order') }}
                </p>
            </div>
            @if($templates->count() < count($locales))
                <a href="{{ $room ? route('mail-templates.room.create', [$room, $subtype]) : route('mail-templates.create', $type) }}"
                    class="mt-4 sm:mt-0 inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('mailTemplates.add_template') }}
                </a>
            @endif
        </div>

        @if($room)
            <div class="mb-6 border-b border-gray-200 dark:border-white/10">
                <nav class="-mb-px flex gap-x-6">
                    @foreach($roomTabs as $tabKey => $tabLabel)
                        <a href="{{ route('mail-templates.room.index', [$room, $tabKey]) }}"
                            class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium {{ $subtype === $tabKey
                                ? 'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400'
                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            {{ $tabLabel }}
                        </a>
                    @endforeach
                </nav>
            </div>
        @endif

        @if($templates->isEmpty())
            <div class="text-center py-16 rounded-xl border border-dashed border-gray-300 dark:border-white/10">
                <svg class="mx-auto size-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('mailTemplates.empty_text', ['context' => $room ? __('mailTemplates.empty_context_bookings') : __('mailTemplates.empty_context_orders')]) }}</p>
                <a href="{{ $room ? route('mail-templates.room.create', [$room, $subtype]) : route('mail-templates.create', $type) }}"
                    class="mt-4 inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                    {{ __('mailTemplates.create_first') }}
                </a>
            </div>
        @else
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('mailTemplates.table_language') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('mailTemplates.table_subject') }}</th>
                            @if(in_array($type, ['room_confirmation', 'room_reminder']))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('mailTemplates.table_ics') }}</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('mailTemplates.table_updated') }}</th>
                            <th class="relative px-6 py-3"><span class="sr-only">{{ __('common.actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5 bg-white dark:bg-transparent">
                        @foreach($templates as $template)
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 ring-1 ring-inset ring-indigo-700/10 dark:ring-indigo-500/20">
                                        {{ strtoupper($template->locale) }} — {{ $locales[$template->locale] ?? $template->locale }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $template->subject }}</td>
                                @if(in_array($type, ['room_confirmation', 'room_reminder']))
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $template->attach_ics ? __('common.yes') : __('common.no') }}</td>
                                @endif
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $template->updated_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-right text-sm flex items-center justify-end gap-3">
                                    <a href="{{ $room ? route('mail-templates.room.edit', [$room, $subtype, $template]) : route('mail-templates.edit', [$type, $template]) }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">{{ __('common.edit') }}</a>
                                    <form method="POST" action="{{ $room ? route('mail-templates.room.destroy', [$room, $subtype, $template]) : route('mail-templates.destroy', [$type, $template]) }}"
                                        onsubmit="return confirm('{{ __('mailTemplates.delete_confirm_js') }}')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">{{ __('common.delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
