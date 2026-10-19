<x-calc.page
    title="Options Spread Calculator - SolveKit"
    description="Free options spread calculator: payoff, maximum profit and loss and break-evens at expiry for verticals, straddles, strangles, butterflies, iron condors or any legs you enter."
    lede="Analyze an options strategy at expiry."
    about="Each leg's profit at expiry is ± contracts × 100 × (intrinsic value − premium); the strategy adds them. Enter Call or Put, Buy or Sell, strike, premium and contracts for each leg; the examples load common strategies. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'spread', 'fields' => ['legs', 'price']]"
    :how-to="[
        ['name' => 'Enter the legs', 'text' => 'Or load a strategy.'],
        ['name' => 'Read the payoff', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What can a 100/110 bull call spread for $3.40 make?', 'answer' => '$660.00 at most, −$340.00 at worst.'],
        ['question' => 'Where does a long straddle break even?', 'answer' => '$91.50, $108.50.'],
        ['question' => 'And an iron condor?', 'answer' => 'Maximum profit $160.00; maximum loss −$340.00.'],
    ]"
>
    <x-calc.rows-editor name="legs" label="Legs" :columns="['type' => 'Call/Put', 'side' => 'Buy/Sell', 'strike' => 'Strike', 'premium' => 'Premium', 'qty' => 'Contracts']" :rows="[['Call', 'Buy', 100, 5.2, 1], ['Call', 'Sell', 110, 1.8, 1]]" :text="['type', 'side']" />

    <x-calc.field name="price" label="Stock price at expiry (optional)" value="" step="0.01" suffix="$" />

    <x-calc.result label="Maximum profit" />

    <x-calc.options :decimals="false" :examples="[
        'Bull call spread' => ['legs' => 'Call	Buy	100	5.2	1
Call	Sell	110	1.8	1', 'price' => ''],
        'Long straddle' => ['legs' => 'Call	Buy	100	4.5	1
Put	Buy	100	4	1', 'price' => ''],
        'Iron condor' => ['legs' => 'Put	Buy	85	0.6	1
Put	Sell	90	1.4	1
Call	Sell	110	1.5	1
Call	Buy	115	0.7	1', 'price' => ''],
        'Butterfly' => ['legs' => 'Call	Buy	95	7	1
Call	Sell	100	4	2
Call	Buy	105	2	1', 'price' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Payoff at expiry" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'max_profit' => ['label' => 'Maximum profit'],
            'max_loss' => ['label' => 'Maximum loss'],
            'breakeven' => ['label' => 'Break-evens'],
            'legs' => ['label' => 'Legs'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>profit = Σ side × contracts × 100 × (intrinsic − premium)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
