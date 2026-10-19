<x-calc.page
    title="Credit Card Payoff Calculator - SolveKit"
    description="Free credit card payoff calculator: payoff date and interest at your payment, or the payment needed to be debt-free by a date."
    lede="Plan your credit card payoff."
    about="Paying more than the minimum is the fastest way to cut interest. Interest is balance × APR ÷ 12 each month. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'card', 'fields' => ['mode', 'balance', 'apr', 'payment', 'months']]"
    :how-to="[
        ['name' => 'Enter the balance and APR', 'text' => ''],
        ['name' => 'Choose a payment or a deadline', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long does $8,000 at 24.99% take at $300?', 'answer' => '3 years 4 months.'],
        ['question' => 'What payment pays it off in 18 months?', 'answer' => '$537.50.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['payment' => 'Payoff time', 'months' => 'Payment needed']" selected="payment" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Card balance" value="8000" step="0.01" suffix="$" />
        <x-calc.field name="apr" label="APR" value="24.99" step="any" suffix="%" />
    </div>

    <div data-show-when="mode:payment">
        <x-calc.field name="payment" label="Monthly payment" value="300" step="0.01" suffix="$" />
    </div>

    <div data-show-when="mode:months" hidden>
        <x-calc.field name="months" label="Pay off in" value="24" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Time to pay off" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'payment', 'balance' => 8000, 'apr' => 24.99, 'payment' => 300, 'months' => 18],
        '18 months' => ['mode' => 'months', 'balance' => 8000, 'apr' => 24.99, 'payment' => '', 'months' => 18],
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
