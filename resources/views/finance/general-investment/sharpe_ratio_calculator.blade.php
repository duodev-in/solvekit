<x-calc.page
    title="Sharpe Ratio Calculator - SolveKit"
    description="Free Sharpe Ratio Calculator: Sharpe = (Rp − Rf) ÷ σp. The Sharpe ratio is excess return per unit of total volatility (William Sharpe, 1966)."
    lede="Work out the Sharpe ratio from portfolio return, risk-free rate and standard deviation of returns."
    about="The Sharpe ratio is excess return per unit of total volatility (William Sharpe, 1966). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'sharpe_ratio', 'fields' => ['portfolio', 'rf', 'sd']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Portfolio return, Risk-free rate, Standard deviation of returns.'],
        ['name' => 'Read the result', 'text' => 'The Sharpe ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the Sharpe ratio?', 'answer' => 'Sharpe = (Rp − Rf) ÷ σp.'],
        ['question' => 'What is the Sharpe ratio for portfolio return 11%, risk-free rate 4%, standard deviation of returns 15%?', 'answer' => '0.4667.'],
        ['question' => 'And for portfolio return 7%, risk-free rate 4.5%, standard deviation of returns 9%?', 'answer' => '0.2778.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 1 is generally good; compare funds over the same period.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="portfolio" label="Portfolio return" value="11" step="any" suffix="%" />
        <x-calc.field name="rf" label="Risk-free rate" value="4" step="any" suffix="%" />
        <x-calc.field name="sd" label="Standard deviation of returns" value="15" step="any" suffix="%" />
    </div>

    <x-calc.result label="Sharpe ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['portfolio' => 11, 'rf' => 4, 'sd' => 15],
        'Example B' => ['portfolio' => 7, 'rf' => 4.5, 'sd' => 9],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Sharpe = (Rp − Rf) ÷ σp</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
