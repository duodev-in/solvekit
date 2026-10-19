<x-calc.page
    title="Net Debt Calculator - SolveKit"
    description="Free Net Debt Calculator: net debt = debt − cash. Net debt is what a company would still owe if it used its cash to repay debt."
    lede="Work out the net debt from short- and long-term debt and cash and equivalents."
    about="Net debt is what a company would still owe if it used its cash to repay debt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_debt', 'fields' => ['debt', 'cash']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Short- and long-term debt, Cash and equivalents.'],
        ['name' => 'Read the result', 'text' => 'The net debt appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net debt?', 'answer' => 'Net debt = debt − cash.'],
        ['question' => 'What is the net debt for short- and long-term debt $5,000,000, cash and equivalents $1,200,000?', 'answer' => '$3,800,000.00.'],
        ['question' => 'And for short- and long-term debt $400,000, cash and equivalents $900,000?', 'answer' => '−$500,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Negative net debt means net cash.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="debt" label="Short- and long-term debt" value="5000000" step="0.01" suffix="$" />
        <x-calc.field name="cash" label="Cash and equivalents" value="1200000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Net debt" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['debt' => 5000000, 'cash' => 1200000],
        'Example B' => ['debt' => 400000, 'cash' => 900000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net debt = debt − cash</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
