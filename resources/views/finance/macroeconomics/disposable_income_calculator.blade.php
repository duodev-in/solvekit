<x-calc.page
    title="Disposable Income Calculator - SolveKit"
    description="Free Disposable Income Calculator: disposable income = income − taxes. Disposable income is what households can spend or save after taxes."
    lede="Work out the disposable income from gross income and income and payroll taxes."
    about="Disposable income is what households can spend or save after taxes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'disposable_income', 'fields' => ['income', 'taxes']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Gross income, Income and payroll taxes.'],
        ['name' => 'Read the result', 'text' => 'The disposable income appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the disposable income?', 'answer' => 'Disposable income = income − taxes.'],
        ['question' => 'What is the disposable income for gross income $75,000, income and payroll taxes $16,000?', 'answer' => '$59,000.00.'],
        ['question' => 'And for gross income $48,000, income and payroll taxes $7,200?', 'answer' => '$40,800.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Discretionary income also subtracts essential spending.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Gross income" value="75000" step="0.01" suffix="$" />
        <x-calc.field name="taxes" label="Income and payroll taxes" value="16000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Disposable income" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 75000, 'taxes' => 16000],
        'Example B' => ['income' => 48000, 'taxes' => 7200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>disposable income = income − taxes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
