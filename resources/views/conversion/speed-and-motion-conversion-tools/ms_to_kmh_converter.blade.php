@php
    $units = config('units.speed');
@endphp

<x-calc.page
    title="m/s to km/h Converter - SolveKit"
    description="Professional velocity converter between meters per second and kilometers per hour. Convert speed units for physics, engineering, and transportation calculations with precision."
    lede="Convert meters per second to kilometers per hour and other speed units."
    about="An hour has 3,600 seconds and a kilometer 1,000 meters, so meters per second are multiplied by 3.6 to get kilometers per hour."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a speed', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert m/s to km/h?', 'answer' => 'Multiply by 3.6. 10 m/s is 36 km/h.'],
        ['question' => 'How do I convert km/h to m/s?', 'answer' => 'Divide by 3.6. 100 km/h is 27.78 m/s.'],
        ['question' => 'How fast is a sprinter in m/s?', 'answer' => 'Elite sprinters peak at about 12 m/s, around 43 km/h.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="ms" to="kmh" value="10" label="Speed" />

    <x-calc.result label="Kilometers per hour">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Walking 1.4 m/s' => ['value' => 1.4, 'from' => 'ms'],
        'Sprinter 12 m/s' => ['value' => 12, 'from' => 'ms'],
        'Highway 100 km/h' => ['value' => 100, 'from' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="10 m/s in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>km/h = m/s × 3.6</li>
            <li>m/s = km/h ÷ 3.6</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
