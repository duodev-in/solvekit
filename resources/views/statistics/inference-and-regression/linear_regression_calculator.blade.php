<x-calc.page
    title="Linear Regression Calculator - SolveKit"
    description="Free linear regression calculator: least-squares line with standard errors, p-values, R², confidence and prediction intervals."
    lede="Fit a regression line."
    about="Linear regression fits the straight line that minimises the squared vertical distances to the points."
    :calc="['engine' => 'st-inf', 'tool' => 'linear_reg', 'fields' => ['data', 'conf', 'at'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What line fits the example?', 'answer' => 'ŷ = 0.0178571 + 1.99881x (R² 0.99852013).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1" rows="8" />
        <x-calc.field name="conf" label="Confidence for intervals (%)" value="95" min="0" step="any" />
        <x-calc.field name="at" label="Predict y at x (optional)" value="9" step="any" />
    </div>

    <x-calc.result label="Regression line" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1', 'conf' => 95, 'at' => 9],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Data and fitted curve" name="fit" />
        <x-calc.rows heading="Details" :rows="[
            'equation' => ['label' => 'Equation'],
            'r2' => ['label' => 'R²'],
            'adj' => ['label' => 'Adjusted R²'],
            'se' => ['label' => 'Residual standard error'],
            'prediction' => ['label' => 'Prediction at x'],
            'ci' => ['label' => 'Confidence interval (mean response)'],
            'pi' => ['label' => 'Prediction interval (new value)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Coefficients" name="coef" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
