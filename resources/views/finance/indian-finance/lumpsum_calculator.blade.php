<x-calc.page
    title="Lumpsum Calculator - SolveKit"
    description="Free lumpsum calculator: future value of a one-time mutual fund investment at an expected annual return."
    lede="Find what a one-time investment can grow to."
    about="Future value = P × (1 + r)^n, compounding yearly at the expected return. Returns from equity funds vary widely year to year; use a cautious rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'lumpsum', 'fields' => ['amount', 'rate', 'years'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Enter return and years', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does ₹1 lakh become in 10 years at 12%?', 'answer' => '₹3,10,585.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount invested" value="100000" step="1" suffix="$" />
        <x-calc.field name="rate" label="Expected return a year" value="12" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Expected value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 100000, 'rate' => 12, 'years' => 10],
        'Debt fund' => ['amount' => 500000, 'rate' => 7, 'years' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'invested' => ['label' => 'Invested'],
            'gains' => ['label' => 'Gains'],
            'multiple' => ['label' => 'Multiple'],
            'doubling' => ['label' => 'Doubling time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FV = P(1 + r)^n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
