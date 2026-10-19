<x-calc.page
    title="Stock Calculator - SolveKit"
    description="Free stock profit calculator: profit or loss, return and break-even price on a trade including commissions, before and after tax."
    lede="Work out profit on a stock trade."
    about="Profit = shares × (sell − buy) − commissions. Break-even = (cost + selling fee) ÷ shares. Gains on shares held over a year are long-term in the US (0/15/20%); shorter holdings are taxed as income. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'stock', 'fields' => ['shares', 'buy', 'sell', 'buy_fee', 'sell_fee', 'tax']]"
    :how-to="[
        ['name' => 'Enter shares and prices', 'text' => ''],
        ['name' => 'Add commissions and tax', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the profit on 100 shares bought at $50 and sold at $62?', 'answer' => '$1,200.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="shares" label="Shares" value="100" min="0" step="any" />
        <x-calc.field name="buy" label="Buy price" value="50" step="0.01" suffix="$" />
        <x-calc.field name="sell" label="Sell price" value="62" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="buy_fee" label="Buy commission" value="0" step="0.01" suffix="$" />
        <x-calc.field name="sell_fee" label="Sell commission" value="0" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Tax rate on the gain" value="15" step="any" suffix="%" />
    </div>

    <x-calc.result label="Profit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['shares' => 100, 'buy' => 50, 'sell' => 62, 'buy_fee' => 0, 'sell_fee' => 0, 'tax' => 15],
        'Loss' => ['shares' => 200, 'buy' => 30, 'sell' => 24.5, 'buy_fee' => 4.95, 'sell_fee' => 4.95, 'tax' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cost' => ['label' => 'Total cost'],
            'proceeds' => ['label' => 'Proceeds'],
            'breakeven' => ['label' => 'Break-even price'],
            'after' => ['label' => 'After tax'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>profit = n(sell − buy) − fees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
