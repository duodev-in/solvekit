<x-calc.page
    title="Annuity Calculator - SolveKit"
    description="Free annuity calculator: present or future value of a stream of equal payments, ordinary annuity or annuity due, at any payment frequency."
    lede="Value a stream of equal payments."
    about="PV = PMT × [1 − (1 + i)^−n] ÷ i; FV = PMT × [(1 + i)^n − 1] ÷ i, with i the rate per period. For an annuity due (payments at the start) multiply by (1 + i). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'annuity', 'fields' => ['solve', 'payment', 'rate', 'years', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Choose PV or FV', 'text' => ''],
        ['name' => 'Enter the payment, rate and term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is $1,000 a month for 20 years worth today at 5%?', 'answer' => '$151,525.31.'],
        ['question' => 'What do $500 a month grow to in 30 years at 6%?', 'answer' => '$502,257.52.'],
    ]"
>
    <x-calc.segmented name="solve" legend="Find" :options="['pv' => 'Present value', 'fv' => 'Future value']" selected="pv" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Payment" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="20" min="0" step="any" suffix="years" />
        <x-calc.select name="per" label="Payments" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Paid at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Annuity value" />

    <x-calc.options :decimals="false" :examples="[
        'PV monthly' => ['solve' => 'pv', 'payment' => 1000, 'rate' => 5, 'years' => 20, 'per' => '12', 'timing' => 'end'],
        'FV saving' => ['solve' => 'fv', 'payment' => 500, 'rate' => 6, 'years' => 30, 'per' => '12', 'timing' => 'end'],
        'Annuity due' => ['solve' => 'pv', 'payment' => 10000, 'rate' => 4, 'years' => 10, 'per' => '1', 'timing' => 'start'],
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
            <li>FV = PMT[(1 + i)^n − 1] ÷ i</li>
            <li>due: × (1 + i)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
