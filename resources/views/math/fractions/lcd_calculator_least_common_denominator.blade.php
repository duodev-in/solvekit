<x-calc.page
    title="LCD Calculator - Least Common Denominator - SolveKit"
    description="Free LCD calculator: the least common denominator of two or more fractions, and each fraction rewritten over it."
    lede="Find the least common denominator."
    about="The least common denominator is the least common multiple of the denominators. For 1/6, 3/8 and 5/12 it is 24, so they become 4/24, 9/24 and 10/24, ready to add or compare. Also known as lowest common denominator calculator, common denominator calculator and least common denominator calculator."
    :calc="['engine' => 'mt-frac', 'tool' => 'lcd', 'fields' => ['list']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the LCD of 1/6, 3/8 and 5/12?', 'answer' => '24.'],
    ]"
>
    <x-calc.field name="list" label="Fractions" value="1/6, 3/8, 5/12" type="text" inputmode="text" />

    <x-calc.result label="Least common denominator" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '1/6, 3/8, 5/12'],
        'Two' => ['list' => '2/9, 5/6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rewritten' => ['label' => 'Rewritten fractions'],
            'product' => ['label' => 'Product of denominators'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LCD = lcm(denominators)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
