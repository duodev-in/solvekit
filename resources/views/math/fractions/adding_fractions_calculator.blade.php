<x-calc.page
    title="Adding Fractions Calculator - SolveKit"
    description="Free adding fractions calculator: add fractions and mixed numbers exactly, with the answer in lowest terms, as a mixed number and as a decimal, and every step."
    lede="Add fractions step by step."
    about="To add fractions, rewrite them over a common denominator (the least common multiple of the denominators), add the numerators and simplify: 2/3 + 3/4 = 8/12 + 9/12 = 17/12 = 1 5/12."
    :calc="['engine' => 'mt-frac', 'tool' => 'binary', 'fields' => ['a', 'b'], 'op' => '+']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 2/3 + 3/4?', 'answer' => '17/12 (1 5/12 as a mixed number).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First fraction" value="2/3" type="text" inputmode="text" />
        <x-calc.field name="b" label="Second fraction" value="3/4" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result in lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2/3', 'b' => '3/4'],
        'Mixed' => ['a' => '1 1/2', 'b' => '2 2/3'],
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
            <li>a/b + c/d = (ad + bc)/bd</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
