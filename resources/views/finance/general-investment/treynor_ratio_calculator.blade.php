<x-calc.page
    title="Treynor Ratio Calculator - SolveKit"
    description="Free Treynor Ratio Calculator: Treynor = (Rp − Rf) ÷ β. The Treynor ratio is excess return per unit of market (systematic) risk."
    lede="Work out the Treynor ratio from portfolio return, risk-free rate and beta."
    about="The Treynor ratio is excess return per unit of market (systematic) risk. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'treynor_ratio', 'fields' => ['portfolio', 'rf', 'beta']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Portfolio return, Risk-free rate, Beta.'],
        ['name' => 'Read the result', 'text' => 'The Treynor ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the Treynor ratio?', 'answer' => 'Treynor = (Rp − Rf) ÷ β.'],
        ['question' => 'What is the Treynor ratio for portfolio return 12%, risk-free rate 4%, beta 1.1?', 'answer' => '7.273%.'],
        ['question' => 'And for portfolio return 9%, risk-free rate 3%, beta 0.75?', 'answer' => '8%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use it for diversified portfolios; Sharpe suits single holdings.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="portfolio" label="Portfolio return" value="12" step="any" suffix="%" />
        <x-calc.field name="rf" label="Risk-free rate" value="4" step="any" suffix="%" />
        <x-calc.field name="beta" label="Beta" value="1.1" step="any" />
    </div>

    <x-calc.result label="Treynor ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['portfolio' => 12, 'rf' => 4, 'beta' => 1.1],
        'Example B' => ['portfolio' => 9, 'rf' => 3, 'beta' => 0.75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Treynor = (Rp − Rf) ÷ β</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
