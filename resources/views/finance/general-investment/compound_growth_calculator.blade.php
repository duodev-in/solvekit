<x-calc.page
    title="Compound Growth Calculator - SolveKit"
    description="Free compound growth calculator: grow any value at a steady yearly rate, with optional yearly additions, and see the path year by year."
    lede="Project a value growing at a constant rate."
    about="Compound growth applies a percentage to the latest value each year: V = V₀(1 + g)^t. It describes savings, sales, users or prices growing at a steady rate. Yearly additions are added at the end of each year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growth', 'fields' => ['start', 'rate', 'years', 'compound', 'contribution'], 'per' => '1']"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Starting amount, rate, years and any regular deposits.'],
        ['name' => 'Choose the compounding', 'text' => 'How often interest is added.'],
        ['name' => 'Read the result', 'text' => 'The balance, a year-by-year table and a chart.'],
    ]"
    :faqs="[
        ['question' => 'What does 1,000 become at 8% a year for 20 years?', 'answer' => '$4,660.96.'],
        ['question' => 'How long does doubling take at 8%?', 'answer' => 'About 9 years (Rule of 72: 72 ÷ 8).'],
        ['question' => 'What about 15% for 5 years on 250,000?', 'answer' => '$502,839.30.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting value" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Growth rate a year" value="8" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="20" min="0" step="any" suffix="years" />
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="contribution" label="Added each year" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Future balance" />

    <x-calc.options :decimals="false" :examples="[
        '1,000 at 8%' => ['start' => 1000, 'rate' => 8, 'years' => 20, 'contribution' => 0, 'compound' => '1'],
        'Sales at 15%' => ['start' => 250000, 'rate' => 15, 'years' => 5, 'contribution' => 0, 'compound' => '1'],
        'With additions' => ['start' => 1000, 'rate' => 6, 'years' => 15, 'contribution' => 1000, 'compound' => '1'],
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
            <li>V = V₀ (1 + g)^t</li>
            <li>with additions: + A × [(1 + g)^t − 1] ÷ g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
