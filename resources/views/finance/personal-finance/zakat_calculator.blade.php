<x-calc.page
    title="Zakat Calculator - SolveKit"
    description="Free Zakat Calculator: zakat = 2.5% × (zakatable wealth − debts) if above nisab. Zakat is 2.5% of wealth held for a lunar year above the nisab threshold."
    lede="Work out the zakat due from zakatable wealth (cash, gold, silver, investments, business stock), debts due now and nisab (85 g of gold or 595 g of silver at today's price)."
    about="Zakat is 2.5% of wealth held for a lunar year above the nisab threshold. Scholars differ on details; ask your local authority. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'zakat', 'fields' => ['assets', 'debts', 'nisab']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Zakatable wealth (cash, gold, silver, investments, business stock), Debts due now, Nisab (85 g of gold or 595 g of silver at today\'s price).'],
        ['name' => 'Read the result', 'text' => 'The zakat due appears as you type, with net zakatable wealth below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the zakat due?', 'answer' => 'Zakat = 2.5% × (zakatable wealth − debts) if above nisab.'],
        ['question' => 'What is the zakat due for zakatable wealth $20,000, debts due now $2,000, nisab $7,000?', 'answer' => '$450.00. Net zakatable wealth: $18,000.00.'],
        ['question' => 'And for zakatable wealth $5,000, debts due now $0, nisab $7,000?', 'answer' => '$0.00. Net zakatable wealth: $5,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Using the silver nisab gives a lower threshold.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="assets" label="Zakatable wealth (cash, gold, silver, investments, business stock)" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="debts" label="Debts due now" value="2000" step="0.01" suffix="$" />
        <x-calc.field name="nisab" label="Nisab (85 g of gold or 595 g of silver at today's price)" value="7000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Zakat due" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['assets' => 20000, 'debts' => 2000, 'nisab' => 7000],
        'Example B' => ['assets' => 5000, 'debts' => 0, 'nisab' => 7000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Net zakatable wealth'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>zakat = 2.5% × (zakatable wealth − debts) if above nisab</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
