<x-calc.page
    title="Engineering Notation Calculator - SolveKit"
    description="Free engineering notation calculator: write a number with a power of ten that is a multiple of 3 (to match k, M, m, µ prefixes)."
    lede="Convert to engineering notation."
    about="Engineering notation is like scientific notation but the exponent is a multiple of 3, so the mantissa is between 1 and 1,000: 0.000047 = 47 × 10⁻⁶ (47 micro). It lines up with SI prefixes."
    :calc="['engine' => 'mt-number', 'tool' => 'sci_notation', 'fields' => ['x'], 'mode' => 'eng']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.000047 in engineering notation?', 'answer' => '47 × 10⁻⁶.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="0.000047" type="text" help="Also accepts E notation such as 6.02e23" inputmode="decimal" />

    <x-calc.result label="Scientific notation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '0.000047'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'scientific' => ['label' => 'Scientific'],
            'engineering' => ['label' => 'Engineering'],
            'standard' => ['label' => 'Standard decimal'],
            'e' => ['label' => 'E notation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x = a × 10ⁿ, 1 ≤ |a| < 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
