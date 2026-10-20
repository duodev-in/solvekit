<x-calc.page
    title="Logarithmic and Power Regression Calculator - SolveKit"
    description="Free logarithmic and power regression calculator: fit y = a + b ln x or y = a·xᵇ with R² and prediction."
    lede="Fit a log or power curve."
    about="Logarithmic curves rise quickly and then level off; power curves scale y with a power of x."
    :calc="['engine' => 'st-inf', 'tool' => 'log_power_reg', 'fields' => ['data', 'model', 'at'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What logarithmic curve fits the example?', 'answer' => 'y = 2.06189 + 1.95867 ln x.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2.1
2, 3.4
3, 4.2
4, 4.7
6, 5.6
8, 6.2
12, 6.9
16, 7.5" rows="8" />
        <x-calc.select name="model" label="Model" :options="['log' => 'Logarithmic: y = a + b ln x', 'power' => 'Power: y = a·xᵇ']" selected="log" />
        <x-calc.field name="at" label="Predict y at x (optional)" value="9" step="any" />
    </div>

    <x-calc.result label="Fitted curve" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1, 2.1
2, 3.4
3, 4.2
4, 4.7
6, 5.6
8, 6.2
12, 6.9
16, 7.5', 'model' => 'log', 'at' => 9],
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
