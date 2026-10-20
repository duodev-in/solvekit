<x-calc.page
    title="Cronbach's Alpha Calculator - SolveKit"
    description="Free Cronbach's alpha calculator: internal consistency of a questionnaire scale, with alpha if each item is deleted."
    lede="Find Cronbach's α."
    about="Cronbach's α measures how consistently a set of questions measures one thing."
    :calc="['engine' => 'st-desc', 'tool' => 'cronbach', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is α for the example scale?', 'answer' => '0.93572.'],
    ]"
>
    <x-calc.textarea name="data" label="Item scores: one respondent per line, one column per item" value="4, 5, 4, 4
3, 3, 4, 3
5, 5, 5, 4
2, 3, 2, 2
4, 4, 3, 4
3, 4, 3, 3
5, 4, 5, 5
2, 2, 3, 2" rows="8" />

    <x-calc.result label="Cronbach’s α" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '4, 5, 4, 4
3, 3, 4, 3
5, 5, 5, 4
2, 3, 2, 2
4, 4, 3, 4
3, 4, 3, 3
5, 4, 5, 5
2, 2, 3, 2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'items' => ['label' => 'Items k'],
            'people' => ['label' => 'Respondents'],
            'band' => ['label' => 'Interpretation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="α if each item were deleted" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
