<x-calc.page
    title="Debt to Income Ratio Calculator - SolveKit"
    description="Free Debt to Income Ratio Calculator: DTI = monthly debt payments ÷ gross monthly income. Lenders use DTI to judge ability to repay; Qualified Mortgage rules once capped it at 43%."
    lede="Work out the debt-to-income ratio from monthly debt payments (incl. housing) and gross monthly income."
    about="Lenders use DTI to judge ability to repay; Qualified Mortgage rules once capped it at 43%. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'debt_to_income_ratio', 'fields' => ['debts', 'income']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly debt payments (incl. housing), Gross monthly income.'],
        ['name' => 'Read the result', 'text' => 'The debt-to-income ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the debt-to-income ratio?', 'answer' => 'DTI = monthly debt payments ÷ gross monthly income.'],
        ['question' => 'What is the debt-to-income ratio for monthly debt payments $2,200, gross monthly income $7,000?', 'answer' => '31.43%.'],
        ['question' => 'And for monthly debt payments $3,100, gross monthly income $6,000?', 'answer' => '51.67%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Many lenders prefer 36% or less; FHA can allow up to about 50%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="debts" label="Monthly debt payments (incl. housing)" value="2200" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Gross monthly income" value="7000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Debt-to-income ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['debts' => 2200, 'income' => 7000],
        'Example B' => ['debts' => 3100, 'income' => 6000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DTI = monthly debt payments ÷ gross monthly income</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
