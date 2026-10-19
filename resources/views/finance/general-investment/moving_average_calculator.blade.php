<x-calc.page
    title="Moving Average Calculator - SolveKit"
    description="Free moving average calculator: simple, weighted and exponential moving averages of a price series for any window, with a chart."
    lede="Calculate SMA, WMA and EMA of a series."
    about="SMA = average of the last n values. WMA weights them 1…n, newest heaviest. EMA = α × price + (1 − α) × previous EMA, with α = 2 ÷ (n + 1), starting from the first SMA. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'moving_average', 'fields' => ['prices', 'window']]"
    :how-to="[
        ['name' => 'Paste the series', 'text' => 'Oldest first.'],
        ['name' => 'Choose the window', 'text' => 'For example 5, 20 or 50 periods.'],
    ]"
    :faqs="[
        ['question' => 'What is the 5-period SMA of the example prices?', 'answer' => '23.96; EMA 23.98.'],
    ]"
>
    <x-calc.textarea name="prices" label="Values in order (one per line or comma-separated)" value="22.3, 22.5, 22.1, 22.8, 23.4, 23.1, 23.9, 24.2, 24.0, 24.6" rows="4" />

    <x-calc.field name="window" label="Window (periods)" value="5" min="1" step="1" />

    <x-calc.result label="Simple moving average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['prices' => '22.3, 22.5, 22.1, 22.8, 23.4, 23.1, 23.9, 24.2, 24.0, 24.6', 'window' => 5],
        '3-period' => ['prices' => '10, 11, 12, 13, 14, 15', 'window' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Series and SMA" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'wma' => ['label' => 'Weighted (WMA)'],
            'ema' => ['label' => 'Exponential (EMA)'],
            'alpha' => ['label' => 'EMA smoothing α'],
            'latest' => ['label' => 'Latest value'],
        ]" />
        <x-calc.quick-ref heading="By period" name="averages" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SMA = Σ last n ÷ n</li>
            <li>EMA = αP + (1 − α)EMA₋₁, α = 2 ÷ (n + 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
