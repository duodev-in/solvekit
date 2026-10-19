<x-calc.page
    title="California Tax Calculator - SolveKit"
    description="Free California income tax calculator: 2026 California state income tax from your income and filing status, with the effective and marginal rate and tax by bracket."
    lede="Estimate your California state income tax for 2026."
    about="California has nine brackets from 1% to 12.3% plus the 1% Mental Health Services Tax on taxable income over $1 million (13.3% top rate). Personal exemptions are credits ($153 single). State disability insurance (1.3% of wages, no cap) is a separate payroll deduction. State tax = (income − standard deduction − personal exemptions) taxed through the state's 2026 brackets, less any credits that replace deductions. Figures come from the Tax Foundation's 2026 table; local income taxes, phase-outs, special credits and federal-deduction states are simplified, so treat the result as an estimate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'state_tax', 'fields' => ['income', 'status', 'dependents', 'local'], 'data' => ['states' => config('finance_data.states')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true, 'state' => 'CA']"
    :how-to="[
        ['name' => 'Enter your income', 'text' => ''],
        ['name' => 'Choose filing status', 'text' => 'And dependents.'],
    ]"
    :faqs="[
        ['question' => 'What is California tax on $75,000 single?', 'answer' => '$2,787.85.'],
        ['question' => 'And on $500,000?', 'answer' => '$43,987.12, a marginal rate of 11.3%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Income (federal AGI)" value="75000" step="0.01" suffix="$" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly']" selected="single" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dependents" label="Dependents" value="0" min="0" step="1" />
        <x-calc.field name="local" label="Local income tax rate (optional)" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="California income tax" />

    <x-calc.options :decimals="false" :examples="[
        '$75,000 single' => ['income' => 75000, 'status' => 'single', 'dependents' => 0, 'local' => 0],
        '$150,000 married' => ['income' => 150000, 'status' => 'mfj', 'dependents' => 2, 'local' => 0],
        '$500,000' => ['income' => 500000, 'status' => 'single', 'dependents' => 0, 'local' => 0],
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
            <li>tax = Σ bracket slices − credits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
