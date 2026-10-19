<x-calc.page
    title="Working Capital Calculator - SolveKit"
    description="Free Working Capital Calculator: working capital = current assets − current liabilities. Working capital is the short-term cushion of liquid resources."
    lede="Work out the working capital from current assets and current liabilities."
    about="Working capital is the short-term cushion of liquid resources. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'working_capital', 'fields' => ['assets', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Current assets, Current liabilities.'],
        ['name' => 'Read the result', 'text' => 'The working capital appears as you type, with current ratio below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the working capital?', 'answer' => 'Working capital = current assets − current liabilities.'],
        ['question' => 'What is the working capital for current assets $450,000, current liabilities $300,000?', 'answer' => '$150,000.00. Current ratio: 1.5×.'],
        ['question' => 'And for current assets $90,000, current liabilities $110,000?', 'answer' => '−$20,000.00. Current ratio: 0.8182×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Negative working capital can be a warning or, for some retailers, normal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="assets" label="Current assets" value="450000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Current liabilities" value="300000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Working capital" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['assets' => 450000, 'liabilities' => 300000],
        'Example B' => ['assets' => 90000, 'liabilities' => 110000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Current ratio'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>working capital = current assets − current liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
