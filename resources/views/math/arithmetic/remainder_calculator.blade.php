<x-calc.page
    title="Remainder Calculator - SolveKit"
    description="Free remainder calculator: the remainder when one whole number is divided by another, with the quotient."
    lede="Find the remainder."
    about="The remainder is what is left after taking out as many whole copies of the divisor as possible: 53 ÷ 6 = 8 remainder 5. It is always smaller than the divisor."
    :calc="['engine' => 'mt-number', 'tool' => 'division', 'fields' => ['a', 'b'], 'want' => 'remainder']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the remainder of 53 ÷ 6?', 'answer' => '5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Dividend" value="53" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Divisor" value="6" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Remainder" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '53', 'b' => '6'],
        'Exact' => ['a' => '144', 'b' => '12'],
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
            <li>r = a − b⌊a/b⌋</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
