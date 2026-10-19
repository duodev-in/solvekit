<x-calc.page
    title="US Capital Gains Tax Calculator - SolveKit"
    description="Free capital gains tax calculator for 2026: tax on long-term gains at 0/15/20% stacked on your other income, short-term gains at ordinary rates, and the 3.8% NIIT."
    lede="Work out federal tax on a capital gain."
    about="Long-term gains (assets held over a year) are taxed at 0%, 15% or 20% depending on taxable income including the gain: for 2026, 0% up to $49,450 single or $98,900 joint. Short-term gains are ordinary income. The 3.8% net investment income tax applies above $200,000 / $250,000 MAGI. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'capital_gains', 'fields' => ['gain', 'income', 'term', 'status'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the gain', 'text' => ''],
        ['name' => 'Enter your other taxable income', 'text' => 'Gains stack on top of it.'],
    ]"
    :faqs="[
        ['question' => 'What tax is due on a $30,000 long-term gain with $60,000 of other taxable income?', 'answer' => '$4,500.00.'],
        ['question' => 'And if held under a year?', 'answer' => '$6,600.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gain" label="Capital gain" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Other taxable income (after deductions)" value="60000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="term" label="Held" :options="['long' => 'More than a year', 'short' => 'A year or less']" selected="long" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <x-calc.result label="Tax on the gain" />

    <x-calc.options :decimals="false" :examples="[
        'Long-term' => ['gain' => 30000, 'income' => 60000, 'term' => 'long', 'status' => 'single'],
        'Short-term' => ['gain' => 30000, 'income' => 60000, 'term' => 'short', 'status' => 'single'],
        'Large gain' => ['gain' => 500000, 'income' => 150000, 'term' => 'long', 'status' => 'mfj'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'federal' => ['label' => 'Federal tax'],
            'niit' => ['label' => 'Net investment income tax'],
            'rate' => ['label' => 'Rate rules'],
            'after' => ['label' => 'Gain after tax'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gains stack on ordinary income: 0% / 15% / 20%</li>
            <li>NIIT = 3.8% × min(gain, MAGI − threshold)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
