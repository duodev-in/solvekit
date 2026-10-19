<x-calc.page
    title="Modified Adjusted Gross Income (MAGI) Calculator - SolveKit"
    description="Free MAGI calculator: modified AGI for Roth IRA eligibility, ACA premium tax credits or the net investment income tax, with the add-backs each uses."
    lede="Work out your MAGI for a specific rule."
    about="MAGI starts from AGI and adds back items that differ by rule: for Roth IRAs, the deductible IRA contribution, student loan interest and excluded foreign income (minus Roth conversions); for the ACA, tax-exempt interest, untaxed Social Security and excluded foreign income; for NIIT, excluded foreign income. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'magi', 'fields' => ['agi', 'purpose', 'status', 'ira_deduction', 'student_interest', 'foreign', 'tax_exempt', 'untaxed_ss', 'roth_conversion'], 'data' => ['federal' => config('finance_data.federal'), 'limits' => config('finance_data.limits')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter AGI', 'text' => ''],
        ['name' => 'Choose the rule and add-backs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Roth MAGI with $150,000 AGI and $2,500 student loan interest?', 'answer' => '$152,500.00: Full Roth contribution allowed.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="agi" label="AGI" value="150000" step="0.01" suffix="$" />
        <x-calc.select name="purpose" label="MAGI for" :options="['roth' => 'Roth IRA', 'aca' => 'ACA premium tax credit', 'niit' => 'Net investment income tax']" selected="roth" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ira_deduction" label="IRA deduction" value="0" step="0.01" suffix="$" />
        <x-calc.field name="student_interest" label="Student loan interest deducted" value="2500" step="0.01" suffix="$" />
        <x-calc.field name="foreign" label="Excluded foreign income" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="tax_exempt" label="Tax-exempt interest" value="0" step="0.01" suffix="$" />
        <x-calc.field name="untaxed_ss" label="Untaxed Social Security" value="0" step="0.01" suffix="$" />
        <x-calc.field name="roth_conversion" label="Roth conversion income" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Modified AGI" />

    <x-calc.options :decimals="false" :examples="[
        'Roth' => ['agi' => 150000, 'purpose' => 'roth', 'status' => 'single', 'ira_deduction' => 0, 'student_interest' => 2500, 'foreign' => 0, 'tax_exempt' => 0, 'untaxed_ss' => 0, 'roth_conversion' => 0],
        'ACA' => ['agi' => 45000, 'purpose' => 'aca', 'status' => 'single', 'ira_deduction' => 0, 'student_interest' => 0, 'foreign' => 0, 'tax_exempt' => 1500, 'untaxed_ss' => 8000, 'roth_conversion' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'added' => ['label' => 'Added back'],
            'check' => ['label' => 'What it means'],
            'agi' => ['label' => 'AGI'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MAGI = AGI + add-backs</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
