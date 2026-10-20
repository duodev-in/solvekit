<x-calc.page
    title="Least Squares Regression Line Calculator - SolveKit"
    description="Free least squares regression calculator: the best-fit line y = mx + b, the correlation r and r², with predictions."
    lede="Fit a line to data."
    about="The least squares line minimises the sum of squared vertical errors. Its slope is Sxy/Sxx and it passes through (x̄, ȳ). r measures the strength of the linear relationship and r² the share of variation explained. Also known as linear regression calculator and line of best fit calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'regression', 'fields' => ['points', 'x0']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What line best fits (1, 2), (2, 4.1), (3, 5.9), (4, 8.2), (5, 9.9)?', 'answer' => 'y = 1.99x + 0.05.'],
    ]"
>
    <x-calc.textarea name="points" label="Data points x, y (one per line)" value="1, 2
2, 4.1
3, 5.9
4, 8.2
5, 9.9" rows="6" />

    <x-calc.field name="x0" label="Predict y at x = (optional)" value="6" type="text" inputmode="decimal" />

    <x-calc.result label="Least squares line" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['points' => '1, 2
2, 4.1
3, 5.9
4, 8.2
5, 9.9', 'x0' => '6'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'equation' => ['label' => 'Line'],
            'r' => ['label' => 'Correlation r'],
            'r2' => ['label' => 'r²'],
            'means' => ['label' => 'Means'],
            'se' => ['label' => 'Standard error'],
            'predict' => ['label' => 'Prediction'],
            'count' => ['label' => 'Points'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m = Sxy ÷ Sxx, b = ȳ − m x̄</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
