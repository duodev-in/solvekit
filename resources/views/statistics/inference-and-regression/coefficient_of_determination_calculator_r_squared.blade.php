<x-calc.page
    title="Coefficient of Determination Calculator (R-squared) - SolveKit"
    description="Free R-squared calculator: R² and adjusted R² from x–y data or from observed and predicted values."
    lede="Find R²."
    about="R² is the share of the variation in y explained by the model."
    :calc="['engine' => 'st-inf', 'tool' => 'r_squared', 'fields' => ['mode', 'data', 'observed', 'predicted', 'k'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is R² for the example?', 'answer' => '0.99852013.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['pairs' => 'x, y data (straight-line fit)', 'predicted' => 'Observed and predicted values']" selected="pairs" />
        <div data-show-when="mode:pairs">
            <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1" rows="8" />
        </div>
        <div data-show-when="mode:predicted">
            <x-calc.textarea name="observed" label="Observed" value="3, 5, 7, 10, 12" rows="3" />
        </div>
        <div data-show-when="mode:predicted">
            <x-calc.textarea name="predicted" label="Predicted" value="2.8, 5.3, 7.1, 9.6, 12.2" rows="3" />
        </div>
        <div data-show-when="mode:predicted">
            <x-calc.field name="k" label="Predictors in the model (for adjusted R²)" value="1" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="R²" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'pairs', 'data' => '1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1', 'observed' => '3, 5, 7, 10, 12', 'predicted' => '2.8, 5.3, 7.1, 9.6, 12.2', 'k' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'adj' => ['label' => 'Adjusted R²'],
            'r' => ['label' => 'r (Pearson, pairs)'],
            'ss' => ['label' => 'SS residual and SS total'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
