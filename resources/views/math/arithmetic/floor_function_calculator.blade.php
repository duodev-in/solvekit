<x-calc.page
    title="Floor Function Calculator - SolveKit"
    description="Free floor function calculator: ⌊x⌋, the greatest integer less than or equal to x, with the fractional part."
    lede="Calculate the floor."
    about="The floor ⌊x⌋ rounds down: ⌊2.9⌋ = 2 and ⌊−2.1⌋ = −3 (down means towards −∞, not towards zero). x − ⌊x⌋ is the fractional part, always in [0, 1)."
    :calc="['engine' => 'mt-number', 'tool' => 'floor_ceil', 'fields' => ['x'], 'fn' => 'floor']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is ⌊−2.1⌋?', 'answer' => '−3.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="-2.1" type="text" inputmode="text" />

    <x-calc.result label="Floor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '-2.1'],
        'Positive' => ['x' => '7.999'],
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
            <li>⌊x⌋ = max{n ∈ ℤ : n ≤ x}</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
