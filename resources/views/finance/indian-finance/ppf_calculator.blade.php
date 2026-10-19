<x-calc.page
    title="PPF Calculator - SolveKit"
    description="Free PPF calculator: Public Provident Fund maturity value after 15 years at the notified 7.1% rate, with yearly deposits up to ₹1.5 lakh."
    lede="Find your PPF maturity value."
    about="PPF interest is set every quarter by the government (7.1% for October–December 2026) and compounded yearly. Deposit by April 5 to earn interest for the whole year. The account matures after 15 full financial years and can be extended in 5-year blocks. Deposits, interest and maturity are tax-free. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'ppf', 'fields' => ['yearly', 'rate', 'years'], 'data' => ['smallsavings' => config('finance_data.smallsavings')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the yearly deposit', 'text' => '₹500 to ₹1.5 lakh.'],
        ['name' => 'Keep 15 years or extend', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does ₹1.5 lakh a year in PPF give after 15 years?', 'answer' => '₹40,68,209.'],
        ['question' => 'And extended to 20 years?', 'answer' => '₹66,58,288.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="yearly" label="Yearly deposit" value="150000" step="1" suffix="₹" />
        <x-calc.field name="rate" label="Interest rate" value="7.1" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="15" min="0" step="1" suffix="years" />
    </div>

    <x-calc.result label="Maturity value" />

    <x-calc.options :decimals="false" :examples="[
        'Maximum' => ['yearly' => 150000, 'rate' => 7.1, 'years' => 15],
        '20 years' => ['yearly' => 150000, 'rate' => 7.1, 'years' => 20],
        '₹50,000 a year' => ['yearly' => 50000, 'rate' => 7.1, 'years' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'invested' => ['label' => 'Deposited'],
            'interest' => ['label' => 'Interest'],
            'tax' => ['label' => 'Tax'],
            'extension' => ['label' => 'After maturity'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Bₜ = (Bₜ₋₁ + D)(1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
