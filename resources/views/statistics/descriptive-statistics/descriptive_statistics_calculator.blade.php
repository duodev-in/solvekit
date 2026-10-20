<x-calc.page
    title="Descriptive Statistics Calculator - SolveKit"
    description="Free descriptive statistics calculator: mean, median, mode, SD, variance, quartiles, range, skewness, kurtosis and more in one table."
    lede="Summarise a data set."
    about="Descriptive statistics summarise a data set’s centre, spread and shape."
    :calc="['engine' => 'st-desc', 'tool' => 'descriptive', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the mean of the example data?', 'answer' => '5.9.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="4.1, 5.3, 6.2, 5.8, 7.4, 6.6, 5.1, 4.9, 6.8, 7.1, 5.5, 6.0" rows="3" />

    <x-calc.result label="Mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '4.1, 5.3, 6.2, 5.8, 7.4, 6.6, 5.1, 4.9, 6.8, 7.1, 5.5, 6.0'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Box plot" name="box" />
        <x-calc.rows heading="Details" :rows="[
            'n' => ['label' => 'Count n'],
            'median' => ['label' => 'Median'],
            'sd' => ['label' => 'Standard deviation (sample)'],
            'range' => ['label' => 'Minimum – maximum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Summary statistics" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
