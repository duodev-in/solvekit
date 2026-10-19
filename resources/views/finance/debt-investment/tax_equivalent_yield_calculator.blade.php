<x-calc.page
    title="Tax Equivalent Yield Calculator - SolveKit"
    description="Free Tax Equivalent Yield Calculator: TEY = tax-free yield ÷ (1 − tax rate). The taxable yield you would need to match a tax-exempt municipal bond."
    lede="Work out the tax-equivalent yield from tax-free yield, federal tax rate and state tax rate (if also exempt)."
    about="The taxable yield you would need to match a tax-exempt municipal bond. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'tax_equivalent_yield', 'fields' => ['yield', 'federal', 'state']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Tax-free yield, Federal tax rate, State tax rate (if also exempt).'],
        ['name' => 'Read the result', 'text' => 'The tax-equivalent yield appears as you type, with combined tax rate below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the tax-equivalent yield?', 'answer' => 'TEY = tax-free yield ÷ (1 − tax rate).'],
        ['question' => 'What is the tax-equivalent yield for tax-free yield 3.5%, federal tax rate 24%, state tax rate 0%?', 'answer' => '4.605%. Combined tax rate: 24%.'],
        ['question' => 'And for tax-free yield 3%, federal tax rate 35%, state tax rate 6%?', 'answer' => '4.91%. Combined tax rate: 38.9%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Higher brackets make tax-free bonds more attractive.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="yield" label="Tax-free yield" value="3.5" step="any" suffix="%" />
        <x-calc.field name="federal" label="Federal tax rate" value="24" step="any" suffix="%" />
        <x-calc.field name="state" label="State tax rate (if also exempt)" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Tax-equivalent yield" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['yield' => 3.5, 'federal' => 24, 'state' => 0],
        'Example B' => ['yield' => 3, 'federal' => 35, 'state' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Combined tax rate'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TEY = tax-free yield ÷ (1 − tax rate)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
