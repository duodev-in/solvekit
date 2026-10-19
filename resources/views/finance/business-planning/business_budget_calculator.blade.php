<x-calc.page
    title="Business Budget Calculator - SolveKit"
    description="Free business budget calculator: monthly and yearly surplus or shortfall from income and expense lines, with each cost as a share of income."
    lede="Build a simple business budget."
    about="Net = total income − total expenses, monthly and × 12 for the year. Expense shares of income show where the money goes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'budget_lines', 'fields' => ['lines']]"
    :how-to="[
        ['name' => 'Add income lines', 'text' => ''],
        ['name' => 'Add expense lines', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the surplus on the example budget?', 'answer' => '$9,100.00 a month.'],
    ]"
>
    <x-calc.rows-editor name="lines" label="Budget lines (type: income or expense)" :columns="['name' => 'Line', 'type' => 'Type', 'amount' => 'Monthly amount']" :rows="[['Sales', 'income', 42000], ['Rent', 'expense', 4500], ['Payroll', 'expense', 22000], ['Marketing', 'expense', 3000], ['Software', 'expense', 900], ['Other', 'expense', 2500]]" :text="['name', 'type']" />

    <x-calc.result label="Monthly surplus" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lines' => 'Sales	income	42000
Rent	expense	4500
Payroll	expense	22000
Marketing	expense	3000
Software	expense	900
Other	expense	2500'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'income' => ['label' => 'Income'],
            'expenses' => ['label' => 'Expenses'],
            'margin' => ['label' => 'Margin'],
            'largest' => ['label' => 'Largest expense'],
        ]" />
        <x-calc.quick-ref heading="Expenses" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net = Σ income − Σ expenses</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
