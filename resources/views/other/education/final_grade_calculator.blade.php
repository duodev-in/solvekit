<x-calc.page
    title="Final Grade Calculator - SolveKit"
    description="Free final grade calculator: the score you need on the final exam for the grade you want."
    lede="Find the score you need on the final."
    about="Your course grade is a weighted mix of your current grade and the final exam."
    :calc="['engine' => 'ot-edu', 'tool' => 'final_grade', 'fields' => ['current', 'weight', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What do I need on a 30% final to go from 84% to 85%?', 'answer' => '87.33%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="current" label="Current grade (%)" value="84" min="0" step="any" />
        <x-calc.field name="weight" label="Final exam weight (%)" value="30" min="0" step="any" />
        <x-calc.field name="target" label="Grade you want (%)" value="85" min="0" step="any" />
    </div>

    <x-calc.result label="Score needed on the final" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['current' => 84, 'weight' => 30, 'target' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'letter' => ['label' => 'Target letter grade'],
            'table' => ['label' => 'Course grade for each final score'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
