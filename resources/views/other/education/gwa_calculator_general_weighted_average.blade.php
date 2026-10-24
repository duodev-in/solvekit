<x-calc.page
    title="GWA Calculator – General Weighted Average - SolveKit"
    description="Free GWA calculator: general weighted average of grades on the Philippine 1.00–5.00 scale by units."
    lede="Find your GWA."
    about="The GWA weights each grade by its subject’s units; on the 1.00–5.00 scale lower is better."
    :calc="['engine' => 'ot-edu', 'tool' => 'gwa', 'fields' => ['subjects'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What GWA do the example grades give?', 'answer' => '1.667.'],
    ]"
>
    <x-calc.textarea name="subjects" label="Subjects: name, grade (1.00–5.00), units" value="Math 21, 1.75, 3
Chem 16, 2.00, 4
Eng 10, 1.25, 3
PE 2, 1.50, 2" rows="4" />

    <x-calc.result label="General weighted average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['subjects' => 'Math 21, 1.75, 3
Chem 16, 2.00, 4
Eng 10, 1.25, 3
PE 2, 1.50, 2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'units' => ['label' => 'Total units'],
            'best' => ['label' => 'Best grade'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
