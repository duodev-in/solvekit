@php
    $units = config('units.natural_gas');
@endphp

<x-calc.page
    title="Natural Gas Converter - SolveKit"
    description="Professional natural gas converter for volume and energy units. Convert between cubic feet, therms, BTU, cubic meters, and other gas measurement units for energy calculations."
    lede="Convert natural gas between volume (ft³, CCF, m³) and energy (therms, BTU, kWh)."
    about="Volume and energy are linked by the gas heating value. This converter uses 1,037 BTU per cubic foot, the recent US average; your utility bill shows the exact value for your supply. One therm is 100,000 BTU."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter an amount of gas', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many therms are in a CCF?', 'answer' => 'About 1.037 at 1,037 BTU per cubic foot. The exact figure is on your gas bill.'],
        ['question' => 'What is an MMBtu?', 'answer' => 'One million BTU, also called a dekatherm: 10 therms.'],
        ['question' => 'How many kWh is a therm?', 'answer' => '29.31 kWh.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="ccf" to="therm" value="50" min="0" label="Amount" />

    <x-calc.result label="Therms">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Monthly bill 60 CCF' => ['value' => 60, 'from' => 'ccf'],
        'Furnace 100,000 BTU' => ['value' => 100000, 'from' => 'btu'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="50 CCF in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>therms = BTU ÷ 100,000</li>
            <li>BTU = ft³ × 1,037</li>
            <li>1 kWh = 3,412.14 BTU</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
