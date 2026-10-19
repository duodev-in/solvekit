<x-calc.page
    title="Bitcoin ETF Calculator - SolveKit"
    description="Free bitcoin ETF calculator: value of a spot bitcoin ETF investment under a bitcoin price assumption, after the fund's expense ratio, compared with holding bitcoin directly."
    lede="Estimate a bitcoin ETF holding after fees."
    about="A spot bitcoin ETF holds bitcoin and charges an expense ratio (US spot funds launched in 2024 charge about 0.15–0.25%; GBTC about 1.5%). The value follows bitcoin less the fee each year. Enter your own price assumption: bitcoin is highly volatile and no rate is predictable. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'bitcoin_etf', 'fields' => ['amount', 'growth', 'fee', 'years', 'price']]"
    :how-to="[
        ['name' => 'Enter the amount and fee', 'text' => 'From the fund page.'],
        ['name' => 'Choose a price assumption', 'text' => 'Try several, including losses.'],
    ]"
    :faqs="[
        ['question' => 'What is $10,000 worth after 5 years if bitcoin rises 10% a year and the fee is 0.25%?', 'answer' => '$15,904.79; fees $200.31.'],
        ['question' => 'And if bitcoin falls 20% a year?', 'answer' => '$3,236.04.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount invested" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="growth" label="Assumed bitcoin change a year" value="10" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fee" label="Expense ratio" value="0.25" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="5" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="ETF share price (optional)" value="50" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="ETF value" />

    <x-calc.options :decimals="false" :examples="[
        'Rising' => ['amount' => 10000, 'growth' => 10, 'fee' => 0.25, 'years' => 5, 'price' => 50],
        'Falling' => ['amount' => 10000, 'growth' => -20, 'fee' => 0.25, 'years' => 5, 'price' => 50],
        'High fee' => ['amount' => 10000, 'growth' => 10, 'fee' => 1.5, 'years' => 5, 'price' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'direct' => ['label' => 'Holding bitcoin directly'],
            'fees' => ['label' => 'Fees'],
            'shares' => ['label' => 'Shares bought'],
            'change' => ['label' => 'Total change'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = A[(1 + g)(1 − fee)]^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
