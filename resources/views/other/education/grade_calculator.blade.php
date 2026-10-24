<x-calc.page
    title="Grade Calculator - SolveKit"
    description="Free grade calculator: weighted course grade from assignments, and the average needed on the rest."
    lede="Find your course grade."
    about="A course grade is the weighted average of your assignments, quizzes and exams."
    :calc="['engine' => 'ot-edu', 'tool' => 'grade', 'fields' => ['items', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the current grade in the example?', 'answer' => '84.46%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="items" label="Assignments: name, score %, weight % (leave score blank if not done yet)" value="Homework, 92, 20
Quizzes, 85, 20
Midterm, 78, 25
Final exam, , 35" rows="4" />
        <x-calc.field name="target" label="Target course grade (%)" value="85" min="0" step="any" />
    </div>

    <x-calc.result label="Current grade" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 'Homework, 92, 20
Quizzes, 85, 20
Midterm, 78, 25
Final exam, , 35', 'target' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'letter' => ['label' => 'Letter grade'],
            'weightDone' => ['label' => 'Weight completed'],
            'needed' => ['label' => 'Average needed on the rest'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
