<x-calc.page
    title="CCF to Therms Calculator - SolveKit"
    description="Professional CCF to therms calculator for gas volume to energy conversion. Convert hundred cubic feet to therms for utility billing and energy consumption analysis."
    lede="Convert gas usage in CCF to therms, or therms to CCF, and estimate the cost."
    about="Gas meters measure volume (CCF, hundred cubic feet) but gas is billed by energy (therms, 100,000 BTU each). The link is the heating value: therms = CCF × heating value (BTU per cubic foot) ÷ 1,000. Your bill states the heating value or a therm factor; about 1,037 BTU/ft³ is the US average."
    :calc="['engine' => 'ccf-therms', 'quickRef' => [1, 10, 25, 50, 100, 200]]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'CCF to therms, or therms to CCF.'],
        ['name' => 'Enter the heating value', 'text' => 'Use the BTU per cubic foot from your bill, or keep the US average.'],
        ['name' => 'Add a price (optional)', 'text' => 'Enter the price per therm to estimate the cost.'],
    ]"
    :faqs="[
        ['question' => 'How many therms are in a CCF?', 'answer' => 'About 1.037 at the US average heating value. Your utility\'s therm factor gives the exact figure.'],
        ['question' => 'What is a therm factor?', 'answer' => 'The number of therms per CCF your utility applies, which equals the heating value ÷ 1,000.'],
        ['question' => 'How many BTU is a therm?', 'answer' => '100,000 BTU, about 29.3 kWh.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['ccf' => 'CCF → Therms', 'therms' => 'Therms → CCF']" selected="ccf" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="value" label="Amount" value="60" min="0" suffix="CCF" suffix-ref="value-suffix" placeholder="Enter an amount" />
        <x-calc.field name="heating" label="Heating value" value="1037" min="0" suffix="BTU/ft³" placeholder="1037" />
        <x-calc.field name="price" label="Price per therm" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Therms" />

    <x-calc.options :examples="[
        'Winter month 120 CCF' => ['value' => 120, 'direction' => 'ccf'],
        'Summer month 20 CCF' => ['value' => 20, 'direction' => 'ccf'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same gas in" :rows="[
            'ft3' => ['label' => 'Cubic feet', 'unit' => 'ft³'],
            'm3' => ['label' => 'Cubic meters', 'unit' => 'm³'],
            'btu' => ['label' => 'BTU', 'unit' => 'BTU'],
            'kwh' => ['label' => 'Kilowatt-hours', 'unit' => 'kWh'],
            'cost' => ['label' => 'Estimated cost'],
        ]" />
        <x-calc.quick-ref heading="CCF to therms at this heating value" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>therms = CCF × BTU/ft³ ÷ 1,000</li>
            <li>1 therm = 100,000 BTU</li>
            <li>1 CCF = 100 ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
