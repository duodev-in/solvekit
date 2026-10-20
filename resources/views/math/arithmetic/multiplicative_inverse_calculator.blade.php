<x-calc.page
    title="Multiplicative Inverse Calculator - SolveKit"
    description="Free multiplicative inverse calculator: the number that multiplies with x to give 1 (its reciprocal)."
    lede="Find the multiplicative inverse."
    about="The multiplicative inverse of a non-zero number x is 1/x, because x × 1/x = 1. For a mixed number, convert to an improper fraction first: (2 1/2)⁻¹ = (5/2)⁻¹ = 2/5."
    :calc="['engine' => 'mt-number', 'tool' => 'reciprocal', 'fields' => ['x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the inverse of 2 1/2?', 'answer' => '2/5.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="2 1/2" type="text" inputmode="text" />

    <x-calc.result label="Multiplicative inverse" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '2 1/2'],
        'Negative' => ['x' => '-4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
            'mixed' => ['label' => 'Mixed number'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x⁻¹ = 1/x</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
