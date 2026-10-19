<x-calc.page
    title="CAPM Calculator – Capital Asset Pricing Model - SolveKit"
    description="Free CAPM Calculator – Capital Asset Pricing Model: E(R) = Rf + β(Rm − Rf). The capital asset pricing model sets a stock's required return by its market risk (beta)."
    lede="Work out the expected return from risk-free rate, beta and expected market return."
    about="The capital asset pricing model sets a stock's required return by its market risk (beta). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'capm', 'fields' => ['rf', 'beta', 'market']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Risk-free rate, Beta, Expected market return.'],
        ['name' => 'Read the result', 'text' => 'The expected return appears as you type, with market risk premium below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the expected return?', 'answer' => 'E(R) = Rf + β(Rm − Rf).'],
        ['question' => 'What is the expected return for risk-free rate 4.2%, beta 1.15, expected market return 9.5%?', 'answer' => '10.29%. Market risk premium: 5.3%.'],
        ['question' => 'And for risk-free rate 3.8%, beta 0.7, expected market return 8.8%?', 'answer' => '7.3%. Market risk premium: 5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The market risk premium (Rm − Rf) is an estimate; many use 4–6%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rf" label="Risk-free rate" value="4.2" step="any" suffix="%" />
        <x-calc.field name="beta" label="Beta" value="1.15" step="any" />
        <x-calc.field name="market" label="Expected market return" value="9.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Expected return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rf' => 4.2, 'beta' => 1.15, 'market' => 9.5],
        'Example B' => ['rf' => 3.8, 'beta' => 0.7, 'market' => 8.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Market risk premium'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E(R) = Rf + β(Rm − Rf)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
