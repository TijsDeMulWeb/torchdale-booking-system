<div class="mt-3 flex items-center gap-2">
    <span
        class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-200 dark:bg-white/10 dark:text-gray-300 dark:ring-white/10">
        Laatst bijgewerkt:
        @if ($model->updated_at->lt(now()->subDay()))
            {{ $model->updated_at->format('d/m/Y H:i') }}
        @else
            {{ $model->updated_at->diffForHumans() }}
        @endif
    </span>
</div>