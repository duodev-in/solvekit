<x-calc.page
    title="Index of Qualitative Variation Calculator - SolveKit"
    description="Free index of qualitative variation calculator: how evenly categorical data are spread over the categories, from 0 to 1."
    lede="Find the IQV."
    about="The index of qualitative variation measures diversity for nominal data: 0 when everything is in one category, 1 when spread evenly."
    :calc="['engine' => 'st-desc', 'tool' => 'iqv', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the IQV for counts 40, 25, 20, 15?', 'answer' => '0.953333.'],
    ]"
>
    <x-calc.textarea name="data" label="Counts in each category" value="40, 25, 20, 15" rows="3" />

    <x-calc.result label="Index of qualitative variation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '40, 25, 20, 15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'Categories K'],
            'diversity' => ['label' => 'Gini–Simpson 1 − Σp²'],
            'shares' => ['label' => 'Shares'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
