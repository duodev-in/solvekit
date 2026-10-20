<x-calc.page
    title="Root Mean Square Calculator - SolveKit"
    description="Free root mean square calculator: the quadratic mean √(Σx²/n) of a list, as used for AC voltage and errors."
    lede="Calculate the RMS."
    about="RMS = √((x₁² + … + xₙ²) ÷ n). It weights large values more than the ordinary mean and is used for alternating current, noise and RMS error."
    :calc="['engine' => 'mt-number', 'tool' => 'stats', 'fields' => ['list'], 'kind' => 'rms']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the RMS of 3, 4, 5 and −6?', 'answer' => '4.63680924775.'],
    ]"
>
    <x-calc.textarea name="list" label="Numbers" value="3, 4, 5, -6" rows="3" />

    <x-calc.result label="Root mean square" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '3, 4, 5, -6'],
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
            <li>RMS = √(Σx²/n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
