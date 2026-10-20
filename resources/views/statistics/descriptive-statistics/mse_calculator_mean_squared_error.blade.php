<x-calc.page
    title="MSE Calculator — Mean Squared Error - SolveKit"
    description="Free MSE calculator: mean squared error with RMSE, MAE and MAPE from observed and predicted values."
    lede="Find the mean squared error."
    about="The mean squared error averages the squared differences between observed and predicted values; its square root (RMSE) is in the data’s units."
    :calc="['engine' => 'st-desc', 'tool' => 'mse', 'fields' => ['observed', 'predicted'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the MSE of the example?', 'answer' => '0.308.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="observed" label="Observed (actual) values" value="3, -0.5, 2, 7, 4.2" rows="3" />
        <x-calc.textarea name="predicted" label="Predicted values (same order)" value="2.5, 0.0, 2, 8, 4.0" rows="3" />
    </div>

    <x-calc.result label="Mean squared error" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['observed' => '3, -0.5, 2, 7, 4.2', 'predicted' => '2.5, 0.0, 2, 8, 4.0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rmse' => ['label' => 'RMSE'],
            'mae' => ['label' => 'MAE'],
            'mape' => ['label' => 'MAPE'],
            'n' => ['label' => 'Pairs'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Errors" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
