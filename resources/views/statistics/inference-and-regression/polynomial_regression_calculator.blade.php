<x-calc.page
    title="Polynomial Regression Calculator - SolveKit"
    description="Free polynomial regression calculator: fit a polynomial of degree 1–6 with R², coefficients and prediction."
    lede="Fit a polynomial."
    about="Polynomial regression fits a curve of chosen degree by least squares. Also known as Quartic Regression Calculator."
    :calc="['engine' => 'st-inf', 'tool' => 'poly_reg', 'fields' => ['data', 'degree', 'at'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What quadratic fits the example?', 'answer' => 'y = 1.13571x² − 0.769048x + 1.24167.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="x, y pairs (one per line)" value="0, 1.2
1, 1.9
2, 4.1
3, 8.8
4, 16.3
5, 26.0
6, 37.9
7, 51.2" rows="8" />
        <x-calc.select name="degree" label="Degree" :options="['1' => '1 (straight line)', '2' => '2 (quadratic)', '3' => '3 (cubic)', '4' => '4 (quartic)', '5' => '5', '6' => '6']" selected="2" />
        <x-calc.field name="at" label="Predict y at x (optional)" value="9" step="any" />
    </div>

    <x-calc.result label="Polynomial fit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '0, 1.2
1, 1.9
2, 4.1
3, 8.8
4, 16.3
5, 26.0
6, 37.9
7, 51.2', 'degree' => '2', 'at' => 9],
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
