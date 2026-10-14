@php
    $units = config('units.power');
@endphp

<x-calc.page
    title="Power Converter - SolveKit"
    description="Professional power unit converter between watts, horsepower, BTU/h, and other power measurements. Convert mechanical, electrical, and thermal power units with precision."
    lede="Convert between watts, kilowatts, horsepower, BTU per hour and other power units."
    about="Every unit converts through the watt. Mechanical horsepower is 550 ft·lbf/s (745.7 W), metric horsepower (PS) is 735.5 W and electrical horsepower is exactly 746 W."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a power', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many watts is one horsepower?', 'answer' => 'Mechanical horsepower is 745.7 W. Metric horsepower (PS, CV) is 735.5 W.'],
        ['question' => 'How do I convert kW to hp?', 'answer' => 'Divide by 0.7457, or multiply by 1.341.'],
        ['question' => 'What is a ton of refrigeration?', 'answer' => '12,000 BTU/h, about 3.517 kW: the cooling rate of melting one short ton of ice a day.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="hp" to="kw" value="150" label="Power" />

    <x-calc.result label="Kilowatts">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Car 150 hp' => ['value' => 150, 'from' => 'hp'],
        'Kettle 2,000 W' => ['value' => 2000, 'from' => 'w'],
        'Air conditioner 12,000 BTU/h' => ['value' => 12000, 'from' => 'btuh'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="150 hp in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>result = value × (from unit in W) ÷ (to unit in W)</li>
            <li>1 hp = 745.69987 W</li>
            <li>1 PS = 735.49875 W</li>
            <li>1 BTU/h = 0.293071 W</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
