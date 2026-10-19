<x-calc.page
    title="Student Loan Payment Calculator - SolveKit"
    description="Free student loan payment calculator: monthly payments on the standard (10-year), graduated and extended (25-year) federal plans."
    lede="Compare federal student loan repayment plans."
    about="Standard: level payments over 10 years. Graduated: payments rise every two years for 10 years; no payment may be less than the monthly interest or more than three times another (34 CFR 685.208), so the steps shown are an estimate. Extended: up to 25 years for more than $30,000 of Direct Loans. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'student_plans', 'fields' => ['balance', 'rate']]"
    :how-to="[
        ['name' => 'Enter the balance and rate', 'text' => ''],
        ['name' => 'Compare plans', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the payments on $35,000 at 6.39%?', 'answer' => 'Standard $395.46; graduated $211.09 rising to $633.27 every two years, $50,661.59 in total (estimate).'],
        ['question' => 'Can I use the extended plan?', 'answer' => '$233.92 a month for 25 years, $70,176.73 in total.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Loan balance" value="35000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.39" step="any" suffix="%" />
    </div>

    <x-calc.result label="Standard plan payment (10 years)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 35000, 'rate' => 6.39],
        'Small balance' => ['balance' => 12000, 'rate' => 6.39],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'standard' => ['label' => 'Standard'],
            'graduated' => ['label' => 'Graduated'],
            'extended' => ['label' => 'Extended'],
            'note' => ['label' => 'Income-driven plans'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>standard = B r ÷ [1 − (1 + r)^−120]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
