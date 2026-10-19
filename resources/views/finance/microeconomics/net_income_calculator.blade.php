<x-calc.page
    title="Net Income Calculator - SolveKit"
    description="Free Net Income Calculator: net income = (revenue − expenses) × (1 − tax rate). Net income is the bottom-line profit after all expenses and taxes."
    lede="Work out the net income from revenue, total expenses (before tax) and tax rate."
    about="Net income is the bottom-line profit after all expenses and taxes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_income', 'fields' => ['revenue', 'expenses', 'tax']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Total expenses (before tax), Tax rate.'],
        ['name' => 'Read the result', 'text' => 'The net income appears as you type, with pre-tax income, net margin below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net income?', 'answer' => 'Net income = (revenue − expenses) × (1 − tax rate).'],
        ['question' => 'What is the net income for revenue $1,000,000, total expenses $800,000, tax rate 21%?', 'answer' => '$158,000.00. Pre-tax income: $200,000.00.'],
        ['question' => 'And for revenue $350,000, total expenses $290,000, tax rate 25%?', 'answer' => '$45,000.00. Pre-tax income: $60,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Losses are not taxed here; tax credits are ignored.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="revenue" label="Revenue" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="expenses" label="Total expenses (before tax)" value="800000" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Tax rate" value="21" step="any" suffix="%" />
    </div>

    <x-calc.result label="Net income" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 1000000, 'expenses' => 800000, 'tax' => 21],
        'Example B' => ['revenue' => 350000, 'expenses' => 290000, 'tax' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Pre-tax income'],
            'r2' => ['label' => 'Net margin'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net income = (revenue − expenses) × (1 − tax rate)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
