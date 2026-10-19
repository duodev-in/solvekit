<x-calc.page
    title="RD Calculator - Recurring Deposit - SolveKit"
    description="Free RD calculator: maturity value of a bank recurring deposit with quarterly compounding, as Indian banks compute it."
    lede="Find the maturity of a recurring deposit."
    about="Banks compound RD interest quarterly: each instalment grows as R × (1 + r/4)^(months left ÷ 3). The post office 5-year RD pays 6.7% (October–December 2026) compounded quarterly. Interest is taxable; TDS applies above ₹50,000 a year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'rd', 'fields' => ['monthly', 'rate', 'months'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the monthly deposit', 'text' => ''],
        ['name' => 'Enter rate and tenure', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does ₹5,000 a month for 5 years at 7% give?', 'answer' => '₹3,59,664.'],
        ['question' => 'And the post office RD at 6.7%?', 'answer' => '₹3,56,829.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="monthly" label="Monthly deposit" value="5000" step="1" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="7" step="any" suffix="%" />
        <x-calc.field name="months" label="Tenure" value="60" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Maturity value" />

    <x-calc.options :decimals="false" :examples="[
        'Bank RD' => ['monthly' => 5000, 'rate' => 7, 'months' => 60],
        'Post office' => ['monthly' => 5000, 'rate' => 6.7, 'months' => 60],
        'One year' => ['monthly' => 10000, 'rate' => 6.5, 'months' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'interest' => ['label' => 'Interest'],
            'invested' => ['label' => 'Deposited'],
            'effective' => ['label' => 'Effective yield'],
            'tds' => ['label' => 'TDS'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = Σ R(1 + r/4)^((n − k + 1)/3)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
