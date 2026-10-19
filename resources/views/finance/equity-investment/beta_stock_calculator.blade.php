<x-calc.page
    title="Beta Stock Calculator - SolveKit"
    description="Free stock beta calculator: beta, correlation and R² of a stock against the market from two lists of returns."
    lede="Calculate a stock's beta from returns."
    about="Beta = covariance(stock, market) ÷ variance(market), using the same periods for both (for example 60 monthly returns). Beta 1 moves with the market; above 1 amplifies it. Alpha here is the average return not explained by beta. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'beta', 'fields' => ['stock', 'market']]"
    :how-to="[
        ['name' => 'Paste both return series', 'text' => 'Same periods, oldest first.'],
        ['name' => 'Read beta', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the beta of the sample returns?', 'answer' => '1.402, with R² 99.18%.'],
    ]"
>
    <x-calc.textarea name="stock" label="Stock returns in % (comma or line separated)" value="2.1, -1.5, 3.4, 0.8, -2.2, 4.1, 1.2, -0.6, 2.9, -3.1" rows="3" />

    <x-calc.textarea name="market" label="Market returns in % (same periods)" value="1.5, -1.0, 2.2, 0.5, -1.8, 2.9, 0.9, -0.2, 1.8, -2.4" rows="3" />

    <x-calc.result label="Beta" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['stock' => '2.1, -1.5, 3.4, 0.8, -2.2, 4.1, 1.2, -0.6, 2.9, -3.1', 'market' => '1.5, -1.0, 2.2, 0.5, -1.8, 2.9, 0.9, -0.2, 1.8, -2.4'],
        'Defensive' => ['stock' => '0.8, -0.3, 1.0, 0.4, -0.6, 1.1, 0.5, 0.1, 0.7, -0.9', 'market' => '1.5, -1.0, 2.2, 0.5, -1.8, 2.9, 0.9, -0.2, 1.8, -2.4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'correlation' => ['label' => 'Correlation'],
            'r2' => ['label' => 'R²'],
            'alpha' => ['label' => 'Alpha'],
            'periods' => ['label' => 'Periods'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>β = Cov(Rs, Rm) ÷ Var(Rm)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
