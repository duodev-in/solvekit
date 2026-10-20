<x-calc.page
    title="Beta Distribution Calculator - SolveKit"
    description="Free beta distribution calculator: PDF, CDF, quantiles, mean and variance for shape parameters α and β, with a chart."
    lede="Work with the beta distribution."
    about="The beta distribution models proportions and probabilities on the interval 0 to 1, shaped by α and β."
    :calc="['engine' => 'st-dist', 'tool' => 'beta', 'fields' => ['alpha', 'beta', 'mode', 'a', 'b', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X ≤ 0.3) for α = 2, β = 5?', 'answer' => '0.579825.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="alpha" label="α (shape)" value="2" min="0" step="any" />
        <x-calc.field name="beta" label="β (shape)" value="5" min="0" step="any" />
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(X ≤ x)', 'ge' => 'P(X ≥ x)', 'between' => 'P(a ≤ X ≤ b)', 'outside' => 'P(X < a or X > b)', 'inv' => 'x for a given P(X ≤ x)']" selected="le" />
        <div data-show-when="mode:le,ge,between,outside">
            <x-calc.field name="a" label="x (or the lower limit a)" value="0.3" step="any" />
        </div>
        <div data-show-when="mode:between,outside">
            <x-calc.field name="b" label="Upper limit b" value="0.6" step="any" />
        </div>
        <div data-show-when="mode:inv">
            <x-calc.field name="p" label="Probability P(X ≤ x)" value="0.95" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['alpha' => 2, 'beta' => 5, 'mode' => 'le', 'a' => 0.3, 'b' => 0.6, 'p' => 0.95],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Distribution with the region shaded" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'pdf' => ['label' => 'Density f(x)'],
            'mean' => ['label' => 'Mean'],
            'sd' => ['label' => 'Standard deviation'],
            'median' => ['label' => 'Median'],
            'q' => ['label' => 'Quartiles (25%, 75%)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
