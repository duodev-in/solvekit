@php
    $data = config('units.data');
    $sets = [
        'decimal' => ['bit' => $data['bit'], 'b' => $data['b'], 'kb' => $data['kb'], 'mb' => $data['mb'], 'gb' => $data['gb'], 'tb' => $data['tb']],
        'binary' => ['bit' => $data['bit'], 'b' => $data['b'], 'kb' => $data['kib'], 'mb' => $data['mib'], 'gb' => $data['gib'], 'tb' => $data['tib']],
    ];
@endphp

<x-calc.page
    title="MB to GB Converter - SolveKit"
    description="Professional megabyte to gigabyte converter for digital storage calculations. Convert between MB and GB with binary and decimal standards, storage context, and detailed explanations."
    lede="Convert megabytes to gigabytes, or gigabytes to megabytes, in decimal or binary units."
    about="In decimal (SI) units, 1 GB = 1,000 MB. In binary (IEC) units, 1 GiB = 1,024 MiB. Phone plans and drive labels use decimal; memory and many operating systems use binary."
    :calc="['engine' => 'units', 'unitSets' => $sets, 'unitSetControl' => 'standard', 'list' => ['kb', 'b', 'tb'], 'quickRef' => ['mb:gb' => [100, 500, 1000, 1024, 4096, 10000], 'gb:mb' => [0.5, 1, 4, 8, 16, 64]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction and standard', 'text' => 'Decimal uses 1,000 and binary uses 1,024. Operating systems usually show binary sizes.'],
        ['name' => 'Enter the size', 'text' => 'The result, bytes and bits update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many MB are in 1 GB?', 'answer' => '1,000 in decimal units. In binary units, 1 GiB is 1,024 MiB.'],
        ['question' => 'Is mobile data counted in 1,000 or 1,024?', 'answer' => 'Most carriers count in decimal (1 GB = 1,000 MB), but check your plan.'],
        ['question' => 'How many GB is 4096 MB?', 'answer' => '4.096 GB in decimal, or exactly 4 GiB in binary.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['mb:gb' => 'MB → GB', 'gb:mb' => 'GB → MB']" selected="mb:gb" />

    <x-calc.segmented name="standard" legend="Standard" :options="['decimal' => 'Decimal (1,000)', 'binary' => 'Binary (1,024)']" selected="decimal" />

    <x-calc.field name="value" label="Size" value="4096" min="0" suffix="MB" suffix-ref="value-suffix" placeholder="Enter a size" />

    <x-calc.result label="Gigabytes" />

    <x-calc.options :examples="[
        'App 850 MB' => ['value' => 850, 'direction' => 'mb:gb'],
        'RAM 16 GB' => ['value' => 16, 'direction' => 'gb:mb', 'standard' => 'binary'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$sets['decimal']" :keys="['kb', 'b', 'tb']" heading="4096 MB in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>decimal: GB = MB ÷ 1,000</li>
            <li>binary: GiB = MiB ÷ 1,024</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
