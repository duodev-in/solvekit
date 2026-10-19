<x-calc.page
    title="Savings Plan Calculator - SolveKit"
    description="Free savings plan calculator: a year-by-year plan of deposits, interest and balance for regular saving, with deposits rising each year."
    lede="Plan regular saving year by year."
    about="A savings plan adds the same deposit each month (optionally rising each year) and earns interest monthly. The table shows deposits, interest and the balance at the end of each year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growth', 'fields' => ['start', 'rate', 'years', 'compound', 'contribution', 'increase']]"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Starting amount, rate, years and any regular deposits.'],
        ['name' => 'Choose the compounding', 'text' => 'How often interest is added.'],
        ['name' => 'Read the result', 'text' => 'The balance, a year-by-year table and a chart.'],
    ]"
    :faqs="[
        ['question' => 'What does saving $300 a month, rising 2% a year, give in 10 years at 4.5%?', 'answer' => '$49,304.83.'],
        ['question' => 'And without the yearly increase?', 'answer' => '$45,359.42.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Initial deposit" value="0" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual interest rate" value="4.5" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="12" />
        <x-calc.field name="contribution" label="Monthly deposit" value="300" step="0.01" suffix="$" />
        <x-calc.field name="increase" label="Yearly increase in deposits" value="2" step="any" suffix="%" />
    </div>

    <x-calc.result label="Future balance" />

    <x-calc.options :decimals="false" :examples="[
        '$300 a month' => ['start' => 0, 'rate' => 4.5, 'years' => 10, 'contribution' => 300, 'increase' => 2, 'compound' => '12'],
        'Flat deposits' => ['start' => 0, 'rate' => 4.5, 'years' => 10, 'contribution' => 300, 'increase' => 0, 'compound' => '12'],
        'Short plan' => ['start' => 1000, 'rate' => 4, 'years' => 2, 'contribution' => 150, 'increase' => 0, 'compound' => '12'],
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
