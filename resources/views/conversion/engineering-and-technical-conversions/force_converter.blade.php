@php
    $units = config('units.force');
@endphp

<x-calc.page
    title="Force Converter - SolveKit"
    description="Professional force converter for engineering applications. Convert between Newtons, pounds-force, kilogram-force and other force units with precision."
    lede="Convert between newtons, pounds-force, kilograms-force and other force units."
    about="Every unit converts through the newton. Gravitational units use standard gravity, 9.80665 m/s²: a kilogram-force is 9.80665 N and a pound-force is exactly 4.4482216152605 N."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a force', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many newtons is a pound-force?', 'answer' => 'One pound-force is 4.44822 N.'],
        ['question' => 'What is a kilogram-force?', 'answer' => 'The weight of 1 kg under standard gravity: 9.80665 N.'],
        ['question' => 'What is a kip?', 'answer' => 'A kip is 1,000 pounds-force (4,448.22 N), used in structural engineering.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="n" to="lbf" value="100" label="Force" />

    <x-calc.result label="Pounds-force">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Apple weight 1 N' => ['value' => 1, 'from' => 'n'],
        'Person 700 N' => ['value' => 700, 'from' => 'n'],
        'Beam load 25 kip' => ['value' => 25, 'from' => 'kip'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="100 N in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>result = value × (from unit in N) ÷ (to unit in N)</li>
            <li>1 kgf = 9.80665 N</li>
            <li>1 lbf = 4.4482216152605 N</li>
            <li>1 kip = 1,000 lbf</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
