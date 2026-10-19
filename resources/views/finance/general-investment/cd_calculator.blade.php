<x-calc.page
    title="CD Calculator — Certificate of Deposit - SolveKit"
    description="Free CD calculator: value of a certificate of deposit at maturity from its APY or APR and term, with interest earned and an early withdrawal penalty."
    lede="Find what a CD is worth at maturity."
    about="US banks quote CD yields as APY (Regulation DD), which already includes compounding: value = deposit × (1 + APY)^(months ÷ 12). If you have the APR instead, it is compounded at the stated frequency. Early withdrawal usually costs a number of months of interest. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'cd', 'fields' => ['deposit', 'rate', 'rate_type', 'compound', 'term', 'penalty']]"
    :how-to="[
        ['name' => 'Enter the deposit and rate', 'text' => 'APY or APR.'],
        ['name' => 'Enter the term', 'text' => 'In months.'],
    ]"
    :faqs="[
        ['question' => 'What is a $10,000 12-month CD at 4.25% APY worth at maturity?', 'answer' => '$10,425.00.'],
        ['question' => 'What about 5 years?', 'answer' => '$12,166.53.'],
        ['question' => 'What is a 3-month interest penalty?', 'answer' => '$104.60 (3 months of interest).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="deposit" label="Deposit" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Rate" value="4.25" step="any" suffix="%" />
        <x-calc.select name="rate_type" label="Rate quoted as" :options="['apy' => 'APY', 'apr' => 'APR (nominal)']" selected="apy" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="compound" label="Compounding (for APR)" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="365" />
        <x-calc.field name="term" label="Term" value="12" min="0" step="1" suffix="months" />
        <x-calc.field name="penalty" label="Early withdrawal penalty (optional)" value="3" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Value at maturity" />

    <x-calc.options :decimals="false" :examples="[
        '12 months' => ['deposit' => 10000, 'rate' => 4.25, 'rate_type' => 'apy', 'compound' => '365', 'term' => 12, 'penalty' => 3],
        '5-year' => ['deposit' => 10000, 'rate' => 4, 'rate_type' => 'apy', 'compound' => '365', 'term' => 60, 'penalty' => 12],
        'APR quote' => ['deposit' => 5000, 'rate' => 4.1, 'rate_type' => 'apr', 'compound' => '12', 'term' => 18, 'penalty' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'interest' => ['label' => 'Interest earned'],
            'apy' => ['label' => 'APY'],
            'monthly' => ['label' => 'Interest per month'],
            'penalty' => ['label' => 'Early withdrawal penalty'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = deposit × (1 + APY)^(months/12)</li>
            <li>APY = (1 + APR/n)^n − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
