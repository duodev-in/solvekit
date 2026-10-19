<x-calc.page
    title="hCG Levels Calculator - SolveKit"
    description="Free hCG calculator: doubling time and percentage rise between two hCG blood tests, against the minimum expected rise in early pregnancy."
    lede="Check how fast hCG is rising."
    about="In early pregnancy hCG usually doubles every 48–72 hours. Doubling time = hours × ln 2 ÷ ln(second ÷ first). Barnhart and colleagues (2016) found the minimum 48-hour rise in viable pregnancies depends on the starting level: 49% under 1,500 mIU/mL, 40% at 1,500–3,000 and 33% above 3,000. Results must be read with ultrasound by the care team. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'hcg', 'fields' => ['h1', 'h2', 'hours']]"
    :how-to="[
        ['name' => 'Enter both results', 'text' => 'From the same lab.'],
        ['name' => 'Enter the hours between tests', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the doubling time from 120 to 260 in 48 hours?', 'answer' => '43.0 hours (Rise 117% over 48 hours (at or above the expected minimum of 49%)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="h1" label="First hCG" value="120" min="0" step="any" suffix="mIU/mL" />
        <x-calc.field name="h2" label="Second hCG" value="260" min="0" step="any" suffix="mIU/mL" />
        <x-calc.field name="hours" label="Hours between" value="48" min="1" step="any" suffix="h" />
    </div>

    <x-calc.result label="hCG doubling time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['h1' => 120, 'h2' => 260, 'hours' => 48],
        'Slow rise' => ['h1' => 1800, 'h2' => 2200, 'hours' => 48],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rise' => ['label' => 'Rise in 48 h'],
            'minimum' => ['label' => 'Expected minimum'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>t₂ = t × ln 2 ÷ ln(h₂ ÷ h₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
