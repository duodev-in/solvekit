<x-calc.page
    title="EV to Sales Calculator — Enterprise Value to Sales - SolveKit"
    description="Free EV to Sales Calculator — Enterprise Value to Sales: EV/Sales = EV ÷ revenue. EV to sales values a company against its revenue, useful when earnings are negative."
    lede="Work out the EV/Sales from enterprise value and revenue."
    about="EV to sales values a company against its revenue, useful when earnings are negative. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ev_to_sales', 'fields' => ['ev', 'sales']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Enterprise value, Revenue.'],
        ['name' => 'Read the result', 'text' => 'The EV/Sales appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EV/Sales?', 'answer' => 'EV/Sales = EV ÷ revenue.'],
        ['question' => 'What is the EV/Sales for enterprise value $60,000,000, revenue $20,000,000?', 'answer' => '3×.'],
        ['question' => 'And for enterprise value $900,000,000, revenue $150,000,000?', 'answer' => '6×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Software firms often trade at higher multiples than retailers.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ev" label="Enterprise value" value="60000000" step="0.01" suffix="$" />
        <x-calc.field name="sales" label="Revenue" value="20000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="EV/Sales" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ev' => 60000000, 'sales' => 20000000],
        'Example B' => ['ev' => 900000000, 'sales' => 150000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EV/Sales = EV ÷ revenue</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
