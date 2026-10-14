@php
    $units = config('units.speed');
@endphp

<x-calc.page
    title="Knots to MPH Converter - SolveKit"
    description="Professional nautical to imperial speed converter between knots and miles per hour. Convert marine and aviation speeds for international navigation and transportation."
    lede="Convert knots to miles per hour and other speed units."
    about="One knot is 1,852 meters per hour and a mile is 1,609.344 meters, so one knot is 1.150779 mph."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a speed', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many mph is one knot?', 'answer' => 'One knot is 1.15078 mph.'],
        ['question' => 'Is a nautical mile longer than a mile?', 'answer' => 'Yes. A nautical mile is 1,852 m; a statute mile is 1,609.344 m.'],
        ['question' => 'How fast is 100 knots in mph?', 'answer' => '115.08 mph.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="knot" to="mph" value="20" label="Speed" />

    <x-calc.result label="Miles per hour">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Sailboat 6 kn' => ['value' => 6, 'from' => 'knot'],
        'Hurricane 64 kn' => ['value' => 64, 'from' => 'knot'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="20 kn in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mph = knots × 1.150779</li>
            <li>knots = mph ÷ 1.150779</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
