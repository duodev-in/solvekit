@php
    $units = config('units.area');
@endphp

<x-calc.page
    title="Ares to Hectares Converter - SolveKit"
    description="Professional converter for ares and hectares land area measurements. Fast and accurate bidirectional conversion for agricultural and real estate calculations."
    lede="Convert ares to hectares, or hectares to ares."
    about="One hectare is 100 ares, so ares are divided by 100 to get hectares and hectares are multiplied by 100 to get ares. Both are metric land units: an are is 100 m² and a hectare is 10,000 m²."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['m2', 'acre', 'ft2', 'km2'], 'quickRef' => [1, 5, 10, 25, 50, 100], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Pick ares to hectares or hectares to ares.'],
        ['name' => 'Enter the area', 'text' => 'The result and equivalents update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is an are?', 'answer' => 'An are is 100 square meters, a square 10 m on each side.'],
        ['question' => 'How many ares are in a hectare?', 'answer' => 'One hectare is exactly 100 ares.'],
        ['question' => 'Where are ares used?', 'answer' => 'Mainly in land registers in parts of continental Europe. The hectare is far more common for farmland.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['a:ha' => 'Ares → Hectares', 'ha:a' => 'Hectares → Ares']" selected="a:ha" />

    <x-calc.field name="value" label="Area" value="250" min="0" suffix="a" suffix-ref="value-suffix" placeholder="Enter an area" />

    <x-calc.result label="Hectares" />

    <x-calc.options :examples="[
        'Garden plot 4 a' => ['value' => 4, 'direction' => 'a:ha'],
        'Farm 35 ha' => ['value' => 35, 'direction' => 'ha:a'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['m2', 'acre', 'ft2', 'km2']" heading="250 a in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hectares = ares ÷ 100</li>
            <li>ares = hectares × 100</li>
            <li>1 a = 100 m² · 1 ha = 10,000 m²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
