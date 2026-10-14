@php
    $units = config('units.speed');
@endphp

<x-calc.page
    title="Knots to KPH Converter - SolveKit"
    description="Professional nautical speed converter between knots and kilometers per hour. Convert marine and aviation speeds with precision for navigation and transportation calculations."
    lede="Convert knots to kilometers per hour and other speed units."
    about="A knot is one nautical mile per hour, and a nautical mile is exactly 1,852 meters, so one knot is exactly 1.852 km/h."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a speed', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many km/h is one knot?', 'answer' => 'Exactly 1.852 km/h.'],
        ['question' => 'Why do ships and aircraft use knots?', 'answer' => 'A nautical mile is about one minute of latitude, which makes distances on charts easy to measure.'],
        ['question' => 'How fast is 30 knots?', 'answer' => '55.56 km/h, or 34.52 mph.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="knot" to="kmh" value="20" label="Speed" />

    <x-calc.result label="Kilometers per hour">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Sailboat 6 kn' => ['value' => 6, 'from' => 'knot'],
        'Ferry 25 kn' => ['value' => 25, 'from' => 'knot'],
        'Airliner 480 kn' => ['value' => 480, 'from' => 'knot'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="20 kn in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>km/h = knots × 1.852</li>
            <li>knots = km/h ÷ 1.852</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
