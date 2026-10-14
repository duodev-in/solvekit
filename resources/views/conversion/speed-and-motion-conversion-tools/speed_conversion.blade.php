@php
    $units = config('units.speed');
@endphp

<x-calc.page
    title="Speed Conversion Calculator - SolveKit"
    description="Universal speed conversion calculator for all velocity units. Convert between km/h, mph, m/s, knots, Mach, and other speed measurements with precision and comprehensive analysis."
    lede="Convert between km/h, mph, m/s, knots, Mach and other speed units."
    about="Every unit converts through meters per second. Mach here is the speed of sound in dry air at 20 °C (343 m/s); the real value changes with temperature and altitude."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a speed', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many mph is 100 km/h?', 'answer' => '62.14 mph.'],
        ['question' => 'How fast is Mach 1?', 'answer' => 'About 343 m/s (1,235 km/h) in air at 20 °C, and slower in colder air: about 295 m/s at airliner cruising altitude.'],
        ['question' => 'How fast is the speed of light?', 'answer' => 'Exactly 299,792,458 m/s, about 1.08 billion km/h.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="kmh" to="mph" value="100" label="Speed" />

    <x-calc.result label="Miles per hour">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Highway 100 km/h' => ['value' => 100, 'from' => 'kmh'],
        'Speed limit 70 mph' => ['value' => 70, 'from' => 'mph'],
        'Jet Mach 0.85' => ['value' => 0.85, 'from' => 'mach'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="100 km/h in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>result = value × (from unit in m/s) ÷ (to unit in m/s)</li>
            <li>1 mph = 0.44704 m/s</li>
            <li>1 km/h = 1/3.6 m/s</li>
            <li>1 kn = 1,852/3,600 m/s</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
