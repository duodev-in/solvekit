<x-calc.page
    title="Dispersion Calculator - SolveKit"
    description="Free dispersion calculator: range, IQR, variance, standard deviation, mean and median absolute deviation, CV and index of dispersion."
    lede="Measure spread."
    about="Measures of dispersion describe how spread out data are. Each weighs the extremes differently."
    :calc="['engine' => 'st-desc', 'tool' => 'dispersion', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the standard deviation of the example?', 'answer' => '2.7668675.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="12, 15, 11, 18, 14, 16, 13, 20, 15, 17" rows="3" />

    <x-calc.result label="Standard deviation (sample)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '12, 15, 11, 18, 14, 16, 13, 20, 15, 17'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Range'],
            'iqr' => ['label' => 'Interquartile range'],
            'variance' => ['label' => 'Variance (sample)'],
            'mad' => ['label' => 'Mean absolute deviation'],
            'medad' => ['label' => 'Median absolute deviation'],
            'cv' => ['label' => 'Coefficient of variation'],
            'iod' => ['label' => 'Index of dispersion (variance ÷ mean)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
