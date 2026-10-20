<x-calc.page
    title="Standard Notation Calculator - SolveKit"
    description="Free standard notation calculator: write a number given in scientific or E notation out in full decimal form."
    lede="Convert to standard notation."
    about="Standard (decimal) notation writes every digit: 4.5 × 10⁶ = 4,500,000 and 2.1 × 10⁻⁴ = 0.00021. Type the number in E notation (4.5e6)."
    :calc="['engine' => 'mt-number', 'tool' => 'sci_notation', 'fields' => ['x'], 'mode' => 'standard']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 4.5e6 written out?', 'answer' => '4,500,000.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="4.5e6" type="text" help="Also accepts E notation such as 6.02e23" inputmode="decimal" />

    <x-calc.result label="Scientific notation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '4.5e6'],
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
