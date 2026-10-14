@php
    $units = config('units.torque');
@endphp

<x-calc.page
    title="in-lbs ↔ Nm Converter - SolveKit"
    description="Professional inch-pounds to Newton-meters converter for engineering applications. Convert between in-lbs and Nm torque units with precision."
    lede="Convert inch-pounds to newton meters, or newton meters to inch-pounds."
    about="An inch-pound is one pound-force acting one inch from the pivot: 4.4482216 N × 0.0254 m = 0.1129848 N·m."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a torque', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many newton meters is one inch-pound?', 'answer' => 'One in·lbf is 0.112985 N·m.'],
        ['question' => 'How do I convert inch-pounds to newton meters quickly?', 'answer' => 'Multiply by 0.113, or divide by 8.85.'],
        ['question' => 'Is in-lb the same as lb-in?', 'answer' => 'Yes. Both mean inch-pounds of torque.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="lbfin" to="nm" value="50" label="Torque" />

    <x-calc.result label="Newton meters">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Small bolt 30 in·lbf' => ['value' => 30, 'from' => 'lbfin'],
        'Torque wrench 200 in·lbf' => ['value' => 200, 'from' => 'lbfin'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="50 in·lbf in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N·m = in·lbf × 0.1129848</li>
            <li>in·lbf = N·m × 8.850746</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
