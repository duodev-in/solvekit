<x-calc.page
    title="National Insurance Calculator - SolveKit"
    description="Free National Insurance calculator for 2026/27: employee Class 1 NI (8% and 2%), employer NI (15% over £5,000) and Class 4 for the self-employed."
    lede="Work out your National Insurance for 2026/27."
    about="Class 1 employee NI is 8% on earnings between the primary threshold (£12,570) and the upper earnings limit (£50,270), and 2% above. Employers pay 15% above £5,000 a year. Self-employed Class 4 NI is 6% on profits from £12,570 to £50,270 and 2% above; Class 2 is no longer compulsory. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'uk_ni', 'fields' => ['earnings', 'type'], 'data' => ['uk' => config('finance_data.uk')], 'sym' => 'GBP', 'currency' => 'GBP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter earnings', 'text' => ''],
        ['name' => 'Choose employed or self-employed', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What NI is paid on £45,000?', 'answer' => '£2,594.40; the employer pays £6,000.00 (15% above £5,000; Employment Allowance may reduce it).'],
        ['question' => 'And on £45,000 of self-employed profit?', 'answer' => '£1,945.80.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="earnings" label="Yearly earnings or profit" value="45000" step="0.01" suffix="£" />
        <x-calc.select name="type" label="You are" :options="['employee' => 'Employed', 'self' => 'Self-employed']" selected="employee" />
    </div>

    <x-calc.result label="National Insurance" />

    <x-calc.options :decimals="false" :examples="[
        'Employee £45k' => ['earnings' => 45000, 'type' => 'employee'],
        'Self-employed £45k' => ['earnings' => 45000, 'type' => 'self'],
        'Employee £80k' => ['earnings' => 80000, 'type' => 'employee'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'employer' => ['label' => 'Employer NI'],
            'monthly' => ['label' => 'Monthly'],
            'rate' => ['label' => 'Effective rate'],
            'year' => ['label' => 'Tax year'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>employee = 8% × (min(E, 50,270) − 12,570) + 2% × (E − 50,270)</li>
            <li>employer = 15% × (E − 5,000)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
