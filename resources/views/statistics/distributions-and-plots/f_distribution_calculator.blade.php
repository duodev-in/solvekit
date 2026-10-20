<x-calc.page
    title="F-Distribution Calculator - SolveKit"
    description="Free F-distribution calculator: probabilities and critical F values for any numerator and denominator degrees of freedom."
    lede="Work with the F distribution."
    about="The F distribution is the ratio of two scaled χ² variables. It is used in ANOVA and to compare variances."
    :calc="['engine' => 'st-dist', 'tool' => 'f_dist', 'fields' => ['d1', 'd2', 'mode', 'a', 'b', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(F ≤ 3.1) with 3 and 20 df?', 'answer' => '0.95007547.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d1" label="Numerator df" value="3" min="0" step="any" />
        <x-calc.field name="d2" label="Denominator df" value="20" min="0" step="any" />
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(X ≤ x)', 'ge' => 'P(X ≥ x)', 'between' => 'P(a ≤ X ≤ b)', 'outside' => 'P(X < a or X > b)', 'inv' => 'x for a given P(X ≤ x)']" selected="le" />
        <div data-show-when="mode:le,ge,between,outside">
            <x-calc.field name="a" label="x (or the lower limit a)" value="3.1" step="any" />
        </div>
        <div data-show-when="mode:between,outside">
            <x-calc.field name="b" label="Upper limit b" value="4" step="any" />
        </div>
        <div data-show-when="mode:inv">
            <x-calc.field name="p" label="Probability P(X ≤ x)" value="0.95" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['d1' => 3, 'd2' => 20, 'mode' => 'le', 'a' => 3.1, 'b' => 4, 'p' => 0.95],
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
