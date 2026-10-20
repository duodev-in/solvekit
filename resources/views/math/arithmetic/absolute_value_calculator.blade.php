<x-calc.page
    title="Absolute Value Calculator - SolveKit"
    description="Free absolute value calculator: |x| for numbers, fractions and expressions, the distance from zero."
    lede="Find an absolute value."
    about="The absolute value |x| is the distance of x from zero, so it is never negative: |−7| = 7, |3/4| = 3/4. Expressions are evaluated first: |3 − 10| = 7."
    :calc="['engine' => 'mt-number', 'tool' => 'abs_value', 'fields' => ['x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is |3 − 10|?', 'answer' => '7.'],
    ]"
>
    <x-calc.field name="x" label="Number or expression" value="3 - 10" type="text" inputmode="text" />

    <x-calc.result label="Absolute value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '3 - 10'],
        'Fraction' => ['x' => '-5/8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sign' => ['label' => 'Sign'],
            'opposite' => ['label' => 'Opposite'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|x| = x if x ≥ 0, −x otherwise</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
