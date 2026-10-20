<x-calc.page
    title="Egyptian Fractions Calculator - SolveKit"
    description="Free Egyptian fractions calculator: write a fraction as a sum of distinct unit fractions with the greedy algorithm."
    lede="Write a fraction as unit fractions."
    about="Ancient Egyptians wrote fractions as sums of different unit fractions (1/n). The greedy algorithm takes the largest unit fraction that fits each time: 4/13 = 1/4 + 1/18 + 1/468."
    :calc="['engine' => 'mt-frac', 'tool' => 'egyptian', 'fields' => ['value']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 4/13 as an Egyptian fraction?', 'answer' => '1/4 + 1/18 + 1/468.'],
    ]"
>
    <x-calc.field name="value" label="Fraction between 0 and 1" value="4/13" type="text" inputmode="text" />

    <x-calc.result label="Unit fractions" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '4/13'],
        'Simple' => ['value' => '3/4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Number of terms'],
            'largest' => ['label' => 'Largest denominator'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>greedy: 1/⌈1/x⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
