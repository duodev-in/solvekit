<x-calc.page
    title="New vs Old Tax Regime Calculator (India) - SolveKit"
    description="Free new vs old tax regime calculator for FY 2026-27: income tax under both regimes with deductions, rebate, surcharge and cess, and which one saves more."
    lede="Compare the new and old tax regimes."
    about="New regime (default): nil up to ₹4 lakh, then 5% to 30% above ₹24 lakh, ₹75,000 standard deduction and a rebate making income up to ₹12 lakh tax-free; few deductions apart from employer NPS. Old regime: nil to ₹2.5 lakh (₹3 lakh at 60+, ₹5 lakh at 80+), 5%, 20%, 30%, with 80C, 80D, HRA, home loan interest and other deductions and a ₹50,000 standard deduction. 4% cess applies to both. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'regime', 'fields' => ['salary', 'other', 'c80', 'd80', 'hra_exempt', 'home_interest', 'nps', 'employer_nps', 'other_ded', 'age'], 'data' => ['india' => config('finance_data.india')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter salary and other income', 'text' => ''],
        ['name' => 'Enter the deductions you claim', 'text' => 'They count only in the old regime.'],
    ]"
    :faqs="[
        ['question' => 'Which regime is better on ₹15 lakh with 80C, 80D, HRA and NPS deductions?', 'answer' => 'New regime: saves ₹52,260 a year.'],
        ['question' => 'What about ₹12 lakh?', 'answer' => 'New regime: ₹0 on ₹12,00,000 taxable.'],
        ['question' => 'And ₹30 lakh with a home loan?', 'answer' => 'New regime.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="salary" label="Gross salary" value="1500000" step="1" suffix="₹" />
        <x-calc.field name="other" label="Other income" value="0" step="1" suffix="₹" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="c80" label="80C investments (PF, PPF, ELSS, insurance)" value="150000" step="1" suffix="₹" />
        <x-calc.field name="d80" label="80D health insurance" value="25000" step="1" suffix="₹" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hra_exempt" label="HRA exemption" value="120000" step="1" suffix="₹" />
        <x-calc.field name="home_interest" label="Home loan interest (24b)" value="0" step="1" suffix="₹" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nps" label="Own NPS (80CCD(1B))" value="50000" step="1" suffix="₹" />
        <x-calc.field name="employer_nps" label="Employer NPS (80CCD(2))" value="0" step="1" suffix="₹" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="other_ded" label="Other deductions" value="0" step="1" suffix="₹" />
        <x-calc.select name="age" label="Age" :options="['below60' => 'Below 60', 'senior' => '60 to 79', 'super' => '80 and above']" selected="below60" />
    </div>

    <x-calc.result label="Lower tax" />

    <x-calc.options :decimals="false" :examples="[
        '₹15 lakh' => ['salary' => 1500000, 'other' => 0, 'c80' => 150000, 'd80' => 25000, 'hra_exempt' => 120000, 'home_interest' => 0, 'nps' => 50000, 'employer_nps' => 0, 'other_ded' => 0, 'age' => 'below60'],
        '₹12 lakh' => ['salary' => 1275000, 'other' => 0, 'c80' => 150000, 'd80' => 25000, 'hra_exempt' => 0, 'home_interest' => 0, 'nps' => 0, 'employer_nps' => 0, 'other_ded' => 0, 'age' => 'below60'],
        '₹30 lakh' => ['salary' => 3000000, 'other' => 0, 'c80' => 150000, 'd80' => 50000, 'hra_exempt' => 0, 'home_interest' => 200000, 'nps' => 50000, 'employer_nps' => 0, 'other_ded' => 0, 'age' => 'below60'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'new' => ['label' => 'New regime'],
            'old' => ['label' => 'Old regime'],
            'deductions' => ['label' => 'Old-regime deductions'],
            'breakeven' => ['label' => 'Break-even'],
            'monthly' => ['label' => 'Monthly tax'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tax = slabs(taxable) − rebate, + surcharge, × 1.04 cess</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
