<x-calc.page
    title="Return on Sales Calculator - SolveKit"
    description="Free Return on Sales Calculator: ROS = operating profit ÷ revenue. Return on sales (operating margin) is the operating profit on each dollar of sales."
    lede="Work out the return on sales from operating profit and revenue."
    about="Return on sales (operating margin) is the operating profit on each dollar of sales. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'return_on_sales', 'fields' => ['operating', 'sales']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Operating profit, Revenue.'],
        ['name' => 'Read the result', 'text' => 'The return on sales appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the return on sales?', 'answer' => 'ROS = operating profit ÷ revenue.'],
        ['question' => 'What is the return on sales for operating profit $450,000, revenue $3,000,000?', 'answer' => '15%.'],
        ['question' => 'And for operating profit $60,000, revenue $900,000?', 'answer' => '6.667%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with peers in the same industry.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="operating" label="Operating profit" value="450000" step="0.01" suffix="$" />
        <x-calc.field name="sales" label="Revenue" value="3000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Return on sales" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['operating' => 450000, 'sales' => 3000000],
        'Example B' => ['operating' => 60000, 'sales' => 900000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROS = operating profit ÷ revenue</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
