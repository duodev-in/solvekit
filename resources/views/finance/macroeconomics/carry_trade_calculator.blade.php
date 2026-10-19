<x-calc.page
    title="Carry Trade Calculator - SolveKit"
    description="Free Carry Trade Calculator: profit = A[(1 + i_high)^t (1 + Δfx) − (1 + i_low)^t]. A carry trade borrows in a low-rate currency to invest in a high-rate one; a currency move can wipe out the gap."
    lede="Work out the profit from your figures."
    about="A carry trade borrows in a low-rate currency to invest in a high-rate one; a currency move can wipe out the gap. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'carry_trade', 'fields' => ['amount', 'high', 'low', 'fx', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Amount invested, Interest rate earned, Interest rate paid, Change in the exchange rate (in your favor +), Years.'],
        ['name' => 'Read the result', 'text' => 'The profit appears as you type, with return below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the profit?', 'answer' => 'Profit = A[(1 + i_high)^t (1 + Δfx) − (1 + i_low)^t].'],
        ['question' => 'What is the profit for amount invested $100,000, interest rate earned 6%, interest rate paid 1%, change in the exchange rate -2%, years 1?', 'answer' => '$2,880.00. Return: 2.88%.'],
        ['question' => 'And for amount invested $50,000, interest rate earned 10%, interest rate paid 0.5%, change in the exchange rate -12%, years 1?', 'answer' => '−$1,850.00. Return: −3.7%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Uncovered interest parity predicts the currency move offsets the gap on average.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount invested" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="high" label="Interest rate earned" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="low" label="Interest rate paid" value="1" step="any" suffix="%" />
        <x-calc.field name="fx" label="Change in the exchange rate (in your favor +)" value="-2" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="1" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Profit" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['amount' => 100000, 'high' => 6, 'low' => 1, 'fx' => -2, 'years' => 1],
        'Example B' => ['amount' => 50000, 'high' => 10, 'low' => 0.5, 'fx' => -12, 'years' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Return'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>profit = A[(1 + i_high)^t (1 + Δfx) − (1 + i_low)^t]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
