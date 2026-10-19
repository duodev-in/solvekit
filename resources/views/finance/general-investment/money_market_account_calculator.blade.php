<x-calc.page
    title="Money Market Account Calculator - SolveKit"
    description="Free money market account calculator: balance with daily-compounded interest and monthly deposits, from the account's rate."
    lede="Project a money market account with daily compounding."
    about="Money market deposit accounts usually compound interest daily and credit it monthly. Rates are variable, so the result assumes today's rate stays the same. FDIC insurance covers up to $250,000 per depositor, per bank, per ownership category. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growth', 'fields' => ['start', 'rate', 'years', 'compound', 'contribution']]"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Starting amount, rate, years and any regular deposits.'],
        ['name' => 'Choose the compounding', 'text' => 'How often interest is added.'],
        ['name' => 'Read the result', 'text' => 'The balance, a year-by-year table and a chart.'],
    ]"
    :faqs="[
        ['question' => 'What do $25,000 and $500 a month become in 3 years at 4.2%?', 'answer' => '$47,506.40.'],
        ['question' => 'How much interest does $100,000 earn in a year?', 'answer' => '$4,289.20.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Initial deposit" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual interest rate" value="4.2" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="3" min="0" step="any" suffix="years" />
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="365" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="contribution" label="Monthly deposit" value="500" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Future balance" />

    <x-calc.options :decimals="false" :examples="[
        'Typical' => ['start' => 25000, 'rate' => 4.2, 'compound' => '365', 'years' => 3, 'contribution' => 500],
        'Parked cash' => ['start' => 100000, 'rate' => 4.2, 'compound' => '365', 'years' => 1, 'contribution' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'deposits' => ['label' => 'Total deposits'],
            'interest' => ['label' => 'Interest earned'],
            'effective' => ['label' => 'Effective annual rate'],
            'real' => ['label' => 'In today\'s money'],
            'share' => ['label' => 'Growth share'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = P(1 + r/n)^(nt)</li>
            <li>deposits: PMT × [(1 + i)^N − 1] ÷ i</li>
            <li>i = (1 + r/n)^(n/p) − 1 per deposit period</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
