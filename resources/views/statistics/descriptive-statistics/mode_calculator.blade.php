<x-calc.page
    title="Mode Calculator - SolveKit"
    description="Free mode calculator: the most frequent value(s) of numbers or words, with a frequency table."
    lede="Find the mode."
    about="The mode is the value that occurs most often. Data can have one mode, several or none."
    :calc="['engine' => 'st-desc', 'tool' => 'mode', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the mode of the example?', 'answer' => '3, 7.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (numbers or words)" value="3, 7, 7, 2, 9, 7, 3, 3, 5" rows="3" />

    <x-calc.result label="Mode" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '3, 7, 7, 2, 9, 7, 3, 3, 5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Occurs'],
            'kind' => ['label' => 'Type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Frequency of each value" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
