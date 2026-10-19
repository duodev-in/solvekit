<x-calc.page
    title="Mortgage Payoff Calculator - SolveKit"
    description="Free mortgage payoff calculator: time and interest left on your mortgage, the payment to finish by a target year and the effect of an extra payment."
    lede="See when your mortgage will be paid off."
    about="From the current balance, rate and payment, the months left are n = −ln(1 − Br ÷ PMT) ÷ ln(1 + r). The payment for a target date is the level payment on the balance over those months. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'mortgage_payoff', 'fields' => ['balance', 'rate', 'payment', 'extra', 'target']]"
    :how-to="[
        ['name' => 'Enter balance, rate and payment', 'text' => 'From your statement.'],
        ['name' => 'Add an extra or a target', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When is a $250,000 balance at 6% paid off at $1,800 a month?', 'answer' => 'In 19 years 10 months.'],
        ['question' => 'What payment finishes it in 15 years?', 'answer' => '$2,109.64 a month to finish in 15 years ($309.64 more).'],
        ['question' => 'And with $200 extra?', 'answer' => '16 years 5 months with $200.00 extra, saving $34,578.76.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Balance left" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Monthly payment (P&I)" value="1800" step="0.01" suffix="$" />
        <x-calc.field name="extra" label="Extra each month" value="200" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="target" label="Pay off in (target)" value="15" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Time to pay off" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 250000, 'rate' => 6, 'payment' => 1800, 'extra' => 200, 'target' => 15],
        'Nearly done' => ['balance' => 60000, 'rate' => 4, 'payment' => 1400, 'extra' => 0, 'target' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'interest' => ['label' => 'Interest left'],
            'total' => ['label' => 'Total still to pay'],
            'last' => ['label' => 'Final payment'],
            'target' => ['label' => 'Payment for your target'],
            'extra' => ['label' => 'With the extra payment'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = −ln(1 − Br ÷ PMT) ÷ ln(1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
