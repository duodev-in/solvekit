<x-calc.page
    title="FFO Calculator - SolveKit"
    description="Free FFO Calculator: FFO = net income + depreciation − gains on property sales (Nareit). Funds from operations is the standard REIT earnings measure defined by Nareit."
    lede="Work out the funds from operations from net income, real estate depreciation and amortization and gains on property sales."
    about="Funds from operations is the standard REIT earnings measure defined by Nareit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ffo', 'fields' => ['income', 'depreciation', 'gains']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Real estate depreciation and amortization, Gains on property sales.'],
        ['name' => 'Read the result', 'text' => 'The funds from operations appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the funds from operations?', 'answer' => 'FFO = net income + depreciation − gains on property sales (Nareit).'],
        ['question' => 'What is the funds from operations for net income $2,000,000, real estate depreciation and amortization $1,500,000, gains on property sales $300,000?', 'answer' => '$3,200,000.00.'],
        ['question' => 'And for net income $500,000, real estate depreciation and amortization $700,000, gains on property sales $0?', 'answer' => '$1,200,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'AFFO also subtracts recurring capital spending.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="Net income" value="2000000" step="0.01" suffix="$" />
        <x-calc.field name="depreciation" label="Real estate depreciation and amortization" value="1500000" step="0.01" suffix="$" />
        <x-calc.field name="gains" label="Gains on property sales" value="300000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Funds from operations" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 2000000, 'depreciation' => 1500000, 'gains' => 300000],
        'Example B' => ['income' => 500000, 'depreciation' => 700000, 'gains' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FFO = net income + depreciation − gains on property sales (Nareit)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
