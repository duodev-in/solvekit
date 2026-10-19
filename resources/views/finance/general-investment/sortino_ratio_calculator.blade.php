<x-calc.page
    title="Sortino Ratio Calculator - SolveKit"
    description="Free Sortino ratio calculator: excess return over a target per unit of downside deviation, from a list of returns, with the Sharpe-style ratio for comparison."
    lede="Measure return per unit of downside risk."
    about="Sortino = (average return − target) ÷ downside deviation, where downside deviation = √(Σ min(0, Rₜ − T)² ÷ n). Only returns below the target count as risk. Use returns of one period length (monthly or yearly) consistently. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'sortino', 'fields' => ['returns', 'target']]"
    :how-to="[
        ['name' => 'Paste the returns', 'text' => 'In %, one period length.'],
        ['name' => 'Set the target', 'text' => 'Often 0 or the risk-free rate.'],
    ]"
    :faqs="[
        ['question' => 'What is the Sortino ratio of 5, −2, 8, 3, −4, 6, 1, 7 with a 0% target?', 'answer' => '1.897.'],
    ]"
>
    <x-calc.textarea name="returns" label="Returns in % (one per line or comma-separated)" value="5, -2, 8, 3, -4, 6, 1, 7" rows="3" />

    <x-calc.field name="target" label="Target return per period" value="0" step="any" suffix="%" />

    <x-calc.result label="Sortino ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['returns' => '5, -2, 8, 3, -4, 6, 1, 7', 'target' => 0],
        'Target 2%' => ['returns' => '5, -2, 8, 3, -4, 6, 1, 7', 'target' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mean' => ['label' => 'Average return'],
            'downside' => ['label' => 'Downside deviation'],
            'sd' => ['label' => 'Standard deviation'],
            'sharpe' => ['label' => 'Same with standard deviation'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Sortino = (R̄ − T) ÷ √(Σ min(0, Rₜ − T)² ÷ n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
