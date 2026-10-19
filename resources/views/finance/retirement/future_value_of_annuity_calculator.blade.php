<x-calc.page
    title="Future Value of Annuity Calculator - SolveKit"
    description="Free future value of annuity calculator: what equal payments grow to at an interest rate, for ordinary annuities and annuities due."
    lede="Find the future value of equal payments."
    about="FV = PMT × [(1 + i)^n − 1] ÷ i for payments at the end of each period; for an annuity due multiply by (1 + i). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'annuity_fv', 'fields' => ['payment', 'rate', 'years', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Enter the payment', 'text' => ''],
        ['name' => 'Enter rate, years and timing', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the future value of $500 a month for 20 years at 6%?', 'answer' => '$231,020.45.'],
        ['question' => 'And as an annuity due?', 'answer' => '$232,175.55.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Payment" value="500" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="20" min="0" step="any" suffix="years" />
        <x-calc.select name="per" label="Payments" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Paid at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Future value of the annuity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['payment' => 500, 'rate' => 6, 'years' => 20, 'per' => '12', 'timing' => 'end'],
        'Due' => ['payment' => 500, 'rate' => 6, 'years' => 20, 'per' => '12', 'timing' => 'start'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fv' => ['label' => 'Future value'],
            'pv' => ['label' => 'Present value'],
            'total' => ['label' => 'Total payments'],
            'interest' => ['label' => 'Interest'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FV = PMT[(1 + i)^n − 1] ÷ i</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
