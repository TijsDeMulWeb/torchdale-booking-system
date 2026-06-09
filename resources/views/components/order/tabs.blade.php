<div class="border-b border-gray-200 dark:border-white/10">
    <nav class="-mb-px flex gap-x-6" aria-label="Tabs">
        <a href="{{ route('orders.index') }}"
            class="whitespace-nowrap border-b-2 px-1 pb-3 text-sm font-medium transition-colors
                {{ request()->routeIs('orders.index')
                    ? 'border-indigo-500 text-indigo-600 dark:text-white dark:border-white'
                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}"
            @if(request()->routeIs('orders.index')) aria-current="page" @endif>
            Overzicht
        </a>
        <a href="{{ route('orders.checkout') }}"
            class="whitespace-nowrap border-b-2 px-1 pb-3 text-sm font-medium transition-colors
                {{ request()->routeIs('orders.checkout')
                    ? 'border-indigo-500 text-indigo-600 dark:text-white dark:border-white'
                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}"
            @if(request()->routeIs('orders.checkout')) aria-current="page" @endif>
            Afrekenen
        </a>
        <a href="{{ route('orders.gift-vouchers') }}"
            class="whitespace-nowrap border-b-2 px-1 pb-3 text-sm font-medium transition-colors
                {{ request()->routeIs('orders.gift-vouchers')
                    ? 'border-indigo-500 text-indigo-600 dark:text-white dark:border-white'
                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}"
            @if(request()->routeIs('orders.gift-vouchers')) aria-current="page" @endif>
            Cadeaubonnen
        </a>
    </nav>
</div>
