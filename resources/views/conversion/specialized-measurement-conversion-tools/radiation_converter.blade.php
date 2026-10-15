@php
    $tables = [
        'Absorbed dose' => config('units.radiation_dose'),
        'Equivalent dose' => config('units.radiation_equivalent'),
        'Activity' => config('units.radiation_activity'),
        'Exposure' => config('units.radiation_exposure'),
    ];
    $units = collect($tables)->collapse()->all();
    $groups = collect($tables)->map(fn ($table) => array_keys($table))->all();
@endphp

<x-calc.page
    title="Radiation Converter - SolveKit"
    description="Professional radiation converter for dose and exposure units. Convert between Sievert, Gray, Rem, Rad, and other radiation measurement units for safety and medical applications."
    lede="Convert radiation dose, equivalent dose, activity and exposure units."
    about="Radiation has four separate quantities, and units only convert within one: absorbed dose (gray, rad), equivalent dose (sievert, rem), activity of a source (becquerel, curie) and exposure in air (roentgen). Gray and sievert are only numerically equal for X-rays, gamma and beta radiation, so they are kept apart."
    :calc="['engine' => 'units', 'units' => $units, 'groups' => $groups, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Pick the unit you have', 'text' => 'The menu groups units by quantity; the target stays in the same quantity.'],
        ['name' => 'Enter the value', 'text' => 'Every unit of that quantity is listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How many rem is a sievert?', 'answer' => '100 rem. 1 mSv is 100 mrem.'],
        ['question' => 'Can I convert becquerels to sieverts?', 'answer' => 'Not directly. Activity measures how fast a source decays; dose depends on the isotope, distance, time and shielding.'],
        ['question' => 'How big is a typical dose?', 'answer' => 'A chest X-ray is about 0.1 mSv; average natural background is about 2.4 mSv a year.'],
    ]"
>
    <x-calc.unit-pair :units="$units" :groups="$groups" from="msv" to="mrem" value="2.4" min="0" label="Value" />

    <x-calc.result label="Millirem">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Chest X-ray 0.1 mSv' => ['value' => 0.1, 'from' => 'msv', 'to' => 'mrem'],
        'Smoke detector 1 µCi' => ['value' => 1, 'from' => 'uci', 'to' => 'kbq'],
        'Dental X-ray 5 µGy' => ['value' => 5, 'from' => 'ugy', 'to' => 'mrad'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="In other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 Gy = 100 rad · 1 Sv = 100 rem</li>
            <li>1 Ci = 3.7 × 10¹⁰ Bq</li>
            <li>1 R = 2.58 × 10⁻⁴ C/kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
