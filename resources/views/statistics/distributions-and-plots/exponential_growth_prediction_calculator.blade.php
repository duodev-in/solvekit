<x-calc.page
    title="Exponential Growth Prediction Calculator - SolveKit"
    description="Free exponential growth prediction calculator: fit y = a·e^(kt) to your data, predict future values and find the doubling time."
    lede="Predict exponential growth."
    about="An exponential trend grows by a constant percentage each period. Fitting ln y against time gives the rate."
    :calc="['engine' => 'st-dist', 'tool' => 'exp_growth', 'fields' => ['data', 'at'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does the example predict at time 8?', 'answer' => '387.746 (doubling time 4.091).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Time, value pairs (one per line)" value="0, 100
1, 118
2, 141
3, 166
4, 197
5, 233" rows="6" />
        <x-calc.field name="at" label="Predict the value at time" value="8" step="any" />
    </div>

    <x-calc.result label="Predicted value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '0, 100
1, 118
2, 141
3, 166
4, 197
5, 233', 'at' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Data and fitted curve" name="fit" />
        <x-calc.rows heading="Details" :rows="[
            'model' => ['label' => 'Fitted model'],
            'rate' => ['label' => 'Growth rate per time unit'],
            'doubling' => ['label' => 'Doubling time'],
            'r2' => ['label' => 'R² (on ln y)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
