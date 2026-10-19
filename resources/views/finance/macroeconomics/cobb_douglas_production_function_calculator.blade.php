<x-calc.page
    title="Cobb-Douglas Production Function Calculator - SolveKit"
    description="Free Cobb-Douglas Production Function Calculator: Y = A L^α K^β. The Cobb-Douglas production function models output from labor and capital."
    lede="Work out the output (Y) from your figures."
    about="The Cobb-Douglas production function models output from labor and capital. With α + β = 1 there are constant returns to scale. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cobb_douglas_production_function', 'fields' => ['a', 'l', 'k', 'alpha', 'beta']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total factor productivity (A), Labor (L), Capital (K), Labor elasticity (α), Capital elasticity (β).'],
        ['name' => 'Read the result', 'text' => 'The output (Y) appears as you type, with returns to scale (α + β), marginal product of labor, marginal product of capital below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the output (Y)?', 'answer' => 'Y = A L^α K^β.'],
        ['question' => 'What is the output (Y) for total factor productivity 1, labor 100, capital 50, labor elasticity 0.7, capital elasticity 0.3?', 'answer' => '81.23. Returns to scale (α + β): 1.'],
        ['question' => 'And for total factor productivity 2, labor 400, capital 900, labor elasticity 0.6, capital elasticity 0.4?', 'answer' => '1,106.53. Returns to scale (α + β): 1.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Marginal products: MPL = αY/L, MPK = βY/K.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Total factor productivity (A)" value="1" step="any" />
        <x-calc.field name="l" label="Labor (L)" value="100" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="k" label="Capital (K)" value="50" step="any" />
        <x-calc.field name="alpha" label="Labor elasticity (α)" value="0.7" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="beta" label="Capital elasticity (β)" value="0.3" step="any" />
    </div>

    <x-calc.result label="Output (Y)" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['a' => 1, 'l' => 100, 'k' => 50, 'alpha' => 0.7, 'beta' => 0.3],
        'Example B' => ['a' => 2, 'l' => 400, 'k' => 900, 'alpha' => 0.6, 'beta' => 0.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Returns to scale (α + β)'],
            'r2' => ['label' => 'Marginal product of labor'],
            'r3' => ['label' => 'Marginal product of capital'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Y = A L^α K^β</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
