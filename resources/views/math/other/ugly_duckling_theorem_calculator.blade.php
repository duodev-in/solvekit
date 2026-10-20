<x-calc.page
    title="Ugly Duckling Theorem Calculator - SolveKit"
    description="Ugly duckling theorem calculator: with n objects, any two share exactly 2ⁿ⁻² of the 2ⁿ possible predicates."
    lede="Explore the ugly duckling theorem."
    about="Satosi Watanabe showed that if every possible way of grouping objects counts as a property, any two objects share exactly a quarter of them, so an ugly duckling is as similar to a swan as two swans are. Classification only works once we decide which features matter."
    :calc="['engine' => 'mt-other', 'tool' => 'ugly', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'With 5 objects, how many predicates do two share?', 'answer' => '8 of 32.'],
    ]"
>
    <x-calc.field name="n" label="Number of objects" value="5" min="2" max="60" step="1" />

    <x-calc.result label="Shared predicates" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'All predicates'],
            'shared' => ['label' => 'Shared by any two'],
            'share' => ['label' => 'Share'],
            'lesson' => ['label' => 'Lesson'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>2ⁿ⁻² of 2ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
