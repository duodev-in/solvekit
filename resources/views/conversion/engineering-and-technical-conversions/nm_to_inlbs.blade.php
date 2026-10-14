@php
    $units = config('units.torque');
@endphp

<x-calc.page
    title="Nm to in-lbs Converter - SolveKit"
    description="Professional torque converter for engineering applications. Convert between Newton-meters, inch-pounds, foot-pounds and other torque units with precision."
    lede="Convert newton meters to inch-pounds and other torque units."
    about="One newton meter is 8.85075 inch-pounds. The calculator converts through the newton meter, so any pair of torque units works."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a torque', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many inch-pounds is one newton meter?', 'answer' => 'One N·m is 8.85075 in·lbf.'],
        ['question' => 'When are inch-pounds used?', 'answer' => 'For small fasteners such as bicycle, electronics and engine-cover bolts, where foot-pounds would be awkward fractions.'],
        ['question' => 'How many inch-pounds are in a foot-pound?', 'answer' => 'Twelve.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="nm" to="lbfin" value="10" label="Torque" />

    <x-calc.result label="Inch-pounds">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Bike stem 5 N·m' => ['value' => 5, 'from' => 'nm'],
        'Spark plug 25 N·m' => ['value' => 25, 'from' => 'nm'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="10 N·m in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>in·lbf = N·m × 8.850746</li>
            <li>N·m = in·lbf × 0.1129848</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
