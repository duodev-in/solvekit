<x-calc.page
    title="Middle School GPA Calculator - SolveKit"
    description="Free middle school GPA calculator: GPA from letter grades on the 4.0 scale."
    lede="Find a middle school GPA."
    about="Middle-school GPA is usually the simple average of grade points."
    :calc="['engine' => 'ot-edu', 'tool' => 'ms_gpa', 'fields' => ['grades'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What GPA do A, B+, A-, B, A, C+ give?', 'answer' => '3.38.'],
    ]"
>
    <x-calc.textarea name="grades" label="Grades (one per subject: letters or %)" value="A, B+, A-, B, A, C+" rows="3" />

    <x-calc.result label="GPA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['grades' => 'A, B+, A-, B, A, C+'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'subjects' => ['label' => 'Subjects'],
            'letter' => ['label' => 'Average letter'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
