<x-calc.page
    title="Investment Calculator - SolveKit"
    description="Free investment calculator: what an investment grows to with monthly contributions, an expected return, yearly contribution increases and inflation, with a balance chart."
    lede="Project an investment with regular contributions."
    about="The balance grows by the expected annual return, compounded monthly, with contributions added each month. Real returns vary from year to year; a steady average rate gives a planning estimate, not a forecast. Enter inflation to see the result in today's money. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growth', 'fields' => ['start', 'rate', 'years', 'compound', 'contribution', 'timing', 'increase', 'inflation']]"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Starting amount, rate, years and any regular deposits.'],
        ['name' => 'Choose the compounding', 'text' => 'How often interest is added.'],
        ['name' => 'Read the result', 'text' => 'The balance, a year-by-year table and a chart.'],
    ]"
    :faqs="[
        ['question' => 'What will $20,000 plus $500 a month become in 25 years at 7%?', 'answer' => '$646,612.00 with deposits rising 3% a year; $348,776.43 in today\'s money (2.5% inflation).'],
        ['question' => 'And at a cautious 4%?', 'answer' => '$311,340.08.'],
        ['question' => 'What does $300 a month for 40 years at 7% give?', 'answer' => '$787,444.02 from $144,000.00 of deposits.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting amount" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Expected annual return" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="25" min="0" step="any" suffix="years" />
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="contribution" label="Monthly contribution" value="500" step="0.01" suffix="$" />
        <x-calc.select name="timing" label="Deposits made at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="increase" label="Contribution increase a year" value="3" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Inflation (optional)" value="2.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Future balance" />

    <x-calc.options :decimals="false" :examples="[
        'Typical' => ['start' => 20000, 'rate' => 7, 'years' => 25, 'contribution' => 500, 'timing' => 'end', 'increase' => 3, 'inflation' => 2.5, 'compound' => '12'],
        'Cautious' => ['start' => 20000, 'rate' => 4, 'years' => 25, 'contribution' => 500, 'timing' => 'end', 'increase' => 0, 'inflation' => 2.5, 'compound' => '12'],
        'Start from zero' => ['start' => 0, 'rate' => 7, 'years' => 40, 'contribution' => 300, 'timing' => 'end', 'increase' => 0, 'inflation' => '', 'compound' => '12'],
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
