<x-calc.page
    title="Scientific Notation Calculator - SolveKit"
    description="Free scientific notation calculator: write any number as a × 10ⁿ, with engineering notation, E notation and the standard decimal form."
    lede="Convert to scientific notation."
    about="Scientific notation writes a number as a × 10ⁿ with 1 ≤ |a| < 10: 0.000356 = 3.56 × 10⁻⁴ and 602,000,000,000,000,000,000,000 = 6.02 × 10²³. Engineering notation uses exponents that are multiples of 3, matching SI prefixes. Also known as scientific notation converter and exponential notation calculator."
    :calc="['engine' => 'mt-number', 'tool' => 'sci_notation', 'fields' => ['x'], 'mode' => 'sci']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.000356 in scientific notation?', 'answer' => '3.56 × 10⁻⁴.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="0.000356" type="text" help="Also accepts E notation such as 6.02e23" inputmode="decimal" />

    <x-calc.result label="Scientific notation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '0.000356'],
        'Avogadro' => ['x' => '602214076000000000000000'],
        'From E' => ['x' => '4.7e-9'],
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
