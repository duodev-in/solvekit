<x-calc.page
    title="Long Division Calculator - SolveKit"
    description="Free long division calculator: divide step by step (divide, multiply, subtract, bring down) with the remainder or decimal places."
    lede="Divide the long way."
    about="Long division works one digit at a time: divide the current number by the divisor, write the digit, multiply, subtract and bring down the next digit. Choose decimal places to keep going past the decimal point."
    :calc="['engine' => 'mt-arith', 'tool' => 'long_div', 'fields' => ['a', 'b', 'places']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 7452 ÷ 12 by long division?', 'answer' => '621 R 0.'],
        ['question' => 'And 100 ÷ 7 to 4 places?', 'answer' => '14.2857.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Dividend" value="7452" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Divisor" value="12" type="text" inputmode="decimal" />
        <x-calc.field name="places" label="Decimal places" value="0" min="0" max="20" step="1" />
    </div>

    <x-calc.result label="Quotient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '7452', 'b' => '12', 'places' => 0],
        'Decimals' => ['a' => '100', 'b' => '7', 'places' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'quotient' => ['label' => 'Whole quotient'],
            'remainder' => ['label' => 'Remainder'],
            'decimal' => ['label' => 'Exact decimal'],
        ]" />
        <x-calc.steps heading="Long division" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>divide, multiply, subtract, bring down</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
