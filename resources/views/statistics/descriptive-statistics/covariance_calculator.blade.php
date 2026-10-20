<x-calc.page
    title="Covariance Calculator - SolveKit"
    description="Free covariance calculator: sample and population covariance of x–y data, with the correlation."
    lede="Find the covariance."
    about="Covariance measures how two variables vary together: positive when they rise together, negative when one falls as the other rises."
    :calc="['engine' => 'st-desc', 'tool' => 'covariance', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the sample covariance of the example?', 'answer' => '11.992857.'],
    ]"
>
    <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1" rows="8" />

    <x-calc.result label="Sample covariance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pop' => ['label' => 'Population covariance'],
            'r' => ['label' => 'Correlation r'],
            'means' => ['label' => 'Means x̄, ȳ'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
