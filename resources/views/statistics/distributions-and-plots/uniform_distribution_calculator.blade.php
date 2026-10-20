<x-calc.page
    title="Uniform Distribution Calculator - SolveKit"
    description="Free uniform distribution calculator: probabilities, quantiles, mean and variance on an interval [a, b]."
    lede="Work with the uniform distribution."
    about="In a continuous uniform distribution every value between a and b is equally likely."
    :calc="['engine' => 'st-dist', 'tool' => 'uniform', 'fields' => ['lo', 'hi', 'mode', 'a', 'b', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X ≤ 3) on [0, 10]?', 'answer' => '0.3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lo" label="Minimum a" value="0" step="any" />
        <x-calc.field name="hi" label="Maximum b" value="10" step="any" />
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(X ≤ x)', 'ge' => 'P(X ≥ x)', 'between' => 'P(a ≤ X ≤ b)', 'outside' => 'P(X < a or X > b)', 'inv' => 'x for a given P(X ≤ x)']" selected="le" />
        <div data-show-when="mode:le,ge,between,outside">
            <x-calc.field name="a" label="x (or the lower limit a)" value="3" step="any" />
        </div>
        <div data-show-when="mode:between,outside">
            <x-calc.field name="b" label="Upper limit b" value="7" step="any" />
        </div>
        <div data-show-when="mode:inv">
            <x-calc.field name="p" label="Probability P(X ≤ x)" value="0.95" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lo' => 0, 'hi' => 10, 'mode' => 'le', 'a' => 3, 'b' => 7, 'p' => 0.95],
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
