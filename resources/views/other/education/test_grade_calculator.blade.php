<x-calc.page
    title="Test Grade Calculator - SolveKit"
    description="Free test grade calculator: percentage and letter grade from questions and wrong answers, with a grading table."
    lede="Grade a test."
    about="A test score is the share of questions answered correctly."
    :calc="['engine' => 'ot-edu', 'tool' => 'test_grade', 'fields' => ['total', 'wrong'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is 7 wrong out of 40?', 'answer' => '82.5%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="total" label="Questions (or points) in the test" value="40" min="1" step="any" />
        <x-calc.field name="wrong" label="Wrong answers (or points lost)" value="7" min="0" step="any" />
    </div>

    <x-calc.result label="Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['total' => 40, 'wrong' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'letter' => ['label' => 'Letter grade'],
            'right' => ['label' => 'Correct'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Grading table" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
