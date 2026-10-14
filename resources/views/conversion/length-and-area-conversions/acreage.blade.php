@php
    $units = config('units.area');
@endphp

<x-calc.page
    title="Acreage Calculator - SolveKit"
    description="Professional acreage calculator to convert acres to square meters, hectares, square feet, and square yards. Accurate and fast conversions for land measurement."
    lede="Convert acres to hectares, square feet and other land units, or back to acres."
    about="An international acre is 4,840 square yards, exactly 4,046.8564224 square meters. The calculator converts your value to square meters, then to every other unit."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter the land area', 'text' => 'Type the area in acres, or choose another unit you have.'],
        ['name' => 'Choose the target unit', 'text' => 'Pick the unit you want. Every other unit is listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How many square feet are in an acre?', 'answer' => 'An acre is exactly 43,560 square feet.'],
        ['question' => 'How many acres are in a hectare?', 'answer' => 'One hectare is 2.47105 acres. One acre is 0.404686 hectares.'],
        ['question' => 'How many acres are in a square mile?', 'answer' => 'A square mile is exactly 640 acres.'],
        ['question' => 'How big is one acre?', 'answer' => 'A square acre is about 208.7 feet (63.6 m) on each side.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="acre" to="ha" value="5" min="0" label="Land area" />

    <x-calc.result label="Hectares">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Quarter acre lot' => ['value' => 0.25, 'from' => 'acre'],
        'Small farm 40 ac' => ['value' => 40, 'from' => 'acre'],
        'Square mile' => ['value' => 1, 'from' => 'mi2'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="5 ac in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <p class="font-mono text-slate-800">1 acre = 4,840 yd² = 43,560 ft² = 4,046.8564224 m²</p>
        <p>To convert acres to another unit, multiply by 4,046.8564224 to get square meters, then divide by the target unit's size in square meters.</p>
    </x-slot:formula>
</x-calc.page>
