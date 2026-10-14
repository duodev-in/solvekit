@php
    $units = config('units.volume');
@endphp

<x-calc.page
    title="Liters to Centiliters Converter - SolveKit"
    description="Professional liters to centiliters converter for metric volume conversions. Convert liters (L) to centiliters (cL) with precision for laboratory and culinary use."
    lede="Convert liters to centiliters, or centiliters to liters."
    about="A centiliter is one hundredth of a liter, so liters are multiplied by 100 to get centiliters and centiliters are divided by 100 to get liters."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['ml', 'dl', 'floz_us', 'cup_us'], 'quickRef' => ['l:cl' => [0.33, 0.5, 0.75, 1, 1.5, 2], 'cl:l' => [5, 10, 25, 33, 50, 75]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Liters to centiliters, or centiliters to liters.'],
        ['name' => 'Enter the volume', 'text' => 'The result and equivalents update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many centiliters are in a liter?', 'answer' => 'One liter is exactly 100 centiliters.'],
        ['question' => 'How big is a 75 cL bottle?', 'answer' => '75 cL is 0.75 L (750 mL), the standard wine bottle.'],
        ['question' => 'Where are centiliters used?', 'answer' => 'Mostly on drink labels and in bar recipes in Europe, e.g. a 33 cL can.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['l:cl' => 'Liters → Centiliters', 'cl:l' => 'Centiliters → Liters']" selected="l:cl" />

    <x-calc.field name="value" label="Volume" value="0.75" min="0" suffix="L" suffix-ref="value-suffix" placeholder="Enter a volume" />

    <x-calc.result label="Centiliters" />

    <x-calc.options :examples="[
        'Can 33 cL' => ['value' => 33, 'direction' => 'cl:l'],
        'Bottle 1.5 L' => ['value' => 1.5, 'direction' => 'l:cl'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['ml', 'dl', 'floz_us', 'cup_us']" heading="0.75 L in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>centiliters = liters × 100</li>
            <li>liters = centiliters ÷ 100</li>
            <li>1 cL = 10 mL</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
