@php
    $units = config('units.volume');
@endphp

<x-calc.page
    title="CCF to Gallons Converter - SolveKit"
    description="Professional CCF to gallons converter for water utility billing. Convert hundred cubic feet to gallons with accurate water volume calculations."
    lede="Convert CCF from your water bill to gallons, or gallons back to CCF."
    about="One CCF is 100 cubic feet of water. A cubic foot is 28.316846592 liters and a US gallon is 3.785411784 liters, so one CCF is about 748.05 US gallons."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['ft3', 'l', 'm3', 'gal_uk'], 'quickRef' => ['ccf:gal_us' => [1, 2, 5, 10, 25, 50], 'gal_us:ccf' => [100, 500, 1000, 5000, 10000, 20000]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'CCF to gallons, or gallons to CCF.'],
        ['name' => 'Enter the amount', 'text' => 'Use the usage figure printed on your water bill.'],
    ]"
    :faqs="[
        ['question' => 'What does CCF mean on a water bill?', 'answer' => 'CCF stands for one hundred (C) cubic feet. Many US utilities bill water in CCF, also called HCF.'],
        ['question' => 'How many gallons are in one CCF?', 'answer' => 'One CCF is 748.05 US gallons.'],
        ['question' => 'How much water does a household use?', 'answer' => 'A typical US household uses roughly 5 to 10 CCF a month, about 3,700 to 7,500 gallons.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['ccf:gal_us' => 'CCF → Gallons', 'gal_us:ccf' => 'Gallons → CCF']" selected="ccf:gal_us" />

    <x-calc.field name="value" label="Amount" value="8" min="0" suffix="CCF" suffix-ref="value-suffix" placeholder="Enter an amount" />

    <x-calc.result label="US gallons" />

    <x-calc.options :examples="[
        'Monthly bill 6 CCF' => ['value' => 6, 'direction' => 'ccf:gal_us'],
        'Pool 15,000 gal' => ['value' => 15000, 'direction' => 'gal_us:ccf'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['ft3', 'l', 'm3', 'gal_uk']" heading="8 CCF in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 CCF = 100 ft³ = 2,831.6846592 L</li>
            <li>gallons = CCF × 748.052</li>
            <li>CCF = gallons ÷ 748.052</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
