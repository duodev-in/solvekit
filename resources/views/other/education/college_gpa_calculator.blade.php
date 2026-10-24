<x-calc.page
    title="College GPA Calculator - SolveKit"
    description="Free college GPA calculator: term and cumulative GPA from grades and credits, with the GPA needed next term."
    lede="Find your college GPA."
    about="College GPA weights each course’s grade points by its credits."
    :calc="['engine' => 'ot-edu', 'tool' => 'college_gpa', 'fields' => ['courses', 'prevGpa', 'prevCredits', 'target', 'nextCredits'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What GPA do the example courses give?', 'answer' => '3.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="courses" label="This term: course, grade, credits (one per line)" value="Calculus, A-, 4
Chemistry, B+, 4
English, A, 3
History, B, 3" rows="4" />
        <x-calc.field name="prevGpa" label="Cumulative GPA so far (optional)" value="3.2" min="0" step="any" />
        <x-calc.field name="prevCredits" label="Credits so far (optional)" value="45" min="0" step="any" />
        <x-calc.field name="target" label="Target cumulative GPA (optional)" value="3.5" min="0" step="any" />
        <x-calc.field name="nextCredits" label="Credits next term (for the target)" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="Term GPA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['courses' => 'Calculus, A-, 4
Chemistry, B+, 4
English, A, 3
History, B, 3', 'prevGpa' => 3.2, 'prevCredits' => 45, 'target' => 3.5, 'nextCredits' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cumulative' => ['label' => 'Cumulative GPA'],
            'credits' => ['label' => 'Credits this term'],
            'needed' => ['label' => 'GPA needed next term for the target'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Courses" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
