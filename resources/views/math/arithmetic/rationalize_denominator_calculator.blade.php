<x-calc.page
    title="Rationalize Denominator Calculator - SolveKit"
    description="Free rationalize the denominator calculator: remove a square root from a denominator using √c or the conjugate."
    lede="Rationalise a denominator."
    about="Multiply top and bottom by √c to clear a single root (3/√2 = 3√2/2), or by the conjugate to clear a binomial: 1/(3 + √2) = (3 − √2)/(9 − 2) = (3 − √2)/7."
    :calc="['engine' => 'mt-number', 'tool' => 'rationalize', 'fields' => ['a', 'd', 'b', 'c']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Rationalise 1/(3 + √2).', 'answer' => '(3 − √2)/7.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="a" label="Numerator a" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="d" label="Denominator whole part d" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Coefficient b of √c" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="c (under the root)" value="2" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Rationalised" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1', 'd' => '3', 'b' => '1', 'c' => '2'],
        'Single root' => ['a' => '3', 'd' => '0', 'b' => '1', 'c' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'simplified' => ['label' => 'Simplified'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a/(d + b√c) × (d − b√c)/(d − b√c)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
