<x-calc.page
    title="Mean Calculator - SolveKit"
    description="Free mean calculator: arithmetic, geometric, harmonic and quadratic (RMS) means of a list of numbers."
    lede="Calculate the mean."
    about="For positive numbers the means always satisfy harmonic ≤ geometric ≤ arithmetic ≤ quadratic, with equality only when all the numbers are equal. The arithmetic mean is the everyday average."
    :calc="['engine' => 'mt-number', 'tool' => 'stats', 'fields' => ['list'], 'kind' => 'mean']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What are the means of 2, 8, 4 and 16?', 'answer' => '7.5 (arithmetic).'],
    ]"
>
    <x-calc.textarea name="list" label="Numbers" value="2, 8, 4, 16" rows="3" />

    <x-calc.result label="Arithmetic mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '2, 8, 4, 16'],
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
            <li>A = Σx/n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
