<x-calc.page
    title="Net Profit Margin Calculator - SolveKit"
    description="Free Net Profit Margin Calculator: net margin = net income ÷ revenue. The share of each sales dollar kept as profit after all costs and taxes."
    lede="Work out the net profit margin from net income and revenue."
    about="The share of each sales dollar kept as profit after all costs and taxes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_profit_margin', 'fields' => ['income', 'revenue']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Revenue.'],
        ['name' => 'Read the result', 'text' => 'The net profit margin appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net profit margin?', 'answer' => 'Net margin = net income ÷ revenue.'],
        ['question' => 'What is the net profit margin for net income $120,000, revenue $1,500,000?', 'answer' => '8%.'],
        ['question' => 'And for net income $18,000, revenue $600,000?', 'answer' => '3%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Grocery margins are thin; software margins wide.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Net income" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="revenue" label="Revenue" value="1500000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Net profit margin" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 120000, 'revenue' => 1500000],
        'Example B' => ['income' => 18000, 'revenue' => 600000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net margin = net income ÷ revenue</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
