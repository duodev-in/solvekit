@php
    $units = config('units.energy');
@endphp

<x-calc.page
    title="Energy Conversion Calculator - SolveKit"
    description="Professional energy unit converter between joules, calories, BTU, kWh, and other energy measurements. Convert thermal, electrical, and mechanical energy units with precision."
    lede="Convert between joules, kilowatt-hours, calories, BTU and other energy units."
    about="Every unit converts through the joule. The calorie is the thermochemical calorie (4.184 J), the BTU and therm are the International Table definitions, and a ton of TNT is defined as 4.184 GJ."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter an amount of energy', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many joules are in a kilowatt-hour?', 'answer' => 'Exactly 3,600,000 J (3.6 MJ).'],
        ['question' => 'Is a food Calorie the same as a calorie?', 'answer' => 'No. A food Calorie is a kilocalorie: 1,000 calories, or 4,184 J.'],
        ['question' => 'How many joules is a BTU?', 'answer' => 'One BTU is 1,055.06 J.'],
        ['question' => 'How much energy is a ton of TNT?', 'answer' => 'By definition 4.184 GJ (4.184 × 10⁹ J).'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="kwh" to="mj" value="1" label="Energy" />

    <x-calc.result label="Megajoules">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Electricity 1 kWh' => ['value' => 1, 'from' => 'kwh'],
        'Meal 600 kcal' => ['value' => 600, 'from' => 'kcal'],
        'Gas bill 50 therms' => ['value' => 50, 'from' => 'therm'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="1 kWh in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>result = value × (from unit in J) ÷ (to unit in J)</li>
            <li>1 kWh = 3.6 MJ</li>
            <li>1 kcal = 4,184 J</li>
            <li>1 BTU = 1,055.056 J</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
