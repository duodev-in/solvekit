<x-calc.page
    title="Discount Rate Calculator - SolveKit"
    description="Free discount rate calculator: the rate that links a present and a future value, or the discount factor for a rate and number of years."
    lede="Find a discount rate or discount factor."
    about="The discount rate r solves PV = FV ÷ (1 + r)^t, so r = (FV ÷ PV)^(1/t) − 1. The discount factor 1 ÷ (1 + r)^t is what each future dollar is worth today. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'discount_rate', 'fields' => ['mode', 'present', 'future', 'years', 'rate', 'years', 'future']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Rate or factor.'],
        ['name' => 'Enter the values', 'text' => 'Present and future values, or the rate.'],
    ]"
    :faqs="[
        ['question' => 'What rate turns $7,500 into $10,000 in 5 years?', 'answer' => '5.922%.'],
        ['question' => 'What is the discount factor at 8% for 5 years?', 'answer' => '0.6806.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['rate' => 'Discount rate', 'factor' => 'Discount factor']" selected="rate" />

    <div data-show-when="mode:rate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="present" label="Present value" value="7500" step="0.01" suffix="$" />
            <x-calc.field name="future" label="Future value" value="10000" step="0.01" suffix="$" />
            <x-calc.field name="years" label="Years" value="5" min="0" step="any" suffix="years" />
        </div>
    </div>

    <div data-show-when="mode:factor" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="rate" label="Discount rate" value="8" step="any" suffix="%" />
            <x-calc.field name="years" label="Years" value="5" min="0" step="any" suffix="years" />
            <x-calc.field name="future" label="Future amount (optional)" value="10000" step="0.01" suffix="$" />
        </div>
    </div>

    <x-calc.result label="Discount rate" />

    <x-calc.options :decimals="false" :examples="[
        'Rate' => ['mode' => 'rate', 'present' => 7500, 'future' => 10000, 'years' => 5, 'rate' => ''],
        'Factor' => ['mode' => 'factor', 'present' => '', 'future' => 10000, 'years' => 5, 'rate' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rate' => ['label' => 'Rate'],
            'pv' => ['label' => 'Present value'],
            'continuous' => ['label' => 'Continuous equivalent'],
            'years' => ['label' => 'Years'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = (FV ÷ PV)^(1/t) − 1</li>
            <li>DF = (1 + r)^−t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
