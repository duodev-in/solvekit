<x-calc.page
    title="Credit Card Calculator - SolveKit"
    description="Free credit card calculator: months to pay off a card balance at a fixed payment, total interest, and the comparison with minimum payments."
    lede="See how long it takes to pay off a credit card."
    about="Each month interest of balance × APR ÷ 12 is added and your payment taken off. Card issuers charge on the average daily balance, which gives nearly the same result for a steady balance. The comparison uses a typical minimum: 1% of the balance plus interest, at least $25. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'card', 'fields' => ['mode', 'balance', 'apr', 'payment', 'months']]"
    :how-to="[
        ['name' => 'Enter the balance and APR', 'text' => 'From your statement.'],
        ['name' => 'Enter a payment or a target', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long does $5,000 at 22.99% take at $200 a month?', 'answer' => '2 years 11 months, with $1,871.08 interest.'],
        ['question' => 'What payment clears it in 2 years?', 'answer' => '$261.84.'],
        ['question' => 'And with minimum payments only?', 'answer' => 'Minimum payments only (1% + interest, $25 floor): 19 years 4 months, $8,488.94 interest.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['payment' => 'Payoff time', 'months' => 'Payment needed']" selected="payment" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Card balance" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="apr" label="APR" value="22.99" step="any" suffix="%" />
    </div>

    <div data-show-when="mode:payment">
        <x-calc.field name="payment" label="Monthly payment" value="200" step="0.01" suffix="$" />
    </div>

    <div data-show-when="mode:months" hidden>
        <x-calc.field name="months" label="Pay off in" value="24" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Time to pay off" />

    <x-calc.options :decimals="false" :examples="[
        '$200 a month' => ['mode' => 'payment', 'balance' => 5000, 'apr' => 22.99, 'payment' => 200, 'months' => 24],
        'In 2 years' => ['mode' => 'months', 'balance' => 5000, 'apr' => 22.99, 'payment' => '', 'months' => 24],
        '$500 a month' => ['mode' => 'payment', 'balance' => 5000, 'apr' => 22.99, 'payment' => 500, 'months' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'months' => ['label' => 'Months'],
            'interest' => ['label' => 'Interest'],
            'total' => ['label' => 'Total paid'],
            'minimum' => ['label' => 'Minimum payments only'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Bₘ₊₁ = Bₘ(1 + APR ÷ 12) − PMT</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
