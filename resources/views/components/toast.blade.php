@props([
    'message' => null,
    'type' => 'info',
])

@php
    $styles = [
        'success' => ['border' => 'border-emerald-500', 'icon' => 'check-circle', 'label' => 'Success'],
        'warning' => ['border' => 'border-amber-500', 'icon' => 'exclamation-triangle', 'label' => 'Warning'],
        'error' => ['border' => 'border-red-500', 'icon' => 'x-circle', 'label' => 'Error'],
        'info' => ['border' => 'border-primary-600', 'icon' => 'information-circle', 'label' => 'Information'],
    ];
    $style = $styles[$type] ?? $styles['info'];
@endphp

@if($message)
    <div data-toast class="pointer-events-auto fixed inset-x-4 bottom-4 z-50 mx-auto max-w-md border border-zinc-200 bg-white px-4 py-3 shadow-xl dark:border-zinc-700 dark:bg-zinc-900 {{ $style['border'] }}" role="status" aria-live="polite">
        <div class="flex items-start gap-3">
            <flux:icon :name="$style['icon']" class="mt-0.5 size-5 shrink-0" />
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $style['label'] }}</p>
                <p class="mt-1 text-sm text-zinc-800 dark:text-zinc-100">{{ $message }}</p>
            </div>
            <button type="button" data-toast-dismiss class="text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200" aria-label="Dismiss notification">&times;</button>
        </div>
        <div data-toast-progress class="absolute inset-x-0 bottom-0 h-0.5 bg-current opacity-70"></div>
    </div>
@endif
