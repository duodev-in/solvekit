<x-calc.page
    title="Savings Calculator - SolveKit"
    description="Free savings calculator: savings balance from an opening deposit and monthly savings at your account's interest rate, compounded daily, monthly or yearly."
    lede="See how your savings grow with interest."
    about="Interest on a savings account compounds at the account's frequency, usually daily or monthly, and US banks quote the APY, which already includes compounding. Enter the APR (nominal rate) with its compounding, or the APY with annual compounding. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growth', 'fields' => ['start', 'rate', 'years', 'compound', 'contribution', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Starting amount, rate, years and any regular deposits.'],
        ['name' => 'Choose the compounding', 'text' => 'How often interest is added.'],
        ['name' => 'Read the result', 'text' => 'The balance, a year-by-year table and a chart.'],
    ]"
    :faqs="[
        ['question' => 'What do $5,000 and $250 a month become in 5 years at 4% compounded daily?', 'answer' => '$22,684.40.'],
        ['question' => 'And without monthly deposits?', 'answer' => '$6,106.95.'],
        ['question' => 'What does $50 a week save in 3 years at 3.5%?', 'answer' => '$8,220.81.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Initial deposit" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual interest rate" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="5" min="0" step="any" suffix="years" />
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="365" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="contribution" label="Deposit each period" value="250" step="0.01" suffix="$" />
        <x-calc.select name="per" label="Deposit frequency" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Deposits made at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Future balance" />

    <x-calc.options :decimals="false" :examples="[
        'High-yield account' => ['start' => 5000, 'rate' => 4, 'compound' => '365', 'years' => 5, 'contribution' => 250, 'per' => '12', 'timing' => 'end'],
        'No deposits' => ['start' => 5000, 'rate' => 4, 'compound' => '365', 'years' => 5, 'contribution' => 0, 'per' => '12', 'timing' => 'end'],
        'Weekly savings' => ['start' => 0, 'rate' => 3.5, 'compound' => '12', 'years' => 3, 'contribution' => 50, 'per' => '52', 'timing' => 'end'],
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
