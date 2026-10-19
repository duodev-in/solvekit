<x-calc.page
    title="Perpetuity Calculator - SolveKit"
    description="Free Perpetuity Calculator: PV = C ÷ (r − g). A perpetuity pays forever; with growth g it is a growing perpetuity (the Gordon formula)."
    lede="Work out the present value from payment each period, discount rate and growth rate (optional)."
    about="A perpetuity pays forever; with growth g it is a growing perpetuity (the Gordon formula). Requires r > g. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'perpetuity', 'fields' => ['payment', 'rate', 'growth']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Payment each period, Discount rate, Growth rate (optional).'],
        ['name' => 'Read the result', 'text' => 'The present value appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the present value?', 'answer' => 'PV = C ÷ (r − g).'],
        ['question' => 'What is the present value for payment each period $1,000, discount rate 5%, growth rate 0%?', 'answer' => '$20,000.00.'],
        ['question' => 'And for payment each period $50, discount rate 8%, growth rate 2%?', 'answer' => '$833.33.'],
        ['question' => 'What does the result tell me?', 'answer' => 'At 5%, $1,000 a year forever is worth $20,000 today.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="payment" label="Payment each period" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Discount rate" value="5" step="any" suffix="%" />
        <x-calc.field name="growth" label="Growth rate (optional)" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Present value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['payment' => 1000, 'rate' => 5, 'growth' => 0],
        'Example B' => ['payment' => 50, 'rate' => 8, 'growth' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = C ÷ (r − g)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
