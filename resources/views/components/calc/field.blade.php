@props([
    'name',
    'label',
    'value' => null,
    'type' => 'number',
    'min' => null,
    'max' => null,
    'step' => 'any',
    'suffix' => null,
    'suffixRef' => null,
    'placeholder' => null,
    'help' => null,
    'labelRef' => null,
])

<div class="flex min-w-0 flex-col gap-1.5">
    <label for="calc-{{ $name }}" class="text-[13px] font-semibold text-slate-700" @if($labelRef) data-ref="{{ $labelRef }}" @endif>{{ $label }}</label>
    <div class="calc-control flex h-12 items-center overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-primary-600 focus-within:ring-2 focus-within:ring-primary-500/30">
        <input
            id="calc-{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @if($type === 'number') inputmode="decimal" @endif
            @if(in_array($type, ['number', 'time'], true)) step="{{ $step }}" @endif
            @if(! is_null($min)) min="{{ $min }}" @endif
            @if(! is_null($max)) max="{{ $max }}" @endif
            @if(! is_null($value)) value="{{ $value }}" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($help) aria-describedby="calc-{{ $name }}-help" @endif
            autocomplete="off"
            {{ $attributes->class(['h-full min-w-0 flex-1 bg-transparent px-3.5 font-mono text-lg font-semibold text-slate-900 outline-none placeholder:font-sans placeholder:text-sm placeholder:font-normal placeholder:text-slate-400']) }}
        >
        @if($suffix !== null || $suffixRef)
            {{-- A "$" in the suffix is the page's display currency; the runtime swaps it for the chosen symbol. --}}
            <span class="shrink-0 pr-3.5 text-sm font-medium text-slate-500" @if($suffixRef) data-ref="{{ $suffixRef }}" @endif>@if(! $suffixRef && is_string($suffix) && str_contains($suffix, '$')){!! str_replace('$', '<span data-currency-symbol>$</span>', e($suffix)) !!}@else{{ $suffix }}@endif</span>
        @endif
        {{ $slot }}
    </div>
    @if($help)
        <p id="calc-{{ $name }}-help" class="text-xs text-slate-500">{{ $help }}</p>
    @endif
</div>
