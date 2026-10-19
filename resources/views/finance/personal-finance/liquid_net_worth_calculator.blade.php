<x-calc.page
    title="Liquid Net Worth Calculator - SolveKit"
    description="Free Liquid Net Worth Calculator: liquid net worth = liquid assets − liabilities. Liquid net worth counts only assets you can turn into cash quickly, not your home or retirement accounts (which have penalties before 59½)."
    lede="Work out the liquid net worth from cash and savings, taxable investments and debts."
    about="Liquid net worth counts only assets you can turn into cash quickly, not your home or retirement accounts (which have penalties before 59½). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'liquid_net_worth', 'fields' => ['cash', 'investments', 'debts']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cash and savings, Taxable investments, Debts.'],
        ['name' => 'Read the result', 'text' => 'The liquid net worth appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the liquid net worth?', 'answer' => 'Liquid net worth = liquid assets − liabilities.'],
        ['question' => 'What is the liquid net worth for cash and savings $20,000, taxable investments $50,000, debts $15,000?', 'answer' => '$55,000.00.'],
        ['question' => 'And for cash and savings $6,000, taxable investments $0, debts $3,500?', 'answer' => '$2,500.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It shows how long you could manage without income.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cash" label="Cash and savings" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="investments" label="Taxable investments" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="debts" label="Debts" value="15000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Liquid net worth" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cash' => 20000, 'investments' => 50000, 'debts' => 15000],
        'Example B' => ['cash' => 6000, 'investments' => 0, 'debts' => 3500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>liquid net worth = liquid assets − liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
