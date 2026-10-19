<x-calc.page
    title="Credit Card Payment Calculator - SolveKit"
    description="Free credit card payment calculator: the monthly payment needed to pay off a card balance in a chosen number of months."
    lede="Find the payment to clear a card by a date."
    about="Payment = B × r ÷ [1 − (1 + r)^−n], with r = APR ÷ 12 and n the months, assuming no new purchases. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'card', 'fields' => ['mode', 'balance', 'apr', 'payment', 'months']]"
    :how-to="[
        ['name' => 'Enter the balance and APR', 'text' => ''],
        ['name' => 'Choose the months', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What payment clears $3,500 at 21.99% in 12 months?', 'answer' => '$327.56.'],
        ['question' => 'And in 24 months?', 'answer' => '$181.56.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['payment' => 'Payoff time', 'months' => 'Payment needed']" selected="months" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Card balance" value="3500" step="0.01" suffix="$" />
        <x-calc.field name="apr" label="APR" value="21.99" step="any" suffix="%" />
    </div>

    <div data-show-when="mode:payment" hidden>
        <x-calc.field name="payment" label="Monthly payment" value="150" step="0.01" suffix="$" />
    </div>

    <div data-show-when="mode:months">
        <x-calc.field name="months" label="Pay off in" value="12" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Monthly payment needed" />

    <x-calc.options :decimals="false" :examples="[
        '12 months' => ['mode' => 'months', 'balance' => 3500, 'apr' => 21.99, 'payment' => '', 'months' => 12],
        '24 months' => ['mode' => 'months', 'balance' => 3500, 'apr' => 21.99, 'payment' => '', 'months' => 24],
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
            <li>PMT = B r ÷ [1 − (1 + r)^−n]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
