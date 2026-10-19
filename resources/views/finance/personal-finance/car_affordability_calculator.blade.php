<x-calc.page
    title="Car Affordability Calculator - SolveKit"
    description="Free car affordability calculator: the most expensive car a monthly payment budget can buy, after sales tax, fees, down payment and trade-in."
    lede="Find how much car you can afford."
    about="The loan a payment supports is PMT × [1 − (1 + r)^−n] ÷ r. Adding the down payment and trade-in and removing tax and fees gives the price. A common guideline keeps car payments under 10–15% of take-home pay. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'car_affordability', 'fields' => ['payment', 'down', 'trade', 'tax', 'fees', 'rate', 'months', 'income']]"
    :how-to="[
        ['name' => 'Enter your budget', 'text' => ''],
        ['name' => 'Enter down payment, tax, rate and term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much car does $500 a month buy over 60 months at 7% with $4,000 down?', 'answer' => '$26,590.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Monthly payment budget" value="500" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="4000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="trade" label="Trade-in value" value="0" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Sales tax" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fees" label="Fees" value="800" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="months" label="Term" value="60" min="0" step="1" suffix="months" />
        <x-calc.field name="income" label="Gross yearly income (optional)" value="70000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Car price you can afford" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['payment' => 500, 'down' => 4000, 'trade' => 0, 'tax' => 7, 'fees' => 800, 'rate' => 7, 'months' => 60, 'income' => 70000],
        '48 months' => ['payment' => 500, 'down' => 4000, 'trade' => 0, 'tax' => 7, 'fees' => 800, 'rate' => 6.5, 'months' => 48, 'income' => 70000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'loan' => ['label' => 'Loan'],
            'interest' => ['label' => 'Total interest'],
            'tax' => ['label' => 'Sales tax'],
            'rule' => ['label' => 'Payment share of income'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>loan = PMT[1 − (1 + r)^−n] ÷ r</li>
            <li>price = (loan + down + trade − fees) ÷ (1 + tax)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
