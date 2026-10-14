@php
    $units = config('units.torque');
@endphp

<x-calc.page
    title="Newton Meter Calculator - SolveKit"
    description="Professional Newton meter torque calculator for engineering applications. Convert between Nm, kNm, lbf·ft and other torque units with precision."
    lede="Convert newton meters to foot-pounds, inch-pounds and other torque units."
    about="Every unit converts through the newton meter: a force of one newton acting at one meter from the pivot. Imperial torque units use the exact pound-force, foot and inch."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a torque', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many foot-pounds is one newton meter?', 'answer' => 'One N·m is 0.737562 ft·lbf. One ft·lbf is 1.35582 N·m.'],
        ['question' => 'Are torque and energy the same thing?', 'answer' => 'They share the unit N·m but are different: torque is a turning force, energy is work done. Energy is usually written in joules.'],
        ['question' => 'What torque are wheel nuts tightened to?', 'answer' => 'Typically 80 to 140 N·m (about 60 to 100 ft·lbf) for cars. Always use the figure in your vehicle manual.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="nm" to="lbfft" value="100" label="Torque" />

    <x-calc.result label="Foot-pounds">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Wheel nut 120 N·m' => ['value' => 120, 'from' => 'nm'],
        'Bike stem 5 N·m' => ['value' => 5, 'from' => 'nm'],
        'Engine 300 ft·lbf' => ['value' => 300, 'from' => 'lbfft'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="100 N·m in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>result = value × (from unit in N·m) ÷ (to unit in N·m)</li>
            <li>1 ft·lbf = 1.3558179 N·m</li>
            <li>1 in·lbf = 0.1129848 N·m</li>
            <li>1 kgf·m = 9.80665 N·m</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
