@php
    $units = config('units.astronomical');
@endphp

<x-calc.page
    title="Light Year Converter - SolveKit"
    description="Professional light year converter to convert light years to kilometers, miles, astronomical units, and parsecs. Accurate space distance conversions for astronomy."
    lede="Convert light years to kilometers, miles, astronomical units and parsecs."
    about="A light year is the distance light travels in a Julian year of 365.25 days: exactly 9,460,730,472,580.8 km. All units here convert through the meter."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a distance', 'text' => 'Type the distance in light years, or pick another unit.'],
        ['name' => 'Choose the target unit', 'text' => 'The result and all other units update instantly.'],
    ]"
    :faqs="[
        ['question' => 'How far is a light year?', 'answer' => 'About 9.461 trillion kilometers (5.879 trillion miles): the distance light travels in 365.25 days.'],
        ['question' => 'What is a parsec?', 'answer' => 'A parsec is about 3.2616 light years, the distance at which 1 AU subtends one arcsecond.'],
        ['question' => 'How far is the nearest star?', 'answer' => 'Proxima Centauri is about 4.24 light years away.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="ly" to="km" value="1" min="0" label="Distance" />

    <x-calc.result label="Kilometers">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Proxima Centauri 4.24 ly' => ['value' => 4.24, 'from' => 'ly'],
        'Sirius 8.6 ly' => ['value' => 8.6, 'from' => 'ly'],
        'Galactic centre 26,000 ly' => ['value' => 26000, 'from' => 'ly'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="1 ly in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 ly = 299,792,458 m/s × 31,557,600 s</li>
            <li>1 ly = 9,460,730,472,580,800 m</li>
            <li>1 pc ≈ 3.26156 ly</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
