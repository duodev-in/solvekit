<x-calc.page
    title="Cost of Equity Calculator - SolveKit"
    description="Free cost of equity calculator: the return shareholders require, by CAPM (risk-free rate + beta × risk premium) or the dividend growth model."
    lede="Estimate the cost of equity."
    about="CAPM: Rₑ = Rf + β × (market return − Rf). Dividend growth model: Rₑ = D₁ ÷ P₀ + g. Analysts often compare both. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'cost_of_equity', 'fields' => ['mode', 'rf', 'beta', 'mrp', 'dividend', 'price', 'growth']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter the inputs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the CAPM cost of equity at 4.2% risk-free, beta 1.1 and a 5.5% premium?', 'answer' => '10.25%.'],
        ['question' => 'And by dividend growth with $2.20 on a $55 share growing 4%?', 'answer' => '8%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['capm' => 'CAPM', 'ddm' => 'Dividend growth']" selected="capm" />

    <div data-show-when="mode:capm">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="rf" label="Risk-free rate" value="4.2" step="any" suffix="%" />
            <x-calc.field name="beta" label="Beta" value="1.1" step="any" />
            <x-calc.field name="mrp" label="Market risk premium" value="5.5" step="any" suffix="%" />
        </div>
    </div>

    <div data-show-when="mode:ddm" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="dividend" label="Next year's dividend" value="2.2" step="0.01" suffix="$" />
            <x-calc.field name="price" label="Share price" value="55" step="0.01" suffix="$" />
            <x-calc.field name="growth" label="Dividend growth" value="4" step="any" suffix="%" />
        </div>
    </div>

    <x-calc.result label="Cost of equity" />

    <x-calc.options :decimals="false" :examples="[
        'CAPM' => ['mode' => 'capm', 'rf' => 4.2, 'beta' => 1.1, 'mrp' => 5.5, 'dividend' => '', 'price' => '', 'growth' => ''],
        'Dividend growth' => ['mode' => 'ddm', 'rf' => '', 'beta' => '', 'mrp' => '', 'dividend' => 2.2, 'price' => 55, 'growth' => 4],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:capm">
            <x-calc.rows heading="Details" :rows="[
                'premium' => ['label' => 'Risk premium (β × MRP)'],
                'rf' => ['label' => 'Risk-free rate'],
            ]" />
        </div>
        <div data-show-when="mode:ddm" hidden>
            <x-calc.rows heading="Details" :rows="[
                'yield' => ['label' => 'Dividend yield'],
                'growth' => ['label' => 'Growth'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CAPM: Rₑ = Rf + β MRP</li>
            <li>DDM: Rₑ = D₁ ÷ P₀ + g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
