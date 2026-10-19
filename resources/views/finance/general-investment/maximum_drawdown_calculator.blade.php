<x-calc.page
    title="Maximum Drawdown Calculator - SolveKit"
    description="Free maximum drawdown calculator: the largest peak-to-trough fall in a series of prices or portfolio values, with the peak, trough and recovery."
    lede="Find the worst peak-to-trough fall."
    about="Maximum drawdown = the lowest value of (value ÷ running peak − 1). It measures the worst loss an investor buying at a peak would have suffered before a new high. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'max_drawdown', 'fields' => ['prices']]"
    :how-to="[
        ['name' => 'Paste the values', 'text' => 'In time order.'],
        ['name' => 'Read the drawdown', 'text' => 'With its chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the maximum drawdown of 100, 112, 105, 120, 96, 88, 101, 118, 125?', 'answer' => '−26.67%, from 120 to 88.'],
        ['question' => 'What was the S&P 500 drawdown in 2007–09?', 'answer' => 'About −57%, from 1,565 to 677 (closing values).'],
    ]"
>
    <x-calc.textarea name="prices" label="Prices or values in order (one per line or comma-separated)" value="100, 112, 105, 120, 96, 88, 101, 118, 125" rows="4" />

    <x-calc.result label="Maximum drawdown" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['prices' => '100, 112, 105, 120, 96, 88, 101, 118, 125'],
        'S&P 500 2007–09' => ['prices' => '1565.15, 1400, 1300, 1100, 900, 676.53, 900, 1100'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Values" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'peak' => ['label' => 'Peak'],
            'trough' => ['label' => 'Trough'],
            'recovery' => ['label' => 'Recovery'],
            'total' => ['label' => 'Total change'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MDD = min(Vₜ ÷ max(V₀…Vₜ) − 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
