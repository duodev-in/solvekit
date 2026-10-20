<x-calc.page
    title="Long Subtraction Calculator - SolveKit"
    description="Free long subtraction calculator: subtract in columns with borrowing (regrouping) shown step by step."
    lede="Subtract in columns with borrowing."
    about="Subtract each column from the right. When the top digit is smaller, borrow 1 from the next column (it becomes 10 more); across zeros the borrow passes along: 5003 − 1478 = 3525."
    :calc="['engine' => 'mt-arith', 'tool' => 'long_sub', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 5003 − 1478 in columns?', 'answer' => '3,525.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Top number" value="5003" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Number to subtract" value="1478" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Difference" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '5003', 'b' => '1478'],
        'Decimals' => ['a' => '20.5', 'b' => '7.75'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact difference'],
            'columns' => ['label' => 'Columns'],
        ]" />
        <x-calc.steps heading="Column method" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>column subtraction</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
