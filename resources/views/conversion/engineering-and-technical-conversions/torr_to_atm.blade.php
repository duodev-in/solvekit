@php
    $units = config('units.pressure');
@endphp

<x-calc.page
    title="Torr to atm Converter - SolveKit"
    description="Professional Torr to atmosphere converter for vacuum and pressure applications. Convert between Torr, atm, mmHg and other pressure units with precision."
    lede="Convert torr to atmospheres and other vacuum and pressure units."
    about="A torr is defined as exactly 1/760 of a standard atmosphere (101,325 Pa), so atmospheres = torr ÷ 760. The millimeter of mercury differs from the torr by less than one part in a million."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['atm', 'pa', 'kpa', 'mbar', 'bar', 'mmhg', 'mtorr', 'inhg', 'psi']]"
    :how-to="[
        ['name' => 'Enter a pressure', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many torr are in an atmosphere?', 'answer' => 'Exactly 760 Torr.'],
        ['question' => 'Is a torr the same as a millimeter of mercury?', 'answer' => 'Almost: 1 mmHg is 1.000000142 Torr. The difference only matters in metrology.'],
        ['question' => 'What pressure ranges count as vacuum?', 'answer' => 'Roughly: rough vacuum 760 to 1 Torr, medium 1 to 0.001 Torr, high vacuum below 0.001 Torr (1 mTorr).'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="torr" to="atm" value="760" label="Pressure" />

    <x-calc.result label="Atmospheres">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Everest summit 253 Torr' => ['value' => 253, 'from' => 'torr'],
        'Vacuum pump 10 mTorr' => ['value' => 10, 'from' => 'mtorr'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" :keys="['atm', 'pa', 'kpa', 'mbar', 'bar', 'mmhg', 'mtorr', 'inhg', 'psi']" heading="760 Torr in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>atm = Torr ÷ 760</li>
            <li>1 Torr = 133.322 Pa</li>
            <li>1 mTorr = 0.001 Torr</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
