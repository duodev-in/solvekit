<x-calc.page
    title="Present Value of Annuity Calculator - SolveKit"
    description="Free present value of annuity calculator: what a stream of equal future payments is worth today, ordinary or due."
    lede="Find the present value of equal payments."
    about="PV = PMT × [1 − (1 + i)^−n] ÷ i for payments at the end of each period; for an annuity due multiply by (1 + i). It is the lump sum that would fund the payments. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'annuity_pv', 'fields' => ['payment', 'rate', 'years', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Enter the payment', 'text' => ''],
        ['name' => 'Enter rate, years and timing', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is $1,000 a month for 15 years worth today at 5%?', 'answer' => '$126,455.24.'],
        ['question' => 'And $20,000 a year for 10 years at 4%?', 'answer' => '$162,217.92.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Payment" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="15" min="0" step="any" suffix="years" />
        <x-calc.select name="per" label="Payments" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Paid at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Present value of the annuity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['payment' => 1000, 'rate' => 5, 'years' => 15, 'per' => '12', 'timing' => 'end'],
        'Yearly' => ['payment' => 20000, 'rate' => 4, 'years' => 10, 'per' => '1', 'timing' => 'end'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pv' => ['label' => 'Present value'],
            'fv' => ['label' => 'Future value'],
            'total' => ['label' => 'Total payments'],
            'interest' => ['label' => 'Interest'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = PMT[1 − (1 + i)^−n] ÷ i</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
