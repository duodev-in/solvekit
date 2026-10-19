<x-calc.page
    title="Expected Return Calculator - SolveKit"
    description="Free expected return calculator: probability-weighted return across scenarios, with standard deviation, best and worst case."
    lede="Find the expected return of an investment from scenarios."
    about="E(R) = Σ pᵢ Rᵢ. The standard deviation √Σ pᵢ (Rᵢ − E)² measures how spread out the scenarios are. Probabilities must add up to 100%. For a portfolio, use weights instead of probabilities. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'expected_return', 'fields' => ['scenarios', 'amount']]"
    :how-to="[
        ['name' => 'Add scenarios', 'text' => 'With probability and return.'],
        ['name' => 'Read the expected return', 'text' => 'And its spread.'],
    ]"
    :faqs="[
        ['question' => 'What is the expected return with 25% boom (18%), 50% normal (8%), 25% recession (−10%)?', 'answer' => '6%, standard deviation 10.1%.'],
    ]"
>
    <x-calc.rows-editor name="scenarios" label="Scenarios" :columns="['name' => 'Scenario', 'p' => 'Probability %', 'r' => 'Return %']" :rows="[['Boom', 25, 18], ['Normal', 50, 8], ['Recession', 25, -10]]" :text="['name']" />

    <x-calc.field name="amount" label="Amount invested (optional)" value="10000" step="0.01" suffix="$" />

    <x-calc.result label="Expected return" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['scenarios' => 'Boom	25	18
Normal	50	8
Recession	25	-10', 'amount' => 10000],
        'Coin flip' => ['scenarios' => 'Win	50	40
Lose	50	-20', 'amount' => 1000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sd' => ['label' => 'Standard deviation'],
            'best' => ['label' => 'Best case'],
            'worst' => ['label' => 'Worst case'],
            'gain' => ['label' => 'Expected gain'],
        ]" />
        <x-calc.quick-ref heading="Scenarios" name="scenarios" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E(R) = Σ pᵢ Rᵢ</li>
            <li>σ = √Σ pᵢ (Rᵢ − E)²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
