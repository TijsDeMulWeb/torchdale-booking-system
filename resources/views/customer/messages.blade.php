<x-layouts.app>
    <x-navigation.breadcrumb :breadcrumbs="[
        ['name' => __('customers.breadcrumb_singular'), 'url' => route('customers.index')],
        ['name' => $customer->full_name, 'url' => route('customers.show.overview', $customer)],
    ]" />
    <x-profile.header :customer="$customer" />
    <div class="px-4 sm:px-6 lg:px-8 my-10 pb-4">
        <x-profile.nav :customer="$customer" />

        @php
            $typeLabels = [
                'product' => __('customers.mail_type_product'),
                'gift-card' => __('customers.mail_type_gift_card'),
                'room_confirmation' => __('customers.mail_type_room_confirmation'),
                'room_reminder' => __('customers.mail_type_room_reminder'),
                'room_cancellation' => __('customers.mail_type_room_cancellation'),
            ];
        @endphp

        <ul role="list" class="divide-y divide-white/5">
            @foreach ($mails as $mail)
                <li class="relative flex items-center justify-between gap-x-6 px-4 py-5 hover:bg-white/2.5 sm:px-6 lg:px-8">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm/6 font-semibold text-white">
                            {{ $mail->subject }}
                        </p>
                        <p class="mt-1 flex text-xs/5 text-gray-400">
                            {{ $typeLabels[$mail->type] ?? $mail->type }}
                            &middot;
                            <span class="ml-1">{{ $mail->to_email }}</span>
                        </p>
                    </div>
                    <div class="flex shrink-0 items-center gap-x-4">
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                            <p class="mt-1 text-xs/5 text-gray-400">
                                {{ __('customers.sent_on', ['date' => $mail->created_at->format('d/m/Y H:i')]) }}
                            </p>
                        </div>
                        <button type="button"
                            onclick="openMailModal({{ $mail->id }})"
                            class="rounded-md bg-white/10 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-white/20">
                            {{ __('common.show') }}
                        </button>
                    </div>
                </li>

                <div id="mail-modal-{{ $mail->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" aria-modal="true" role="dialog">
                    <div class="fixed inset-0 bg-gray-900/70" onclick="closeMailModal({{ $mail->id }})"></div>
                    <div class="relative z-10 flex h-full max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-lg bg-gray-900 shadow-xl outline -outline-offset-1 outline-white/10">
                        <div class="flex items-start justify-between gap-x-4 border-b border-white/10 px-4 py-4 sm:px-6">
                            <div class="min-w-0">
                                <h2 class="text-base font-semibold text-white truncate">{{ $mail->subject }}</h2>
                                <p class="mt-1 text-xs text-gray-400">
                                    {{ __('customers.sent_to_on', ['email' => $mail->to_email, 'date' => $mail->created_at->format('d/m/Y \o\m H:i')]) }}
                                </p>
                            </div>
                            <button type="button" onclick="closeMailModal({{ $mail->id }})" class="text-gray-400 hover:text-white">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-5" aria-hidden="true">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 overflow-hidden bg-white">
                            <iframe srcdoc="{!! htmlspecialchars($mail->body, ENT_QUOTES, 'UTF-8') !!}" class="h-full w-full border-0" sandbox=""></iframe>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>

        @if ($mails->isEmpty())
            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('customers.no_messages') }}</p>
        @endif
    </div>

    <script>
        function openMailModal(id) {
            document.getElementById('mail-modal-' + id)?.classList.remove('hidden');
        }

        function closeMailModal(id) {
            document.getElementById('mail-modal-' + id)?.classList.add('hidden');
        }
    </script>
</x-layouts.app>
