@php
    $units = config('units.pressure');
@endphp

<x-calc.page
    title="Pressure Converter - SolveKit"
    description="Professional pressure converter for engineering applications. Convert between Pascal, Bar, PSI, ATM, Torr, and other pressure units with precision."
    lede="Convert between pascals, bar, psi, atmospheres, torr and other pressure units."
    about="Every unit converts through the pascal (1 N/m²). psi is pounds-force per square inch, torr is 1/760 of a standard atmosphere, and mmHg and inHg use the conventional density of mercury at 0 °C."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a pressure', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many psi is 1 bar?', 'answer' => 'One bar is 14.5038 psi. One psi is 0.0689476 bar.'],
        ['question' => 'How many pascals is one atmosphere?', 'answer' => 'A standard atmosphere is exactly 101,325 Pa: 1.01325 bar, 14.696 psi or 760 Torr.'],
        ['question' => 'What is the difference between psi and psig?', 'answer' => 'psig is gauge pressure, measured relative to the surrounding air. psia is absolute. psia = psig + about 14.7 at sea level.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="psi" to="bar" value="32" label="Pressure" />

    <x-calc.result label="Bar">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Car tyre 32 psi' => ['value' => 32, 'from' => 'psi'],
        'Weather 1,013 hPa' => ['value' => 1013, 'from' => 'hpa'],
        'Scuba tank 200 bar' => ['value' => 200, 'from' => 'bar'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="32 psi in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>result = value × (from unit in Pa) ÷ (to unit in Pa)</li>
            <li>1 psi = 6,894.757 Pa</li>
            <li>1 bar = 100,000 Pa</li>
            <li>1 atm = 101,325 Pa = 760 Torr</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
