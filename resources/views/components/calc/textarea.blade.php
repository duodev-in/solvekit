@props([
    'name',
    'label',
    'value' => '',
    'rows' => 3,
    'placeholder' => null,
    'help' => null,
])

<div class="flex min-w-0 flex-col gap-1.5">
    <label for="calc-{{ $name }}" class="text-[13px] font-semibold text-slate-700">{{ $label }}</label>
    <textarea
        id="calc-{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        spellcheck="false"
        autocomplete="off"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($help) aria-describedby="calc-{{ $name }}-help" @endif
        {{ $attributes->class(['w-full min-w-0 resize-y rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 font-mono text-[15px] leading-6 text-slate-900 [overflow-wrap:anywhere] focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30']) }}
    >{{ $value }}</textarea>
    @if($help)
        <p id="calc-{{ $name }}-help" class="text-xs text-slate-500">{{ $help }}</p>
    @endif
</div>
