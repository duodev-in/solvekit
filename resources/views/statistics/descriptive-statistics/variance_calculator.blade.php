<x-calc.page
    title="Variance Calculator - SolveKit"
    description="Free variance calculator: sample or population variance with the standard deviation and squared deviations."
    lede="Find the variance."
    about="Variance is the average squared deviation from the mean; its square root is the standard deviation."
    :calc="['engine' => 'st-desc', 'tool' => 'variance', 'fields' => ['data', 'kind'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the sample variance of 6, 2, 3, 1, 8, 4?', 'answer' => '6.8.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="6, 2, 3, 1, 8, 4" rows="3" />
        <x-calc.select name="kind" label="Data are a" :options="['sample' => 'Sample (divide by n − 1)', 'population' => 'Population (divide by N)']" selected="sample" />
    </div>

    <x-calc.result label="Variance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '6, 2, 3, 1, 8, 4', 'kind' => 'sample'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sd' => ['label' => 'Standard deviation'],
            'mean' => ['label' => 'Mean'],
            'other' => ['label' => 'The other version'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Squared deviations" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
