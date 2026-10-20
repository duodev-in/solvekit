@props([
    'heading' => 'Steps',
    'name' => 'steps',
])

{{-- Filled by the tool script (outcome.texts[name]): worked steps or a column layout in monospace, scrolling sideways when wide. --}}
<x-calc.section :heading="$heading" :grow="true">
    <div class="overflow-x-auto px-5 py-4">
        <pre data-ref="{{ $name }}" class="m-0 whitespace-pre font-mono text-[13px] leading-6 text-slate-800"></pre>
    </div>
</x-calc.section>
