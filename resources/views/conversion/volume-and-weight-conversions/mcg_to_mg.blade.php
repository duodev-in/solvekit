@php
    $units = config('units.mass');
@endphp

<x-calc.page
    title="Micrograms to Milligrams Converter - SolveKit"
    description="Professional micrograms to milligrams converter for precise weight conversions. Convert mcg to mg with high precision for various applications."
    lede="Convert micrograms (mcg, µg) to milligrams, or milligrams to micrograms."
    about="A milligram is 1,000 micrograms, so micrograms are divided by 1,000 to get milligrams and milligrams are multiplied by 1,000 to get micrograms."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['g', 'ng', 'kg'], 'quickRef' => ['ug:mg' => [50, 100, 250, 500, 1000, 5000], 'mg:ug' => [0.05, 0.1, 0.25, 0.5, 1, 5]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Micrograms to milligrams, or milligrams to micrograms.'],
        ['name' => 'Enter the amount', 'text' => 'The result and equivalents update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many micrograms are in a milligram?', 'answer' => 'One milligram is exactly 1,000 micrograms.'],
        ['question' => 'Are mcg and µg the same?', 'answer' => 'Yes. Both mean microgram. Medicine labels use mcg so it is not misread as mg.'],
        ['question' => 'How many mg is 1000 mcg?', 'answer' => '1,000 mcg is 1 mg.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['ug:mg' => 'Micrograms → Milligrams', 'mg:ug' => 'Milligrams → Micrograms']" selected="ug:mg" />

    <x-calc.field name="value" label="Amount" value="500" min="0" suffix="mcg" suffix-ref="value-suffix" placeholder="Enter an amount" />

    <x-calc.result label="Milligrams" />

    <x-calc.options :examples="[
        'Vitamin B12 1,000 mcg' => ['value' => 1000, 'direction' => 'ug:mg'],
        'Tablet 0.25 mg' => ['value' => 0.25, 'direction' => 'mg:ug'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['g', 'ng', 'kg']" heading="500 mcg in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>milligrams = micrograms ÷ 1,000</li>
            <li>micrograms = milligrams × 1,000</li>
            <li>1 g = 1,000 mg = 1,000,000 mcg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
