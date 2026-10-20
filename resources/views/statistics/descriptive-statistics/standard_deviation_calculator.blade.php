<x-calc.page
    title="Standard Deviation Calculator - SolveKit"
    description="Free standard deviation calculator: sample or population SD with variance, mean and the step-by-step table."
    lede="Find the standard deviation."
    about="The standard deviation measures how far values typically are from the mean. The sample version divides by n − 1."
    :calc="['engine' => 'st-desc', 'tool' => 'std_dev', 'fields' => ['data', 'kind'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the sample SD of 2, 4, 4, 4, 5, 5, 7, 9?', 'answer' => '2.138089935.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 4, 4, 4, 5, 5, 7, 9" rows="3" />
        <x-calc.select name="kind" label="Data are a" :options="['sample' => 'Sample (divide by n − 1)', 'population' => 'Population (divide by N)']" selected="sample" />
    </div>

    <x-calc.result label="Standard deviation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 4, 4, 4, 5, 5, 7, 9', 'kind' => 'sample'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'variance' => ['label' => 'Variance'],
            'mean' => ['label' => 'Mean'],
            'other' => ['label' => 'The other version'],
            'n' => ['label' => 'Count'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Deviations from the mean" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
