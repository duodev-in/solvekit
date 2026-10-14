@php
    $units = config('units.torque');
@endphp

<x-calc.page
    title="Nm to ft-lbs Converter - SolveKit"
    description="Professional Newton meters to foot-pounds converter for engineering applications. Convert between Nm and ft-lbs torque units with precision."
    lede="Convert newton meters to foot-pounds, or foot-pounds to newton meters."
    about="One foot-pound is 1.3558179 newton meters, so N·m are divided by 1.35582 to get ft·lbf and ft·lbf are multiplied by it to get N·m."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['lbfin', 'kgfm', 'ncm', 'knm'], 'quickRef' => ['nm:lbfft' => [10, 25, 50, 100, 200, 500], 'lbfft:nm' => [10, 25, 50, 80, 100, 250]]]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Newton meters to foot-pounds, or the reverse.'],
        ['name' => 'Enter the torque', 'text' => 'The result and equivalents update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many foot-pounds is 100 N·m?', 'answer' => '100 N·m is 73.76 ft·lbf.'],
        ['question' => 'How many newton meters is 100 ft·lbf?', 'answer' => '100 ft·lbf is 135.58 N·m.'],
        ['question' => 'Is ft-lb the same as lb-ft?', 'answer' => 'For torque, yes. Engineers often write lbf·ft to distinguish torque from the energy unit ft·lbf.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['nm:lbfft' => 'N·m → ft·lbf', 'lbfft:nm' => 'ft·lbf → N·m']" selected="nm:lbfft" />

    <x-calc.field name="value" label="Torque" value="100" suffix="N·m" suffix-ref="value-suffix" placeholder="Enter a value" />

    <x-calc.result label="Foot-pounds" />

    <x-calc.options :examples="[
        'Wheel nut 120 N·m' => ['value' => 120, 'direction' => 'nm:lbfft'],
        'Engine 400 ft·lbf' => ['value' => 400, 'direction' => 'lbfft:nm'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['lbfin', 'kgfm', 'ncm', 'knm']" heading="100 N·m in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ft·lbf = N·m ÷ 1.3558179</li>
            <li>N·m = ft·lbf × 1.3558179</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
