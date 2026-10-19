<x-calc.page
    title="Operating Cash Flow Ratio Calculator - SolveKit"
    description="Free Operating Cash Flow Ratio Calculator: ratio = operating cash flow ÷ current liabilities. Shows whether cash from operations covers short-term obligations."
    lede="Work out the operating cash flow ratio from operating cash flow and current liabilities."
    about="Shows whether cash from operations covers short-term obligations. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'operating_cash_flow_ratio', 'fields' => ['ocf', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Operating cash flow, Current liabilities.'],
        ['name' => 'Read the result', 'text' => 'The operating cash flow ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the operating cash flow ratio?', 'answer' => 'Ratio = operating cash flow ÷ current liabilities.'],
        ['question' => 'What is the operating cash flow ratio for operating cash flow $900,000, current liabilities $750,000?', 'answer' => '1.2×.'],
        ['question' => 'And for operating cash flow $300,000, current liabilities $420,000?', 'answer' => '0.7143×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Below 1 means the company relies on other cash to pay current liabilities.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ocf" label="Operating cash flow" value="900000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Current liabilities" value="750000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Operating cash flow ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ocf' => 900000, 'liabilities' => 750000],
        'Example B' => ['ocf' => 300000, 'liabilities' => 420000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = operating cash flow ÷ current liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
