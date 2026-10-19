<x-calc.page
    title="Put Option Calculator - SolveKit"
    description="Free put option calculator: profit or loss at expiry for buying or selling puts, break-even and maximum profit and loss, with a payoff chart."
    lede="See the payoff of a put option at expiry."
    about="A long put is worth max(0, K − S) at expiry; profit subtracts the premium. Break-even = strike − premium. The most a long put can make is the strike minus the premium (if the stock goes to zero). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'put_option', 'fields' => ['side', 'strike', 'premium', 'contracts', 'price']]"
    :how-to="[
        ['name' => 'Choose long or short', 'text' => ''],
        ['name' => 'Enter strike, premium and expiry price', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a $100 put bought for $4 make if the stock ends at $88?', 'answer' => '$800.00.'],
        ['question' => 'What is the most it can make?', 'answer' => '$9,600.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="side" label="Position" :options="['long' => 'Buy (long)', 'short' => 'Sell (short)']" selected="long" />
        <x-calc.field name="strike" label="Strike" value="100" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="premium" label="Premium per share" value="4" step="0.01" suffix="$" />
        <x-calc.field name="contracts" label="Contracts" value="1" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Stock price at expiry" value="88" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Profit or loss" />

    <x-calc.options :decimals="false" :examples="[
        'Long' => ['side' => 'long', 'strike' => 100, 'premium' => 4, 'contracts' => 1, 'price' => 88],
        'Short put' => ['side' => 'short', 'strike' => 100, 'premium' => 4, 'contracts' => 1, 'price' => 105],
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
            <li>long: 100 × [max(0, K − S) − premium]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
