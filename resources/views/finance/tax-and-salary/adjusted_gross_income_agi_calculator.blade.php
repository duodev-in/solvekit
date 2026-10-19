<x-calc.page
    title="Adjusted Gross Income (AGI) Calculator - SolveKit"
    description="Free AGI calculator: adjusted gross income from wages, interest, dividends, business income and gains, less above-the-line adjustments (Schedule 1)."
    lede="Work out your adjusted gross income."
    about="AGI = total income − adjustments to income (Form 1040, Schedule 1 Part II): HSA contributions, deductible IRA contributions, student loan interest (up to $2,500), half of self-employment tax and others. AGI decides many credits and phase-outs. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'agi', 'fields' => ['wages', 'interest', 'dividends', 'business', 'gains', 'retirement', 'other_income', 'hsa', 'ira', 'student_interest', 'se_half', 'other_adj', 'status'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter income sources', 'text' => ''],
        ['name' => 'Enter adjustments', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the AGI of the example?', 'answer' => '$69,500.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wages" label="Wages (W-2 box 1)" value="70000" step="0.01" suffix="$" />
        <x-calc.field name="interest" label="Interest" value="500" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dividends" label="Dividends" value="1200" step="0.01" suffix="$" />
        <x-calc.field name="business" label="Business income" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gains" label="Capital gains" value="2000" step="0.01" suffix="$" />
        <x-calc.field name="retirement" label="Taxable retirement income" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="other_income" label="Other income" value="0" step="0.01" suffix="$" />
        <x-calc.field name="hsa" label="HSA deduction" value="3000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ira" label="Deductible IRA contribution" value="0" step="0.01" suffix="$" />
        <x-calc.field name="student_interest" label="Student loan interest" value="1200" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="se_half" label="Half of SE tax" value="0" step="0.01" suffix="$" />
        <x-calc.field name="other_adj" label="Other adjustments" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <x-calc.result label="Adjusted gross income (AGI)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wages' => 70000, 'interest' => 500, 'dividends' => 1200, 'business' => 0, 'gains' => 2000, 'retirement' => 0, 'other_income' => 0, 'hsa' => 3000, 'ira' => 0, 'student_interest' => 1200, 'se_half' => 0, 'other_adj' => 0, 'status' => 'single'],
        'Freelancer' => ['wages' => 0, 'interest' => 200, 'dividends' => 0, 'business' => 80000, 'gains' => 0, 'retirement' => 0, 'other_income' => 0, 'hsa' => 0, 'ira' => 7500, 'student_interest' => 3000, 'se_half' => 5652, 'other_adj' => 0, 'status' => 'single'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total income'],
            'adjustments' => ['label' => 'Adjustments'],
            'taxable' => ['label' => 'Taxable income'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AGI = total income − adjustments</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
