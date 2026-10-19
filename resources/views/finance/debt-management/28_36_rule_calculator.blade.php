<x-calc.page
    title="28/36 Rule Calculator - SolveKit"
    description="Free 28/36 Rule Calculator: housing ≤ 28% of gross income. The 28/36 rule is a lending guideline for how much of your income can go to housing and all debts."
    lede="Work out the maximum housing payment (28%) from gross monthly income and other monthly debt payments."
    about="The 28/36 rule is a lending guideline for how much of your income can go to housing and all debts. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => '28_36_rule', 'fields' => ['income', 'debts']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Gross monthly income, Other monthly debt payments.'],
        ['name' => 'Read the result', 'text' => 'The maximum housing payment (28%) appears as you type, with 28% of income, 36% of income less other debts below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the maximum housing payment (28%)?', 'answer' => 'Housing ≤ 28% of gross income; housing + debts ≤ 36%.'],
        ['question' => 'What is the maximum housing payment (28%) for gross monthly income $8,000, other monthly debt payments $600?', 'answer' => '$2,240.00. 28% of income: $2,240.00.'],
        ['question' => 'And for gross monthly income $5,500, other monthly debt payments $900?', 'answer' => '$1,080.00. 28% of income: $1,540.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'FHA and other programs allow higher ratios.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Gross monthly income" value="8000" step="0.01" suffix="$" />
        <x-calc.field name="debts" label="Other monthly debt payments" value="600" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Maximum housing payment (28%)" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 8000, 'debts' => 600],
        'Example B' => ['income' => 5500, 'debts' => 900],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => '28% of income'],
            'r2' => ['label' => '36% of income less other debts'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>housing ≤ 28% of gross income</li>
            <li>housing + debts ≤ 36%</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
