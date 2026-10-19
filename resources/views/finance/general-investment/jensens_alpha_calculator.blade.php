<x-calc.page
    title="Jensen's Alpha Calculator - SolveKit"
    description="Free Jensen's Alpha Calculator: α = Rp − [Rf + β(Rm − Rf)]. Jensen's alpha is the return above what CAPM predicts for the portfolio's beta."
    lede="Work out the Jensen's alpha from your figures."
    about="Jensen's alpha is the return above what CAPM predicts for the portfolio's beta. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'jensens_alpha', 'fields' => ['portfolio', 'rf', 'beta', 'market']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Portfolio return, Risk-free rate, Portfolio beta, Market return.'],
        ['name' => 'Read the result', 'text' => 'The Jensen\'s alpha appears as you type, with CAPM expected return below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the Jensen\'s alpha?', 'answer' => 'α = Rp − [Rf + β(Rm − Rf)].'],
        ['question' => 'What is the Jensen\'s alpha for portfolio return 14%, risk-free rate 4%, portfolio beta 1.2, market return 10%?', 'answer' => '2.8%. CAPM expected return: 11.2%.'],
        ['question' => 'And for portfolio return 9%, risk-free rate 3.5%, portfolio beta 0.8, market return 11%?', 'answer' => '−0.5%. CAPM expected return: 9.5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Positive alpha means the manager beat the risk-adjusted benchmark.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="portfolio" label="Portfolio return" value="14" step="any" suffix="%" />
        <x-calc.field name="rf" label="Risk-free rate" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="beta" label="Portfolio beta" value="1.2" step="any" />
        <x-calc.field name="market" label="Market return" value="10" step="any" suffix="%" />
    </div>

    <x-calc.result label="Jensen's alpha" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['portfolio' => 14, 'rf' => 4, 'beta' => 1.2, 'market' => 10],
        'Example B' => ['portfolio' => 9, 'rf' => 3.5, 'beta' => 0.8, 'market' => 11],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'CAPM expected return'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>α = Rp − [Rf + β(Rm − Rf)]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
