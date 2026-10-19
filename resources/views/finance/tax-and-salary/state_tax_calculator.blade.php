<x-calc.page
    title="State Tax Calculator - SolveKit"
    description="Free state income tax calculator for 2026: income tax in any of the 50 states and Washington DC from your income and filing status, with marginal and effective rates."
    lede="Estimate your 2026 state income tax."
    about="State tax = (income − standard deduction − personal exemptions) taxed through the state's 2026 brackets, less any credits that replace deductions. Figures come from the Tax Foundation's 2026 table; local income taxes, phase-outs, special credits and federal-deduction states are simplified, so treat the result as an estimate. Nine states tax no wage income: Alaska, Florida, Nevada, New Hampshire, South Dakota, Tennessee, Texas, Washington (capital gains only) and Wyoming. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'state_tax', 'fields' => ['state', 'income', 'status', 'dependents', 'local'], 'data' => ['states' => config('finance_data.states')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Choose a state', 'text' => ''],
        ['name' => 'Enter income and status', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is Colorado tax on $85,000?', 'answer' => '$3,031.60.'],
        ['question' => 'And Oregon?', 'answer' => '$6,607.88.'],
        ['question' => 'And Florida?', 'answer' => '$0.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="state" label="State" :options="['AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming']" selected="CO" />
        <x-calc.field name="income" label="Income (federal AGI)" value="85000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly']" selected="single" />
        <x-calc.field name="dependents" label="Dependents" value="0" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="local" label="Local income tax rate (optional)" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="State income tax" />

    <x-calc.options :decimals="false" :examples="[
        'Colorado' => ['state' => 'CO', 'income' => 85000, 'status' => 'single', 'dependents' => 0, 'local' => 0],
        'Oregon' => ['state' => 'OR', 'income' => 85000, 'status' => 'single', 'dependents' => 0, 'local' => 0],
        'Florida' => ['state' => 'FL', 'income' => 85000, 'status' => 'single', 'dependents' => 0, 'local' => 0],
        'Married in Virginia' => ['state' => 'VA', 'income' => 160000, 'status' => 'mfj', 'dependents' => 2, 'local' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'taxable' => ['label' => 'Taxable income'],
            'marginal' => ['label' => 'Marginal rate'],
            'local' => ['label' => 'Local tax'],
            'top' => ['label' => 'Top state rate'],
        ]" />
        <x-calc.quick-ref heading="By bracket" name="slices" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>taxable = income − deduction − exemptions</li>
            <li>tax = Σ slices − credits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
