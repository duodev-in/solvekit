<x-calc.page
    title="Odds Calculator - SolveKit"
    description="Free odds calculator: convert between decimal, fractional and moneyline odds and probability, with payout and profit."
    lede="Convert odds."
    about="Odds come in several formats that all describe the same chance. Decimal odds give the total return per unit staked, fractional odds the profit, and moneyline odds the US convention. Also known as Decimal Odds Calculator, Fractional Odds Calculator and Moneyline Odds Calculator."
    :calc="['engine' => 'st-prob', 'tool' => 'odds', 'fields' => ['odds', 'stake'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is 3/2 as a probability?', 'answer' => '40% (2.5 decimal, +150 moneyline).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="odds" label="Odds (2.5, 3/2, “3 to 2”, +150, −200 or 40%)" value="3/2" type="text" inputmode="text" />
        <x-calc.field name="stake" label="Stake" value="10" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Implied probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['odds' => '3/2', 'stake' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal odds'],
            'fractional' => ['label' => 'Fractional odds'],
            'moneyline' => ['label' => 'Moneyline (American)'],
            'against' => ['label' => 'Odds against'],
            'payout' => ['label' => 'Payout if it wins'],
            'profit' => ['label' => 'Profit if it wins'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
