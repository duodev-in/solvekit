<x-calc.page
    title="Quotient Calculator - SolveKit"
    description="Free quotient calculator: the whole-number quotient and remainder of a division, with the decimal and mixed-number result."
    lede="Find the quotient and remainder."
    about="The quotient is how many times the divisor fits into the dividend: 100 ÷ 7 = 14 remainder 2, since 14 × 7 + 2 = 100. As a decimal it is 14.(285714)."
    :calc="['engine' => 'mt-number', 'tool' => 'division', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 100 ÷ 7?', 'answer' => '14 R 2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Dividend" value="100" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Divisor" value="7" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Quotient and remainder" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '100', 'b' => '7'],
        'Large' => ['a' => '987654321987654321', 'b' => '12345'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'quotient' => ['label' => 'Quotient'],
            'remainder' => ['label' => 'Remainder'],
            'decimal' => ['label' => 'Decimal'],
            'fraction' => ['label' => 'Mixed number'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a = qb + r, 0 ≤ r < b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
