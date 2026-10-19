<x-calc.page
    title="Compound Interest Calculator - SolveKit"
    description="Free compound interest calculator: future value with any compounding, regular deposits made at the start or end of each period, yearly deposit increases and inflation, with a year-by-year table."
    lede="See how a deposit and regular savings grow with compound interest."
    about="Compound interest adds interest to the balance, so later interest is earned on earlier interest: A = P(1 + r/n)^(nt) for a lump sum. Regular deposits add the future value of an annuity. When deposits and compounding differ (say monthly deposits, daily compounding) the rate per deposit period is (1 + r/n)^(n/p) − 1. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growth', 'fields' => ['start', 'rate', 'years', 'compound', 'contribution', 'per', 'timing', 'increase', 'inflation']]"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Starting amount, rate, years and any regular deposits.'],
        ['name' => 'Choose the compounding', 'text' => 'How often interest is added.'],
        ['name' => 'Read the result', 'text' => 'The balance, a year-by-year table and a chart.'],
    ]"
    :faqs="[
        ['question' => 'What does $10,000 grow to at 5% compounded monthly for 10 years?', 'answer' => '$16,470.09, of which $6,470.09 is interest.'],
        ['question' => 'And with $200 a month added?', 'answer' => '$47,526.55: $34,000.00 deposited and $13,526.55 of interest.'],
        ['question' => 'Does compounding frequency matter much?', 'answer' => 'A little: 5% compounded monthly is an effective 5.116% a year; daily adds only a few hundredths more.'],
        ['question' => 'What is the difference between start and end deposits?', 'answer' => 'Deposits at the start of each period earn one more period of interest (an annuity due).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Initial deposit" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual interest rate" value="5" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="12" />
        <x-calc.field name="contribution" label="Regular deposit" value="200" step="0.01" suffix="$" />
        <x-calc.select name="per" label="Deposit frequency" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="timing" label="Deposits made at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
        <x-calc.field name="increase" label="Yearly increase in deposits" value="0" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Inflation (optional)" value="" step="any" suffix="%" />
    </div>

    <x-calc.result label="Future balance" />

    <x-calc.options :decimals="false" :examples="[
        'Lump sum' => ['start' => 10000, 'rate' => 5, 'compound' => '12', 'years' => 10, 'contribution' => 0, 'per' => '12', 'timing' => 'end', 'increase' => 0, 'inflation' => ''],
        '$200 a month' => ['start' => 10000, 'rate' => 5, 'compound' => '12', 'years' => 10, 'contribution' => 200, 'per' => '12', 'timing' => 'end', 'increase' => 0, 'inflation' => ''],
        'Daily, 30 years' => ['start' => 5000, 'rate' => 7, 'compound' => '365', 'years' => 30, 'contribution' => 500, 'per' => '12', 'timing' => 'start', 'increase' => 2, 'inflation' => 2.5],
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
