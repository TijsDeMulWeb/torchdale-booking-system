<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-white dark:bg-gray-900">
    <x-success :message="session('message')" />
    <x-error name="message" />

    <div class="border-b border-gray-200 dark:border-white/10">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Torchdale Planner — Beheerder</h1>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    Uitloggen
                </button>
            </form>
        </div>
    </div>

    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl/7 font-bold text-gray-900 sm:text-3xl sm:tracking-tight dark:text-white">
                Escaperoom aanvragen
            </h2>
            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-sm font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                {{ $requests->count() }} aanvragen
            </span>
        </div>

        @if ($requests->isEmpty())
            <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">Er zijn nog geen aanvragen ontvangen.</p>
        @else
            <ul role="list" class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                @foreach ($requests as $escaperoomRequest)
                    @php
                        $escaperoom = $escaperoomRequest->escaperoom;
                        $statusStyles = [
                            'pending' => 'bg-yellow-50 text-yellow-700 inset-ring-yellow-600/20 dark:bg-yellow-500/10 dark:text-yellow-400 dark:inset-ring-yellow-500/10',
                            'accepted' => 'bg-green-50 text-green-700 inset-ring-green-600/20 dark:bg-green-500/10 dark:text-green-500 dark:inset-ring-green-500/10',
                            'denied' => 'bg-red-50 text-red-700 inset-ring-red-600/20 dark:bg-red-500/10 dark:text-red-400 dark:inset-ring-red-500/10',
                        ];
                        $statusLabels = [
                            'pending' => 'In afwachting',
                            'accepted' => 'Goedgekeurd',
                            'denied' => 'Geweigerd',
                        ];
                    @endphp
                    <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow-sm dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate text-sm font-medium text-gray-900 dark:text-white">{{ $escaperoom->name }}</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $escaperoom->email }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $escaperoom->phone }}</p>
                                </div>
                                <span class="inline-flex shrink-0 items-center rounded-full px-1.5 py-0.5 text-xs font-medium inset-ring {{ $statusStyles[$escaperoomRequest->status] ?? '' }}">
                                    {{ $statusLabels[$escaperoomRequest->status] ?? $escaperoomRequest->status }}
                                </span>
                            </div>
                            <dl class="mt-4 grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <div>
                                    <dt class="text-gray-500 dark:text-gray-400">BTW-nummer</dt>
                                    <dd class="text-gray-900 dark:text-white">{{ $escaperoom->vat_number ?? '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500 dark:text-gray-400">Aangevraagd op</dt>
                                    <dd class="text-gray-900 dark:text-white">{{ $escaperoomRequest->created_at->format('d M Y, H:i') }}</dd>
                                </div>
                            </dl>
                        </div>

                        @if ($escaperoomRequest->status === 'pending')
                            <div class="-mt-px flex divide-x divide-gray-200 dark:divide-white/10">
                                <div class="flex w-0 flex-1">
                                    <form action="{{ route('admin.escaperoomRequests.accept', $escaperoomRequest) }}" method="POST" class="w-full"
                                        onsubmit="return confirm('Weet je zeker dat je deze aanvraag wil goedkeuren? Er wordt een welkomstmail verstuurd.');">
                                        @csrf
                                        <button type="submit"
                                            class="relative inline-flex w-full items-center justify-center gap-x-2 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-green-600 hover:bg-green-50 dark:text-green-400 dark:hover:bg-green-500/10">
                                            Goedkeuren
                                        </button>
                                    </form>
                                </div>
                                <div class="-ml-px flex w-0 flex-1">
                                    <form action="{{ route('admin.escaperoomRequests.deny', $escaperoomRequest) }}" method="POST" class="w-full"
                                        onsubmit="return confirm('Weet je zeker dat je deze aanvraag wil weigeren? Er wordt een mail verstuurd.');">
                                        @csrf
                                        <button type="submit"
                                            class="relative inline-flex w-full items-center justify-center gap-x-2 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                                            Weigeren
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                Beoordeeld op {{ optional($escaperoomRequest->reviewed_at)->format('d M Y, H:i') }}
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>

</html>
