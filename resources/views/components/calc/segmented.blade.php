@props([
    'name',
    'legend',
    'options' => [],
    'selected' => null,
    'size' => 'md',
    'hideLegend' => false,
])

{{-- A radio group drawn as a segmented control; options: [value => label]. --}}
<fieldset {{ $attributes->class(['flex min-w-0 flex-col gap-1.5']) }}>
    <legend @class(['mb-1.5 text-[13px] font-semibold text-slate-700', 'sr-only' => $hideLegend])>{{ $legend }}</legend>
    <div class="flex w-full min-w-0 rounded-lg border border-slate-300 bg-white p-0.5">
        @foreach($options as $value => $label)
            <label class="relative flex min-w-0 flex-1 cursor-pointer">
                <input type="radio" name="calc-{{ $name }}" value="{{ $value }}" @checked((string) $value === (string) $selected) class="peer sr-only">
                <span @class([
                    'flex w-full items-center justify-center truncate rounded-md px-3 text-center font-medium text-slate-600 transition-colors peer-checked:bg-slate-900 peer-checked:text-white peer-focus-visible:outline-2 peer-focus-visible:outline-offset-1 peer-focus-visible:outline-primary-600 hover:text-slate-900 peer-checked:hover:text-white',
                    'h-10 text-sm' => $size === 'md',
                    'h-8 text-[13px]' => $size === 'sm',
                ])>{{ $label }}</span>
            </label>
        @endforeach
    </div>
</fieldset>
