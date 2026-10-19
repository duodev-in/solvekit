<x-calc.page
    title="EPF Calculator - SolveKit"
    description="Free EPF calculator: Employees' Provident Fund corpus at 58 from 12% employee and employer contributions (less 8.33% EPS) at the 8.25% EPFO rate."
    lede="Project your EPF corpus at retirement."
    about="You contribute 12% of basic + DA; your employer contributes 12%, of which 8.33% of wages up to ₹15,000 (₹1,250 a month) goes to the pension scheme (EPS) and the rest to EPF. Interest (8.25% for 2025-26) accrues monthly on the running balance and is credited yearly. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'epf', 'fields' => ['basic', 'age', 'balance', 'growth', 'percent', 'rate'], 'data' => ['epf' => config('finance_data.epf')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter basic pay and age', 'text' => ''],
        ['name' => 'Enter balance and salary growth', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What corpus will a 30-year-old with ₹50,000 basic have at 58?', 'answer' => '₹2,85,65,418.'],
        ['question' => 'How much goes to EPS each month?', 'answer' => '₹1,250 a month goes to EPS (pension), not EPF.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="basic" label="Monthly basic + DA" value="50000" step="1" suffix="₹" />
        <x-calc.field name="age" label="Your age" value="30" min="0" step="1" />
        <x-calc.field name="balance" label="Current EPF balance" value="300000" step="1" suffix="₹" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="growth" label="Salary growth a year" value="6" step="any" suffix="%" />
        <x-calc.field name="percent" label="Your contribution" value="12" step="any" suffix="%" />
        <x-calc.field name="rate" label="EPF interest rate" value="8.25" step="any" suffix="%" />
    </div>

    <x-calc.result label="EPF corpus at 58" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['basic' => 50000, 'age' => 30, 'balance' => 300000, 'growth' => 6, 'percent' => 12, 'rate' => 8.25],
        'Starting out' => ['basic' => 25000, 'age' => 24, 'balance' => 0, 'growth' => 8, 'percent' => 12, 'rate' => 8.25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'contributed' => ['label' => 'Contributions'],
            'interest' => ['label' => 'Interest'],
            'eps' => ['label' => 'Pension share (EPS)'],
            'monthly' => ['label' => 'Going to EPF each month'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>monthly EPF = 12% + (12% − EPS) of basic</li>
            <li>EPS = 8.33% × min(basic, 15,000)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
