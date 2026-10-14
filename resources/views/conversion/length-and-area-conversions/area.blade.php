@php
    $units = config('units.area');
@endphp

<x-calc.page
    title="Area Calculator - SolveKit"
    description="Professional area calculator to convert between square meters, square feet, acres, hectares, and other area units. Fast and accurate conversions."
    lede="Convert between metric, imperial and land area units."
    about="Every unit converts through the square meter. Your value is multiplied by the source unit's area in square meters, then divided by the target unit's area."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter an area', 'text' => 'Type the area you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit updates as you type. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many square feet are in a square meter?', 'answer' => 'One square meter is 10.7639 square feet. A square foot is exactly 0.09290304 square meters.'],
        ['question' => 'How big is a hectare?', 'answer' => 'A hectare is 10,000 square meters, a square 100 m on each side. It is about 2.471 acres.'],
        ['question' => 'How many square feet are in an acre?', 'answer' => 'An acre is exactly 43,560 square feet, or 4,046.8564224 square meters.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="ft2" to="m2" value="1000" min="0" label="Area" />

    <x-calc.result label="Square meters">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Parking space 12.5 m²' => ['value' => 12.5, 'from' => 'm2'],
        'Tennis court 2,808 ft²' => ['value' => 2808, 'from' => 'ft2'],
        'Football field 1.32 ac' => ['value' => 1.32, 'from' => 'acre'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="1,000 ft² in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <p class="font-mono text-slate-800">result = value × (from unit in m²) ÷ (to unit in m²)</p>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>1 ft² = 0.09290304 m²</li>
            <li>1 yd² = 0.83612736 m²</li>
            <li>1 ac = 4,046.8564224 m²</li>
            <li>1 ha = 10,000 m²</li>
            <li>1 mi² = 640 ac</li>
            <li>1 a = 100 m²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
