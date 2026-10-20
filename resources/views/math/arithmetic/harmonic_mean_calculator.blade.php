<x-calc.page
    title="Harmonic Mean Calculator - SolveKit"
    description="Free harmonic mean calculator: n divided by the sum of reciprocals, the right average for rates such as speeds."
    lede="Calculate the harmonic mean."
    about="The harmonic mean is n ÷ Σ(1/x). Driving equal distances at 60 and 40 km/h gives an average speed of 2 ÷ (1/60 + 1/40) = 48 km/h, not 50."
    :calc="['engine' => 'mt-number', 'tool' => 'stats', 'fields' => ['list'], 'kind' => 'harmonic']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the average of 60 and 40 km/h over equal distances?', 'answer' => '48.'],
    ]"
>
    <x-calc.textarea name="list" label="Positive numbers" value="60, 40" rows="3" />

    <x-calc.result label="Harmonic mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '60, 40'],
        'Three' => ['list' => '1, 2, 4'],
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
            <li>H = n ÷ Σ(1/x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
