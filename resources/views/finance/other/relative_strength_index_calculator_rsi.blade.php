<x-calc.page
    title="Relative Strength Index Calculator (RSI) - SolveKit"
    description="Free RSI calculator: Wilder's relative strength index from a list of closing prices for any period, with overbought and oversold readings."
    lede="Calculate the RSI of a price series."
    about="RSI = 100 − 100 ÷ (1 + average gain ÷ average loss). Wilder's method starts with simple averages over the first n changes, then smooths: average = (previous × (n − 1) + current) ÷ n. Above 70 is commonly read as overbought, below 30 oversold. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'rsi', 'fields' => ['prices', 'period']]"
    :how-to="[
        ['name' => 'Paste closing prices', 'text' => 'At least period + 1.'],
        ['name' => 'Choose the period', 'text' => '14 is standard.'],
    ]"
    :faqs="[
        ['question' => 'What is the 14-day RSI of the sample prices?', 'answer' => '57.92.'],
    ]"
>
    <x-calc.textarea name="prices" label="Closing prices, oldest first" value="44.34, 44.09, 44.15, 43.61, 44.33, 44.83, 45.10, 45.42, 45.84, 46.08, 45.89, 46.03, 45.61, 46.28, 46.28, 46.00, 46.03, 46.41, 46.22, 45.64" rows="4" />

    <x-calc.field name="period" label="Period" value="14" min="2" step="1" />

    <x-calc.result label="RSI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['prices' => '44.34, 44.09, 44.15, 43.61, 44.33, 44.83, 45.10, 45.42, 45.84, 46.08, 45.89, 46.03, 45.61, 46.28, 46.28, 46.00, 46.03, 46.41, 46.22, 45.64', 'period' => 14],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="RSI" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'previous' => ['label' => 'Previous RSI'],
            'high' => ['label' => 'Highest'],
            'low' => ['label' => 'Lowest'],
            'count' => ['label' => 'RSI values'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RSI = 100 − 100 ÷ (1 + RS)</li>
            <li>RS = avg gain ÷ avg loss (Wilder smoothing)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
