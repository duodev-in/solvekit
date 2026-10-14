@php
    $units = config('units.force');
@endphp

<x-calc.page
    title="Lbs ↔ Newtons Converter - SolveKit"
    description="Professional pound-force to Newtons converter for engineering applications. Convert between lbf and N force units with precision."
    lede="Convert pounds-force to newtons, or newtons to pounds-force."
    about="A pound-force is the weight of one pound mass under standard gravity: 0.45359237 kg × 9.80665 m/s² = 4.4482216152605 N exactly."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a force', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many newtons are in a pound?', 'answer' => 'One pound-force is 4.44822 N.'],
        ['question' => 'Is a pound a unit of force or mass?', 'answer' => 'Both are called pounds. The pound mass (lb) is 0.45359237 kg; the pound-force (lbf) is the weight of that mass, 4.44822 N.'],
        ['question' => 'How do I convert newtons to pounds?', 'answer' => 'Divide by 4.44822, or multiply by 0.224809.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="lbf" to="n" value="10" label="Force" />

    <x-calc.result label="Newtons">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Bowling ball 16 lbf' => ['value' => 16, 'from' => 'lbf'],
        'Thrust 500 N' => ['value' => 500, 'from' => 'n'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="10 lbf in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = lbf × 4.4482216152605</li>
            <li>lbf = N × 0.224809</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
