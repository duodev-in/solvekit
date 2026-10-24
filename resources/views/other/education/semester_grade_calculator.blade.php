<x-calc.page
    title="Semester Grade Calculator - SolveKit"
    description="Free semester grade calculator: semester grade from term grades and the final exam, and the exam score needed."
    lede="Find your semester grade."
    about="A semester grade combines term grades and the final exam by their weights."
    :calc="['engine' => 'ot-edu', 'tool' => 'semester', 'fields' => ['q1', 'q2', 'w1', 'w2', 'exam', 'we', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the semester grade in the example?', 'answer' => '86%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="Term 1 (quarter) grade (%)" value="88" min="0" step="any" />
        <x-calc.field name="q2" label="Term 2 grade (%)" value="82" min="0" step="any" />
        <x-calc.field name="w1" label="Term 1 weight (%)" value="40" min="0" step="any" />
        <x-calc.field name="w2" label="Term 2 weight (%)" value="40" min="0" step="any" />
        <x-calc.field name="exam" label="Final exam (%, blank if not taken)" value="90" min="0" step="any" />
        <x-calc.field name="we" label="Final exam weight (%)" value="20" min="0" step="any" />
        <x-calc.field name="target" label="Target semester grade (optional)" value="90" min="0" step="any" />
    </div>

    <x-calc.result label="Semester grade" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 88, 'q2' => 82, 'w1' => 40, 'w2' => 40, 'exam' => 90, 'we' => 20, 'target' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'letter' => ['label' => 'Letter'],
            'needed' => ['label' => 'Exam score needed for the target'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
