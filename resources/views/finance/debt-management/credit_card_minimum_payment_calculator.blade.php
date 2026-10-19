<x-calc.page
    title="Credit Card Minimum Payment Calculator - SolveKit"
    description="Free credit card minimum payment calculator: how long minimum payments take to clear a balance and how much interest they cost."
    lede="See the real cost of paying only the minimum."
    about="Issuers commonly set the minimum at 1% of the balance plus that month's interest (or 2–3% of the balance), with a floor of about $25–35. Because the minimum falls as the balance falls, payoff takes years. Statements must show this (Credit CARD Act of 2009). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'card_minimum', 'fields' => ['balance', 'apr', 'percent', 'floor', 'plus_interest']]"
    :how-to="[
        ['name' => 'Enter the balance and APR', 'text' => ''],
        ['name' => 'Enter your card\'s minimum rule', 'text' => 'From the cardholder agreement.'],
    ]"
    :faqs="[
        ['question' => 'How long do minimum payments take on $6,000 at 23.99%?', 'answer' => '21 years, costing $10,882.14 of interest.'],
        ['question' => 'What if I keep paying the first minimum?', 'answer' => 'Keep paying $179.95: 4 years 8 months, $3,985.33 interest.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Card balance" value="6000" step="0.01" suffix="$" />
        <x-calc.field name="apr" label="APR" value="23.99" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="percent" label="Minimum: % of balance" value="1" step="any" suffix="%" />
        <x-calc.field name="floor" label="Minimum floor" value="25" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="plus_interest" label="Plus that month's interest" :checked="true" />

    <x-calc.result label="Time to pay off with minimums" />

    <x-calc.options :decimals="false" :examples="[
        '1% + interest' => ['balance' => 6000, 'apr' => 23.99, 'percent' => 1, 'floor' => 25, 'plus_interest' => true],
        '3% of balance' => ['balance' => 6000, 'apr' => 23.99, 'percent' => 3, 'floor' => 25, 'plus_interest' => false],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'first' => ['label' => 'First minimum payment'],
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
            'fixed' => ['label' => 'Paying the first minimum every month'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>minimum = max(floor, % × B + interest)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
