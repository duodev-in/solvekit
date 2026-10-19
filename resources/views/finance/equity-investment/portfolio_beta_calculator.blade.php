<x-calc.page
    title="Portfolio Beta Calculator - SolveKit"
    description="Free portfolio beta calculator: value-weighted beta of your holdings and the market exposure it implies."
    lede="Find your portfolio's beta."
    about="Portfolio beta = Σ (holding value ÷ total) × holding beta. Shorting the market worth beta × portfolio value would hedge the market exposure. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'portfolio_beta', 'fields' => ['holdings']]"
    :how-to="[
        ['name' => 'List holdings', 'text' => 'Value and beta.'],
        ['name' => 'Read the beta', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the beta of the example portfolio?', 'answer' => '0.87.'],
    ]"
>
    <x-calc.rows-editor name="holdings" label="Holdings" :columns="['name' => 'Holding', 'value' => 'Value', 'beta' => 'Beta']" :rows="[['Index fund', 50000, 1], ['Tech stock', 20000, 1.4], ['Utility', 15000, 0.5], ['Bonds', 15000, 0.1]]" :text="['name']" />

    <x-calc.result label="Portfolio beta" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['holdings' => 'Index fund	50000	1
Tech stock	20000	1.4
Utility	15000	0.5
Bonds	15000	0.1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Portfolio value'],
            'highest' => ['label' => 'Highest-beta holding'],
            'count' => ['label' => 'Holdings'],
            'hedge' => ['label' => 'Market hedge'],
        ]" />
        <x-calc.quick-ref heading="Weights" name="weights" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>βp = Σ wᵢ βᵢ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
