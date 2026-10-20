<x-calc.page
    title="Gamma Distribution Calculator - SolveKit"
    description="Free gamma distribution calculator: PDF, CDF, quantiles and mean for shape k and scale θ."
    lede="Work with the gamma distribution."
    about="The gamma distribution models waiting times for several events and positive skewed quantities such as rainfall."
    :calc="['engine' => 'st-dist', 'tool' => 'gamma_dist', 'fields' => ['shape', 'scale', 'mode', 'a', 'b', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X ≤ 5) for k = 2, θ = 3?', 'answer' => '0.49633173.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shape" label="Shape k" value="2" min="0" step="any" />
        <x-calc.field name="scale" label="Scale θ (1/rate)" value="3" min="0" step="any" />
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(X ≤ x)', 'ge' => 'P(X ≥ x)', 'between' => 'P(a ≤ X ≤ b)', 'outside' => 'P(X < a or X > b)', 'inv' => 'x for a given P(X ≤ x)']" selected="le" />
        <div data-show-when="mode:le,ge,between,outside">
            <x-calc.field name="a" label="x (or the lower limit a)" value="5" step="any" />
        </div>
        <div data-show-when="mode:between,outside">
            <x-calc.field name="b" label="Upper limit b" value="10" step="any" />
        </div>
        <div data-show-when="mode:inv">
            <x-calc.field name="p" label="Probability P(X ≤ x)" value="0.95" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['shape' => 2, 'scale' => 3, 'mode' => 'le', 'a' => 5, 'b' => 10, 'p' => 0.95],
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
