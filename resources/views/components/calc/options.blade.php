@props([
    'examples' => [],
    'decimals' => true,
    'selected' => 'auto',
])

{{-- examples: [chip label => [field name => value]] --}}
<div class="mt-auto flex flex-wrap items-end gap-x-4 gap-y-3 border-t border-slate-100 pt-4">
    @if($decimals)
        <x-calc.segmented name="decimals" legend="Decimals" size="sm" :options="['2' => '2', '4' => '4', '6' => '6', 'auto' => 'Auto']" :selected="$selected" class="w-52" />
    @endif

    @if(count($examples))
        <div class="flex min-w-0 flex-col gap-1.5">
            <span class="text-[13px] font-semibold text-slate-700">Try</span>
            <div class="flex flex-wrap gap-1.5">
                @foreach($examples as $label => $values)
                    <button type="button" data-calc-example="{{ json_encode($values) }}" class="h-8 rounded-full border border-slate-200 px-3 text-[13px] text-slate-700 hover:border-primary-500 hover:text-primary-700 focus-visible:outline-2 focus-visible:outline-primary-600">{{ $label }}</button>
                @endforeach
            </div>
        </div>
    @endif

    {{ $slot }}

    <button type="button" data-calc-reset class="ml-auto h-8 rounded-lg border border-slate-300 px-3 text-[13px] font-medium text-slate-700 hover:border-slate-400 focus-visible:outline-2 focus-visible:outline-primary-600">Reset</button>
</div>
