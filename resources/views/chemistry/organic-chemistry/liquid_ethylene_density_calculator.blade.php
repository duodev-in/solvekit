<x-calc.page
    title="Liquid Ethylene Density Calculator - SolveKit"
    description="Free liquid ethylene density calculator: density of saturated liquid ethylene from the triple point to the critical point using NIST data."
    lede="Look up the density of saturated liquid ethylene at a temperature."
    about="Values are interpolated from 1,197 points of NIST Chemistry WebBook data (the Smukala, Span and Wagner 2000 equation of state) for liquid ethylene at its own vapor pressure, from the triple point (−169.2 °C) to the critical point (9.2 °C). The points are at most 0.3 K apart, so interpolation adds no meaningful error."
    :calc="['engine' => 'chem-organic', 'tool' => 'ethylene_density', 'fields' => ['temperature'], 'data' => ['ethylene' => config('chemistry_data.ethylene')]]"
    :how-to="[
        ['name' => 'Enter the temperature', 'text' => 'Between −169.2 °C and 9.2 °C.'],
    ]"
    :faqs="[
        ['question' => 'What is the density of liquid ethylene at its boiling point?', 'answer' => 'About 568 kg/m³ at −103.77 °C.'],
        ['question' => 'Why only saturated liquid?', 'answer' => 'This is liquid in equilibrium with its vapor, as in storage tanks.'],
        ['question' => 'What happens near 9.2 °C?', 'answer' => 'That is the critical point, where liquid and gas become identical.'],
    ]"
>
    <x-calc.field name="temperature" label="Temperature" value="-103.77" suffix="°C" help="Normal boiling point is −103.77 °C" />

    <x-calc.result label="Density" />

    <x-calc.options :examples="[
        'Normal boiling point' => ['temperature' => -103.77],
        'Storage at −100 °C' => ['temperature' => -100],
        'Near the triple point' => ['temperature' => -165],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lb' => ['label' => 'In lb/ft³'],
            'volume' => ['label' => 'Specific volume'],
            'pressure' => ['label' => 'Vapor pressure'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ρ(T) by linear interpolation of NIST saturated-liquid data</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
