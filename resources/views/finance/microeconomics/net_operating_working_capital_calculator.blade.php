<x-calc.page
    title="Net Operating Working Capital Calculator - SolveKit"
    description="Free Net Operating Working Capital Calculator: NOWC = operating current assets − operating current liabilities. NOWC leaves out short-term debt and excess cash."
    lede="Work out the net operating working capital from current operating assets (cash needed, receivables, inventory) and current operating liabilities (payables, accruals)."
    about="NOWC leaves out short-term debt and excess cash. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_operating_working_capital', 'fields' => ['assets', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Current operating assets (cash needed, receivables, inventory), Current operating liabilities (payables, accruals).'],
        ['name' => 'Read the result', 'text' => 'The net operating working capital appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net operating working capital?', 'answer' => 'NOWC = operating current assets − operating current liabilities.'],
        ['question' => 'What is the net operating working capital for current operating assets $500,000, current operating liabilities $300,000?', 'answer' => '$200,000.00.'],
        ['question' => 'And for current operating assets $120,000, current operating liabilities $140,000?', 'answer' => '−$20,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Changes in NOWC enter free cash flow.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="assets" label="Current operating assets (cash needed, receivables, inventory)" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Current operating liabilities (payables, accruals)" value="300000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Net operating working capital" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['assets' => 500000, 'liabilities' => 300000],
        'Example B' => ['assets' => 120000, 'liabilities' => 140000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NOWC = operating current assets − operating current liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
