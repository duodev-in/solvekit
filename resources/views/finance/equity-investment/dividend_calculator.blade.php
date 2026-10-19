<x-calc.page
    title="Dividend Calculator - SolveKit"
    description="Free dividend calculator: yearly and per-payment dividend income, dividend yield and growth with dividends reinvested (DRIP)."
    lede="Work out your dividend income."
    about="Dividend income = shares × dividend per share. With reinvestment, each year's dividends buy more shares at that year's price, so income compounds. Qualified dividends are taxed at 0/15/20% in the US. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'dividend', 'fields' => ['shares', 'dps', 'freq', 'price', 'growth', 'appreciation', 'years']]"
    :how-to="[
        ['name' => 'Enter shares and dividend', 'text' => ''],
        ['name' => 'Add price and growth', 'text' => 'For reinvestment.'],
    ]"
    :faqs="[
        ['question' => 'How much do 500 shares paying $3.20 a year earn?', 'answer' => '$1,600.00, a yield of 4%.'],
        ['question' => 'What after 10 years of reinvesting?', 'answer' => '752.85 shares worth $89,152.56 after 10 years, paying $3,924.22 a year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shares" label="Shares" value="500" min="0" step="any" />
        <x-calc.field name="dps" label="Annual dividend per share" value="3.2" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="freq" label="Paid" :options="['4' => 'Quarterly', '12' => 'Monthly', '2' => 'Semi-annually', '1' => 'Annually']" selected="4" />
        <x-calc.field name="price" label="Share price" value="80" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="growth" label="Dividend growth a year" value="5" step="any" suffix="%" />
        <x-calc.field name="appreciation" label="Price growth a year" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Reinvest for" value="10" min="0" step="1" suffix="years" />
    </div>

    <x-calc.result label="Dividends a year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['shares' => 500, 'dps' => 3.2, 'freq' => '4', 'price' => 80, 'growth' => 5, 'appreciation' => 4, 'years' => 10],
        'Monthly payer' => ['shares' => 1000, 'dps' => 0.96, 'freq' => '12', 'price' => 14, 'growth' => 1, 'appreciation' => 1, 'years' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'yield' => ['label' => 'Dividend yield'],
            'monthly' => ['label' => 'Per month'],
            'drip' => ['label' => 'With reinvestment'],
            'cost' => ['label' => 'Value of the holding'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>income = shares × DPS</li>
            <li>DRIP: shares += shares × DPS ÷ price each year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
