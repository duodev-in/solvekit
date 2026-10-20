<x-calc.page
    title="Decimal to Fraction Calculator - SolveKit"
    description="Free decimal to fraction calculator: convert terminating and repeating decimals to fractions in lowest terms, with the method."
    lede="Convert a decimal to a fraction."
    about="A terminating decimal is a fraction over a power of ten: 0.375 = 375/1000 = 3/8. For a repeating decimal, write the repeating block in brackets: 0.1(6) means 0.1666… = 1/6. The algebra (multiply by powers of ten and subtract) is shown."
    :calc="['engine' => 'mt-frac', 'tool' => 'from_decimal', 'fields' => ['value']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.375 as a fraction?', 'answer' => '3/8.'],
        ['question' => 'What is 0.1(6)?', 'answer' => '1/6.'],
    ]"
>
    <x-calc.field name="value" label="Decimal" value="0.375" type="text" help="Repeating blocks in brackets: 0.(3), 2.1(45)" inputmode="text" />

    <x-calc.result label="As a fraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '0.375'],
        'Repeating' => ['value' => '0.1(6)'],
        'Over one' => ['value' => '2.45'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mixed' => ['label' => 'Mixed number'],
            'percent' => ['label' => 'Percent'],
            'check' => ['label' => 'Back to a decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>0.d₁d₂… = digits / 10ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
