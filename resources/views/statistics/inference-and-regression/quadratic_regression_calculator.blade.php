<x-calc.page
    title="Quadratic Regression Calculator - SolveKit"
    description="Free quadratic regression calculator: fit y = ax² + bx + c with R², coefficients and prediction."
    lede="Fit a parabola."
    about="Quadratic regression fits a parabola by least squares."
    :calc="['engine' => 'st-inf', 'tool' => 'quad_reg', 'fields' => ['data', 'at'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What parabola fits the example?', 'answer' => 'y = 1.0375x² − 0.105357x + 0.00892857.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="x, y pairs (one per line)" value="-3, 9.8
-2, 4.1
-1, 1.2
0, 0.1
1, 0.9
2, 4.2
3, 8.7
4, 16.3" rows="8" />
        <x-calc.field name="at" label="Predict y at x (optional)" value="9" step="any" />
    </div>

    <x-calc.result label="Quadratic fit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '-3, 9.8
-2, 4.1
-1, 1.2
0, 0.1
1, 0.9
2, 4.2
3, 8.7
4, 16.3', 'at' => 9],
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
