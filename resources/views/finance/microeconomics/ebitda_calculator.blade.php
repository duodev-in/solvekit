<x-calc.page
    title="EBITDA Calculator - SolveKit"
    description="Free EBITDA Calculator: EBITDA = EBIT + depreciation + amortization. EBITDA approximates cash operating earnings before financing and non-cash charges."
    lede="Work out the EBITDA from EBIT, depreciation and amortization."
    about="EBITDA approximates cash operating earnings before financing and non-cash charges. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ebitda', 'fields' => ['ebit', 'depreciation', 'amortization']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBIT, Depreciation, Amortization.'],
        ['name' => 'Read the result', 'text' => 'The EBITDA appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EBITDA?', 'answer' => 'EBITDA = EBIT + depreciation + amortization.'],
        ['question' => 'What is the EBITDA for EBIT $400,000, depreciation $80,000, amortization $20,000?', 'answer' => '$500,000.00.'],
        ['question' => 'And for EBIT $1,200,000, depreciation $300,000, amortization $50,000?', 'answer' => '$1,550,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It is not cash flow: it ignores capital spending and working capital.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ebit" label="EBIT" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="depreciation" label="Depreciation" value="80000" step="0.01" suffix="$" />
        <x-calc.field name="amortization" label="Amortization" value="20000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="EBITDA" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebit' => 400000, 'depreciation' => 80000, 'amortization' => 20000],
        'Example B' => ['ebit' => 1200000, 'depreciation' => 300000, 'amortization' => 50000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EBITDA = EBIT + depreciation + amortization</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
