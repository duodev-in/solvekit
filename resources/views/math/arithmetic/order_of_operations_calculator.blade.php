<x-calc.page
    title="Order of Operations Calculator - SolveKit"
    description="Free order of operations calculator: evaluate an expression one step at a time following PEMDAS / BODMAS."
    lede="Evaluate step by step in the right order."
    about="Brackets first, then exponents, then multiplication and division from left to right, then addition and subtraction from left to right. 8 ÷ 4 × 2 is 4, not 1, because × and ÷ have equal rank."
    :calc="['engine' => 'mt-arith', 'tool' => 'order_ops', 'fields' => ['expr']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 3 + 4 × (2 − 1)² − 8 ÷ 4 × 2?', 'answer' => '3.'],
    ]"
>
    <x-calc.field name="expr" label="Expression" value="3 + 4 × (2 − 1)^2 − 8 ÷ 4 × 2" type="text" inputmode="text" />

    <x-calc.result label="Value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expr' => '3 + 4 × (2 − 1)^2 − 8 ÷ 4 × 2'],
        'Classic' => ['expr' => '6 ÷ 2 × (1 + 2)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact value'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Steps" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PEMDAS / BODMAS</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
