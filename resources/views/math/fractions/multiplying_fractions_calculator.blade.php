<x-calc.page
    title="Multiplying Fractions Calculator - SolveKit"
    description="Free multiplying fractions calculator: multiply fractions and mixed numbers exactly, with the answer in lowest terms, as a mixed number and as a decimal, and every step."
    lede="Multiply fractions step by step."
    about="Multiply the numerators and the denominators, then simplify (or cancel common factors first): 3/4 × 2/9 = 6/36 = 1/6. Mixed numbers are turned into improper fractions first."
    :calc="['engine' => 'mt-frac', 'tool' => 'binary', 'fields' => ['a', 'b'], 'op' => '*']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 3/4 × 2/9?', 'answer' => '1/6 (1/6 as a mixed number).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First fraction" value="3/4" type="text" inputmode="text" />
        <x-calc.field name="b" label="Second fraction" value="2/9" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result in lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3/4', 'b' => '2/9'],
        'Mixed' => ['a' => '2 1/2', 'b' => '1 1/5'],
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
            <li>a/b × c/d = ac/bd</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
