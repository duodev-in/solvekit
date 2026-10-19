<x-calc.page
    title="Call Option Calculator - SolveKit"
    description="Free call option calculator: profit or loss at expiry for buying or selling calls, break-even, maximum profit and loss, with a payoff chart."
    lede="See the payoff of a call option at expiry."
    about="A long call is worth max(0, S − K) at expiry; profit subtracts the premium. Break-even = strike + premium. A short (written) call has the opposite payoff and unlimited risk if uncovered. US equity contracts cover 100 shares. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'call_option', 'fields' => ['side', 'strike', 'premium', 'contracts', 'price']]"
    :how-to="[
        ['name' => 'Choose long or short', 'text' => ''],
        ['name' => 'Enter strike, premium and expiry price', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a $150 call bought for $5 make if the stock ends at $165?', 'answer' => '$1,000.00.'],
        ['question' => 'What is the break-even?', 'answer' => '$155.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="side" label="Position" :options="['long' => 'Buy (long)', 'short' => 'Sell (short)']" selected="long" />
        <x-calc.field name="strike" label="Strike" value="150" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="premium" label="Premium per share" value="5" step="0.01" suffix="$" />
        <x-calc.field name="contracts" label="Contracts" value="1" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Stock price at expiry" value="165" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Profit or loss" />

    <x-calc.options :decimals="false" :examples="[
        'Long' => ['side' => 'long', 'strike' => 150, 'premium' => 5, 'contracts' => 1, 'price' => 165],
        'Short' => ['side' => 'short', 'strike' => 150, 'premium' => 5, 'contracts' => 1, 'price' => 165],
        'Expires worthless' => ['side' => 'long', 'strike' => 150, 'premium' => 5, 'contracts' => 2, 'price' => 140],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Payoff at expiry" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'breakeven' => ['label' => 'Break-even'],
            'max_profit' => ['label' => 'Maximum profit'],
            'max_loss' => ['label' => 'Maximum loss'],
            'intrinsic' => ['label' => 'Intrinsic value'],
            'premium' => ['label' => 'Premium'],
            'roi' => ['label' => 'Return on premium'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>long: 100 × [max(0, S − K) − premium]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
