<x-calc.page
    title="Ceiling Function Calculator - SolveKit"
    description="Free ceiling function calculator: ⌈x⌉, the smallest integer greater than or equal to x, with floor and rounding for comparison."
    lede="Calculate the ceiling."
    about="The ceiling ⌈x⌉ rounds up to the next integer: ⌈2.1⌉ = 3, ⌈−2.1⌉ = −2 and ⌈5⌉ = 5. It answers questions like how many boxes are needed."
    :calc="['engine' => 'mt-number', 'tool' => 'floor_ceil', 'fields' => ['x'], 'fn' => 'ceil']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is ⌈−2.1⌉?', 'answer' => '−2.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="-2.1" type="text" inputmode="text" />

    <x-calc.result label="Ceiling" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '-2.1'],
        'Fraction' => ['x' => '17/4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'floor' => ['label' => 'Floor'],
            'ceil' => ['label' => 'Ceiling'],
            'round' => ['label' => 'Rounded'],
            'fraction' => ['label' => 'Fractional part'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>⌈x⌉ = min{n ∈ ℤ : n ≥ x}</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
