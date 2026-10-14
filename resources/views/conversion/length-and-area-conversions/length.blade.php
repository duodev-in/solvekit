@php
    $units = config('units.length');
@endphp

<x-calc.page
    title="Length Calculator - SolveKit"
    description="Professional length calculator to convert between meters, feet, inches, kilometers, and other length units. Fast and accurate conversions."
    lede="Convert between metric and imperial length units. Results update as you type."
    about="Every unit converts through the meter. Your value is multiplied by the source unit's size in meters, then divided by the target unit's size, so any pair of units is exact to the precision shown."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a length', 'text' => 'Type the number you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want. Use the swap button to reverse them.'],
        ['name' => 'Read or copy the result', 'text' => 'The result and every other unit update instantly. Click any row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many feet are in a meter?', 'answer' => 'One meter is 3.28084 feet. A foot is defined as exactly 0.3048 meters.'],
        ['question' => 'How many meters are in a mile?', 'answer' => 'One international mile is exactly 1,609.344 meters, or 5,280 feet.'],
        ['question' => 'What is the difference between a mile and a nautical mile?', 'answer' => 'A nautical mile is exactly 1,852 meters, about 1.15 miles. It is used at sea and in aviation.'],
        ['question' => 'How precise are the results?', 'answer' => 'Factors use the exact international definitions. Choose 2, 4 or 6 decimals, or Auto for up to seven significant digits.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="ft" to="m" value="10" min="0" label="Length" />

    <x-calc.result label="Meters">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Credit card 8.5 cm' => ['value' => 8.5, 'from' => 'cm'],
        'Person 5.7 ft' => ['value' => 5.7, 'from' => 'ft'],
        'Marathon 26.2 mi' => ['value' => 26.2, 'from' => 'mi'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="10 ft in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <p class="font-mono text-slate-800">result = value × (from unit in meters) ÷ (to unit in meters)</p>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>1 in = 0.0254 m</li>
            <li>1 ft = 0.3048 m</li>
            <li>1 yd = 0.9144 m</li>
            <li>1 mi = 1,609.344 m</li>
            <li>1 nmi = 1,852 m</li>
            <li>1 km = 1,000 m</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
