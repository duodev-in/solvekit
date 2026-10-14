@php
    $units = config('units.torque');
@endphp

<x-calc.page
    title="in-lbs ↔ ft-lbs Converter - SolveKit"
    description="Professional inch-pounds to foot-pounds converter for engineering applications. Convert between in-lbs and ft-lbs torque units with precision."
    lede="Convert inch-pounds to foot-pounds, or foot-pounds to inch-pounds."
    about="A foot is 12 inches, so 12 inch-pounds make one foot-pound. Divide inch-pounds by 12 for foot-pounds, or multiply foot-pounds by 12."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a torque', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many inch-pounds are in a foot-pound?', 'answer' => 'Exactly 12.'],
        ['question' => 'How do I convert 100 in·lbf to ft·lbf?', 'answer' => '100 ÷ 12 = 8.33 ft·lbf.'],
        ['question' => 'Why do some specs use inch-pounds?', 'answer' => 'Small fastener torques are easier to read in inch-pounds, e.g. 96 in·lbf instead of 8 ft·lbf.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="lbfin" to="lbfft" value="120" label="Torque" />

    <x-calc.result label="Foot-pounds">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Valve cover 96 in·lbf' => ['value' => 96, 'from' => 'lbfin'],
        'Lug nut 80 ft·lbf' => ['value' => 80, 'from' => 'lbfft'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="120 in·lbf in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ft·lbf = in·lbf ÷ 12</li>
            <li>in·lbf = ft·lbf × 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
