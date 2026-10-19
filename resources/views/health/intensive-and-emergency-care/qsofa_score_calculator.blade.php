<x-calc.page
    title="qSOFA Score Calculator - SolveKit"
    description="Free qSOFA calculator: quick SOFA from respiratory rate, mental status and systolic blood pressure for patients with suspected infection."
    lede="Score qSOFA."
    about="qSOFA (Seymour et al. 2016, Sepsis-3) gives a point each for respiratory rate 22 or more, altered mentation and systolic BP 100 or less. Two or more in someone with suspected infection means a higher risk of death or long ICU stay. It is not a sepsis diagnosis; the 2021 Surviving Sepsis guideline advises against using it alone for screening. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['rr', 'mental', 'sbp'], 'data' => ['score' => config('health_data.scores.qsofa')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a fast respiratory rate and low blood pressure score?', 'answer' => '2 of 3: Positive (2–3).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="rr" label="Respiratory rate 22 or more" :checked="false" />
        <x-calc.checkbox name="mental" label="Altered mentation (GCS under 15)" :checked="false" />
    </div>

    <x-calc.checkbox name="sbp" label="Systolic BP 100 mmHg or less" :checked="false" />

    <x-calc.result label="qSOFA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rr' => false, 'mental' => false, 'sbp' => false],
        'Highest' => ['rr' => true, 'mental' => true, 'sbp' => true],
        'Two signs' => ['rr' => true, 'mental' => false, 'sbp' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>qSOFA: sum of item points (maximum 3)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
