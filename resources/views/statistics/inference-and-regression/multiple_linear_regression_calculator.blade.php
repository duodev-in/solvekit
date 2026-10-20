<x-calc.page
    title="Multiple Linear Regression Calculator - SolveKit"
    description="Free multiple regression calculator: fit y on up to 6 predictors with coefficients, standard errors, p-values, R² and F."
    lede="Fit a multiple regression."
    about="Multiple regression models y as a linear combination of several predictors, each coefficient holding the others fixed."
    :calc="['engine' => 'st-inf', 'tool' => 'multiple_reg', 'fields' => ['data', 'names'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What equation fits the example?', 'answer' => 'Sales = −4.38134 + 4.91552·Ads + 0.373717·Price.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Rows: y, x₁, x₂, … (one observation per line)" value="24, 2, 50
31, 3, 55
35, 4, 52
42, 5, 60
47, 6, 58
55, 7, 65
58, 8, 63
66, 9, 70" rows="8" />
        <x-calc.textarea name="names" label="Variable names (optional): y, x₁, x₂, …" value="Sales, Ads, Price" rows="3" />
    </div>

    <x-calc.result label="Fitted equation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '24, 2, 50
31, 3, 55
35, 4, 52
42, 5, 60
47, 6, 58
55, 7, 65
58, 8, 63
66, 9, 70', 'names' => 'Sales, Ads, Price'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r2' => ['label' => 'R²'],
            'adj' => ['label' => 'Adjusted R²'],
            'F' => ['label' => 'F test'],
            'se' => ['label' => 'Residual standard error'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Coefficients" name="coef" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
