<x-calc.page
    title="Simple Savings Calculator - SolveKit"
    description="Free simple savings calculator: how much a deposit and a monthly amount grow to at an interest rate, in three fields."
    lede="Quick savings estimate: deposit, monthly amount, rate."
    about="A quick estimate with monthly compounding and monthly deposits. Use the full Savings Calculator for other compounding or deposit frequencies. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growth', 'fields' => ['start', 'rate', 'years', 'contribution']]"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Starting amount, rate, years and any regular deposits.'],
        ['name' => 'Choose the compounding', 'text' => 'How often interest is added.'],
        ['name' => 'Read the result', 'text' => 'The balance, a year-by-year table and a chart.'],
    ]"
    :faqs="[
        ['question' => 'What do $1,000 and $100 a month grow to in 5 years at 4%?', 'answer' => '$7,850.89.'],
        ['question' => 'And $10,000 plus $500 a month for 10 years at 4.5%?', 'answer' => '$91,268.96.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Initial deposit" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual interest rate" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="5" min="0" step="any" suffix="years" />
        <x-calc.field name="contribution" label="Monthly deposit" value="100" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Future balance" />

    <x-calc.options :decimals="false" :examples="[
        'Starter' => ['start' => 1000, 'rate' => 4, 'years' => 5, 'contribution' => 100],
        'Bigger' => ['start' => 10000, 'rate' => 4.5, 'years' => 10, 'contribution' => 500],
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
