<x-calc.page
    title="Quick Ratio Calculator - SolveKit"
    description="Free Quick Ratio Calculator: quick ratio = (cash + securities + receivables) ÷ current liabilities. The acid-test ratio leaves out inventory, which may be slow to sell."
    lede="Work out the quick ratio from your figures."
    about="The acid-test ratio leaves out inventory, which may be slow to sell. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'quick_ratio', 'fields' => ['cash', 'securities', 'receivables', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cash and equivalents, Marketable securities, Receivables, Current liabilities.'],
        ['name' => 'Read the result', 'text' => 'The quick ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the quick ratio?', 'answer' => 'Quick ratio = (cash + securities + receivables) ÷ current liabilities.'],
        ['question' => 'What is the quick ratio for cash and equivalents $40,000, marketable securities $20,000, receivables $60,000, current liabilities $100,000?', 'answer' => '1.2×.'],
        ['question' => 'And for cash and equivalents $8,000, marketable securities $0, receivables $15,000, current liabilities $31,000?', 'answer' => '0.7419×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 1 means liquid assets cover current liabilities.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash" label="Cash and equivalents" value="40000" step="0.01" suffix="$" />
        <x-calc.field name="securities" label="Marketable securities" value="20000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="receivables" label="Receivables" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Current liabilities" value="100000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Quick ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cash' => 40000, 'securities' => 20000, 'receivables' => 60000, 'liabilities' => 100000],
        'Example B' => ['cash' => 8000, 'securities' => 0, 'receivables' => 15000, 'liabilities' => 31000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>quick ratio = (cash + securities + receivables) ÷ current liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
