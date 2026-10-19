<x-calc.page
    title="Rate Pressure Product Calculator - SolveKit"
    description="Free rate pressure product calculator: heart rate × systolic blood pressure, an index of how hard the heart is working."
    lede="Calculate the rate-pressure product."
    about="The rate-pressure product (double product) = heart rate × systolic BP. It tracks myocardial oxygen demand closely and is used in exercise testing and cardiac rehabilitation: typically 6,000–10,000 at rest and up to 25,000–40,000 at peak exercise. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'rpp', 'fields' => ['hr', 'sbp']]"
    :how-to="[
        ['name' => 'Enter heart rate and systolic pressure', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the RPP at 72 bpm and 120 mmHg?', 'answer' => '8,640 mmHg·bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hr" label="Heart rate" value="72" min="0" max="300" step="1" suffix="bpm" />
        <x-calc.field name="sbp" label="Systolic" value="120" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Rate-pressure product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hr' => 72, 'sbp' => 120],
        'Exercise' => ['hr' => 160, 'sbp' => 180],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'meaning' => ['label' => 'Meaning'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RPP = HR × SBP</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
