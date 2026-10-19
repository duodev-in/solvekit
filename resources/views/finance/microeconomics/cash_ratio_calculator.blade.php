<x-calc.page
    title="Cash Ratio Calculator - SolveKit"
    description="Free Cash Ratio Calculator: cash ratio = cash ÷ current liabilities. The strictest liquidity ratio: only cash and equivalents count."
    lede="Work out the cash ratio from cash and equivalents and current liabilities."
    about="The strictest liquidity ratio: only cash and equivalents count. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cash_ratio', 'fields' => ['cash', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cash and equivalents, Current liabilities.'],
        ['name' => 'Read the result', 'text' => 'The cash ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cash ratio?', 'answer' => 'Cash ratio = cash ÷ current liabilities.'],
        ['question' => 'What is the cash ratio for cash and equivalents $120,000, current liabilities $200,000?', 'answer' => '0.6×.'],
        ['question' => 'And for cash and equivalents $30,000, current liabilities $25,000?', 'answer' => '1.2×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 1 means cash alone covers current liabilities.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash" label="Cash and equivalents" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Current liabilities" value="200000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cash ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cash' => 120000, 'liabilities' => 200000],
        'Example B' => ['cash' => 30000, 'liabilities' => 25000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cash ratio = cash ÷ current liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
