<x-calc.page
    title="Long Addition Calculator - SolveKit"
    description="Free long addition calculator: add numbers in columns with the carries shown, the way it is taught at school."
    lede="Add in columns with carrying."
    about="Line the numbers up by place value (and decimal point), add each column from the right, write the units digit and carry the tens to the next column."
    :calc="['engine' => 'mt-arith', 'tool' => 'long_add', 'fields' => ['list']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Add 456 + 789 + 1205 in columns.', 'answer' => '2,450.'],
    ]"
>
    <x-calc.textarea name="list" label="Numbers (one per line)" value="456
789
1205" rows="5" />

    <x-calc.result label="Sum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '456
789
1205'],
        'Decimals' => ['list' => '12.5
3.75
0.125'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact sum'],
            'columns' => ['label' => 'Columns'],
        ]" />
        <x-calc.steps heading="Column method" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>column addition</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
