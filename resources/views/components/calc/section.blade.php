@props([
    'heading',
    'headingRef' => null,
    'hint' => null,
    'grow' => false,
])

<div @class(['flex min-h-0 flex-col', 'flex-1' => $grow])>
    <div class="flex shrink-0 items-center justify-between gap-3 border-b border-slate-200 px-5 py-3">
        <h2 class="truncate text-[15px] font-semibold text-slate-900" @if($headingRef) data-ref="{{ $headingRef }}" @endif>{{ $heading }}</h2>
        @if($hint)
            <span class="shrink-0 text-xs text-slate-500">{{ $hint }}</span>
        @endif
    </div>
    {{ $slot }}
</div>
