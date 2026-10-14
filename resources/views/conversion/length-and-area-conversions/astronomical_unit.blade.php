@php
    $units = config('units.astronomical');
@endphp

<x-calc.page
    title="Astronomical Unit Calculator - SolveKit"
    description="Professional astronomical unit calculator to convert AU to kilometers, miles, light years, and parsecs. Accurate space distance conversions for astronomy and education."
    lede="Convert astronomical units to kilometers, miles, light years and parsecs."
    about="The astronomical unit is fixed at exactly 149,597,870,700 meters, close to the average Earth–Sun distance. All units here convert through the meter."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a distance', 'text' => 'Type the distance in AU, or pick another unit.'],
        ['name' => 'Choose the target unit', 'text' => 'The result and all other units update instantly.'],
    ]"
    :faqs="[
        ['question' => 'How far is one astronomical unit?', 'answer' => 'Exactly 149,597,870,700 meters, about 92.96 million miles. The value was fixed by the International Astronomical Union in 2012.'],
        ['question' => 'How long does light take to travel 1 AU?', 'answer' => 'About 499 seconds, or 8 minutes 19 seconds.'],
        ['question' => 'How many AU are in a light year?', 'answer' => 'One light year is about 63,241 AU.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="au" to="km" value="1" min="0" label="Distance" />

    <x-calc.result label="Kilometers">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Mars 1.52 AU' => ['value' => 1.52, 'from' => 'au'],
        'Jupiter 5.2 AU' => ['value' => 5.2, 'from' => 'au'],
        'Neptune 30.07 AU' => ['value' => 30.07, 'from' => 'au'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="1 AU in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 AU = 149,597,870,700 m (exact)</li>
            <li>1 ly = 9,460,730,472,580,800 m (Julian year)</li>
            <li>1 pc = 648,000 ÷ π AU ≈ 3.0857 × 10¹⁶ m</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
