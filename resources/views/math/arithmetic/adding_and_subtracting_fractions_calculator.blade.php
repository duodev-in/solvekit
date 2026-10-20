<x-calc.page
    title="Adding and Subtracting Fractions Calculator - SolveKit"
    description="Free adding and subtracting fractions calculator: add or subtract fractions and mixed numbers with the common-denominator steps."
    lede="Add or subtract fractions."
    about="Rewrite both fractions over the least common denominator, add or subtract the numerators, then simplify: 5/6 − 1/4 = 10/12 − 3/12 = 7/12."
    :calc="['engine' => 'mt-frac', 'tool' => 'binary', 'fields' => ['a', 'op', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 5/6 − 1/4?', 'answer' => '7/12.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="First fraction" value="5/6" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−']" selected="-" />
        <x-calc.field name="b" label="Second fraction" value="1/4" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result in lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '5/6', 'op' => '-', 'b' => '1/4'],
        'Add' => ['a' => '2 1/3', 'op' => '+', 'b' => '3/5'],
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
            <li>a/b ± c/d = (ad ± bc)/bd</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
