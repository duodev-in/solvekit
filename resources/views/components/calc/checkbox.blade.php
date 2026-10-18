@props([
    'name',
    'label',
    'checked' => false,
    'help' => null,
])

<label class="flex min-h-12 items-center gap-3 rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-[14px] font-medium text-slate-800">
    <input id="calc-{{ $name }}" name="{{ $name }}" type="checkbox" value="1" @checked($checked) class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
    <span>{{ $label }}@if($help)<span class="block text-xs font-normal text-slate-500">{{ $help }}</span>@endif</span>
</label>
