<x-calc.page
    title="Subtracting Fractions Calculator - SolveKit"
    description="Free subtracting fractions calculator: subtract fractions and mixed numbers exactly, with every step."
    lede="Subtract fractions."
    about="Subtract numerators over a common denominator: 3/4 − 2/3 = 9/12 − 8/12 = 1/12. With mixed numbers, convert to improper fractions first or borrow a whole."
    :calc="['engine' => 'mt-frac', 'tool' => 'binary', 'fields' => ['a', 'b'], 'op' => '-']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 3/4 − 2/3?', 'answer' => '1/12.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First fraction" value="3/4" type="text" inputmode="text" />
        <x-calc.field name="b" label="Fraction to subtract" value="2/3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result in lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3/4', 'b' => '2/3'],
        'Mixed' => ['a' => '4 1/5', 'b' => '1 1/2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mixed' => ['label' => 'Mixed number'],
            'decimal' => ['label' => 'Decimal'],
            'reciprocal' => ['label' => 'Reciprocal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a/b − c/d = (ad − bc)/bd</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
