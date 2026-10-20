<x-calc.page
    title="Exponential Regression Calculator - SolveKit"
    description="Free exponential regression calculator: fit y = a·bˣ with R² and prediction."
    lede="Fit an exponential curve."
    about="Exponential regression fits a curve that grows or decays by a constant factor per unit of x."
    :calc="['engine' => 'st-inf', 'tool' => 'exp_reg', 'fields' => ['data', 'at'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What curve fits the example?', 'answer' => 'y = 3.08478 × 1.49513ˣ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="x, y pairs (one per line)" value="0, 3.1
1, 4.6
2, 6.9
3, 10.2
4, 15.5
5, 23.1" rows="6" />
        <x-calc.field name="at" label="Predict y at x (optional)" value="9" step="any" />
    </div>

    <x-calc.result label="Exponential fit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '0, 3.1
1, 4.6
2, 6.9
3, 10.2
4, 15.5
5, 23.1', 'at' => 9],
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
