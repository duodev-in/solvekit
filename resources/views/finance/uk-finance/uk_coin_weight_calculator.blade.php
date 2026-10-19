<x-calc.page
    title="UK Coin Weight Calculator - SolveKit"
    description="Free UK coin weight calculator: the value of a bag of coins from its weight, or the weight of an amount, using Royal Mint coin weights and standard bag values."
    lede="Count UK coins by weight."
    about="Each coin type has a fixed weight (Royal Mint): 1p 3.56 g, 2p 7.12 g, 5p 3.25 g, 10p 6.5 g, 20p 5 g, 50p 8 g, £1 8.75 g, £2 12 g. Banks use standard bags: £1 of 1p or 2p, £5 of 5p or 10p, £10 of 20p or 50p, £20 of £1 or £2. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'uk_coins', 'fields' => ['mode', 'coin', 'grams', 'amount'], 'data' => ['uk' => config('finance_data.uk')], 'sym' => 'GBP', 'currency' => 'GBP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Choose the coin', 'text' => ''],
        ['name' => 'Enter weight or value', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are 250 g of 20p coins worth?', 'answer' => '£10.00.'],
        ['question' => 'How much does £20 of £1 coins weigh?', 'answer' => '0.175 kg.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['weight' => 'Value from weight', 'value' => 'Weight from value']" selected="weight" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="coin" label="Coin" :options="['1p' => '1p', '2p' => '2p', '5p' => '5p', '10p' => '10p', '20p' => '20p', '50p' => '50p', '£1' => '£1', '£2' => '£2']" selected="20p" />
        <x-calc.field name="grams" label="Weight (grams)" value="250" min="0" step="any" />
        <x-calc.field name="amount" label="Value" value="10" step="0.01" suffix="£" />
    </div>

    <x-calc.result label="Value of the coins" />

    <x-calc.options :decimals="false" :examples="[
        '20p by weight' => ['mode' => 'weight', 'coin' => '20p', 'grams' => 250, 'amount' => ''],
        '£1 bag' => ['mode' => 'value', 'coin' => '£1', 'grams' => '', 'amount' => 20],
        '1p jar' => ['mode' => 'weight', 'coin' => '1p', 'grams' => 1780, 'amount' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'count' => ['label' => 'Coins'],
            'bag' => ['label' => 'Standard bag'],
            'grams' => ['label' => 'Coin weight'],
            'check' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = weight ÷ coin weight × face value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
