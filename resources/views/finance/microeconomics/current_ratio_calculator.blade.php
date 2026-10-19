<x-calc.page
    title="Current Ratio Calculator - SolveKit"
    description="Free Current Ratio Calculator: current ratio = current assets ÷ current liabilities. The current ratio measures the ability to pay short-term obligations."
    lede="Work out the current ratio from current assets and current liabilities."
    about="The current ratio measures the ability to pay short-term obligations. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'current_ratio', 'fields' => ['assets', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Current assets, Current liabilities.'],
        ['name' => 'Read the result', 'text' => 'The current ratio appears as you type, with working capital below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the current ratio?', 'answer' => 'Current ratio = current assets ÷ current liabilities.'],
        ['question' => 'What is the current ratio for current assets $300,000, current liabilities $200,000?', 'answer' => '1.5×. Working capital: $100,000.00.'],
        ['question' => 'And for current assets $45,000, current liabilities $60,000?', 'answer' => '0.75×. Working capital: −$15,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Around 1.5–2 is often considered healthy; it varies by industry.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="assets" label="Current assets" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Current liabilities" value="200000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Current ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['assets' => 300000, 'liabilities' => 200000],
        'Example B' => ['assets' => 45000, 'liabilities' => 60000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Working capital'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>current ratio = current assets ÷ current liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
