@php
    $data = config('units.data');
    $sets = [
        'decimal' => ['bit' => $data['bit'], 'b' => $data['b'], 'kb' => $data['kb'], 'mb' => $data['mb'], 'gb' => $data['gb'], 'tb' => $data['tb']],
        'binary' => ['bit' => $data['bit'], 'b' => $data['b'], 'kb' => $data['kib'], 'mb' => $data['mib'], 'gb' => $data['gib'], 'tb' => $data['tib']],
    ];
@endphp

<x-calc.page
    title="kB to MB Converter - SolveKit"
    description="Professional kilobyte to megabyte converter for digital storage calculations. Convert between KB and MB with binary and decimal standards, file size context, and detailed explanations."
    lede="Convert kilobytes to megabytes, or megabytes to kilobytes, in decimal or binary units."
    about="In decimal (SI) units, 1 MB = 1,000 kB. In binary (IEC) units, 1 MiB = 1,024 KiB. Pick the standard that matches where the number came from: storage makers and networks use decimal, while Windows and many apps show binary sizes."
    :calc="['engine' => 'units', 'unitSets' => $sets, 'unitSetControl' => 'standard', 'list' => ['b', 'bit', 'gb'], 'quickRef' => ['kb:mb' => [1, 10, 100, 512, 1000, 1024], 'mb:kb' => [0.5, 1, 2, 5, 10, 100]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction and standard', 'text' => 'Decimal uses 1,000 and binary uses 1,024. Operating systems usually show binary sizes.'],
        ['name' => 'Enter the size', 'text' => 'The result, bytes and bits update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many kB are in 1 MB?', 'answer' => '1,000 in decimal units. In binary units, 1 MiB is 1,024 KiB.'],
        ['question' => 'Why does Windows show a different size?', 'answer' => 'Windows divides by 1,024 but labels the result KB and MB. Switch the standard to Binary to match it.'],
        ['question' => 'What is the difference between kB and KiB?', 'answer' => 'kB (kilobyte) is 1,000 bytes; KiB (kibibyte) is 1,024 bytes.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['kb:mb' => 'kB → MB', 'mb:kb' => 'MB → kB']" selected="kb:mb" />

    <x-calc.segmented name="standard" legend="Standard" :options="['decimal' => 'Decimal (1,000)', 'binary' => 'Binary (1,024)']" selected="decimal" />

    <x-calc.field name="value" label="Size" value="2048" min="0" suffix="kB" suffix-ref="value-suffix" placeholder="Enter a size" />

    <x-calc.result label="Megabytes" />

    <x-calc.options :examples="[
        'Document 750 kB' => ['value' => 750, 'direction' => 'kb:mb'],
        'Email limit 25 MB' => ['value' => 25, 'direction' => 'mb:kb'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$sets['decimal']" :keys="['b', 'bit', 'gb']" heading="2048 kB in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>decimal: MB = kB ÷ 1,000</li>
            <li>binary: MiB = KiB ÷ 1,024</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
