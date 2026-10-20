<x-calc.page
    title="Multiplying Scientific Notation Calculator - SolveKit"
    description="Free multiplying scientific notation calculator: multiply, divide, add or subtract numbers in scientific notation exactly and normalise the result."
    lede="Calculate with scientific notation."
    about="To multiply, multiply the mantissas and add the exponents, then normalise: (3 × 10⁴)(5 × 10⁻²) = 15 × 10² = 1.5 × 10³. To divide, divide the mantissas and subtract the exponents. Adding needs equal exponents first. Also known as scientific notation equation calculator."
    :calc="['engine' => 'mt-number', 'tool' => 'sci_arith', 'fields' => ['a', 'op', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is (3 × 10⁴)(5 × 10⁻²)?', 'answer' => '1.5 × 10³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="First number" value="3e4" type="text" inputmode="decimal" />
        <x-calc.select name="op" label="Operation" :options="['*' => '×', '/' => '÷', '+' => '+', '-' => '−']" selected="*" />
        <x-calc.field name="b" label="Second number" value="5e-2" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3e4', 'op' => '*', 'b' => '5e-2'],
        'Divide' => ['a' => '6.4e9', 'op' => '/', 'b' => '1.6e-3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'scientific' => ['label' => 'Scientific'],
            'standard' => ['label' => 'Standard decimal'],
            'e' => ['label' => 'E notation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(a × 10ᵐ)(b × 10ⁿ) = ab × 10ᵐ⁺ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
