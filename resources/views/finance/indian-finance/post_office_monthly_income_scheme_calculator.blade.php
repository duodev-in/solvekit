<x-calc.page
    title="Post Office Monthly Income Scheme Calculator - SolveKit"
    description="Free POMIS calculator: monthly income from the Post Office Monthly Income Scheme at 7.4% for 5 years, with deposit limits."
    lede="Work out POMIS monthly income."
    about="POMIS pays interest monthly at the rate fixed when you open the account (7.4% for October–December 2026) for 5 years, then returns the deposit. Limits: ₹9 lakh single, ₹15 lakh joint. Interest is taxable. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'pomis', 'fields' => ['amount', 'account', 'rate'], 'data' => ['smallsavings' => config('finance_data.smallsavings')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the deposit', 'text' => ''],
        ['name' => 'Choose single or joint', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does ₹9 lakh in POMIS pay a month?', 'answer' => '₹5,550.00.'],
        ['question' => 'And ₹15 lakh joint?', 'answer' => '₹9,250.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Deposit" value="900000" step="1" suffix="₹" />
        <x-calc.select name="account" label="Account" :options="['single' => 'Single', 'joint' => 'Joint']" selected="single" />
        <x-calc.field name="rate" label="Interest rate" value="7.4" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly income" />

    <x-calc.options :decimals="false" :examples="[
        'Single maximum' => ['amount' => 900000, 'account' => 'single', 'rate' => 7.4],
        'Joint maximum' => ['amount' => 1500000, 'account' => 'joint', 'rate' => 7.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'yearly' => ['label' => 'Yearly interest'],
            'total' => ['label' => 'Interest over 5 years'],
            'maturity' => ['label' => 'At maturity'],
            'tax' => ['label' => 'Tax'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>monthly = deposit × rate ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
