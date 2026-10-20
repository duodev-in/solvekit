<x-calc.page
    title="Geometric Mean Calculator - SolveKit"
    description="Free geometric mean calculator: the n-th root of the product of positive numbers, used for growth rates and ratios."
    lede="Calculate the geometric mean."
    about="The geometric mean is (x₁ × x₂ × … × xₙ)^(1/n). It is the right average for rates of growth: returns of +50% and −20% (factors 1.5 and 0.8) average to √1.2 ≈ 1.0954, about 9.5% a period."
    :calc="['engine' => 'mt-number', 'tool' => 'stats', 'fields' => ['list'], 'kind' => 'geometric']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the geometric mean of 1.5 and 0.8?', 'answer' => '1.09544511501.'],
    ]"
>
    <x-calc.textarea name="list" label="Positive numbers" value="1.5, 0.8" rows="3" />

    <x-calc.result label="Geometric mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '1.5, 0.8'],
        'Classic' => ['list' => '2, 8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mean' => ['label' => 'Arithmetic mean'],
            'geometric' => ['label' => 'Geometric mean'],
            'harmonic' => ['label' => 'Harmonic mean'],
            'rms' => ['label' => 'Root mean square'],
            'count' => ['label' => 'Count'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>G = (Πx)^(1/n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
