<x-calc.page
    title="Australia Income Tax Calculator 2026–27 - SolveKit"
    description="Free Australian income tax calculator for 2026–27: resident tax with the new 15% rate, Medicare levy and low income tax offset, and your take-home pay."
    lede="Work out Australian income tax for 2026–27."
    about="From July 1, 2026 the rate on income between $18,201 and $45,000 falls to 15% (and to 14% from July 2027). Rates: nil to $18,200, 15% to $45,000, 30% to $135,000, 37% to $190,000 and 45% above, plus the 2% Medicare levy. The low income tax offset (up to $700) reduces tax for incomes under $66,667. This replaces the outdated 2020–21 budget calculator. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'australia', 'fields' => ['income', 'medicare'], 'data' => ['australia' => config('finance_data.australia')], 'sym' => 'AUD', 'currency' => 'AUD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter taxable income', 'text' => ''],
        ['name' => 'Choose Medicare levy', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the tax on A$85,000 in 2026–27?', 'answer' => 'A$17,720.00.'],
        ['question' => 'And on A$40,000?', 'answer' => 'A$3,495.00.'],
    ]"
>
    <x-calc.field name="income" label="Taxable income" value="85000" step="0.01" suffix="A$" />

    <x-calc.checkbox name="medicare" label="Pay the Medicare levy" :checked="true" />

    <x-calc.result label="Income tax 2026–27" />

    <x-calc.options :decimals="false" :examples="[
        'A$85k' => ['income' => 85000, 'medicare' => true],
        'A$40k' => ['income' => 40000, 'medicare' => true],
        'A$200k' => ['income' => 200000, 'medicare' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tax' => ['label' => 'Tax on income'],
            'lito' => ['label' => 'Low income tax offset'],
            'medicare' => ['label' => 'Medicare levy'],
            'marginal' => ['label' => 'Marginal rate'],
            'fortnight' => ['label' => 'Take-home per fortnight'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tax = brackets − LITO</li>
            <li>+ 2% Medicare levy</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
