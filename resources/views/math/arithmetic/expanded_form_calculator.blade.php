<x-calc.page
    title="Expanded Form Calculator - SolveKit"
    description="Free expanded form calculator: write a number as the sum of its place values, with factors and powers of ten."
    lede="Write a number in expanded form."
    about="Expanded form writes each non-zero digit as its value: 4,305.27 = 4,000 + 300 + 5 + 0.2 + 0.07, or 4 × 10³ + 3 × 10² + 5 × 10⁰ + 2 × 10⁻¹ + 7 × 10⁻²."
    :calc="['engine' => 'mt-arith', 'tool' => 'place_value', 'fields' => ['x'], 'mode' => 'expanded']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 4,305.27 in expanded form?', 'answer' => '4,000 + 300 + 5 + 0.2 + 0.07.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="4305.27" type="text" inputmode="decimal" />

    <x-calc.result label="Expanded form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '4305.27'],
        'Whole' => ['x' => '90210'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'factors' => ['label' => 'With factors'],
            'powers' => ['label' => 'With powers of ten'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ dᵢ × 10ⁱ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
