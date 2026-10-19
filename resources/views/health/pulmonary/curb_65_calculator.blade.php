<x-calc.page
    title="CURB-65 Calculator - SolveKit"
    description="Free CURB-65 calculator: severity of community-acquired pneumonia from Confusion, Urea, Respiratory rate, Blood pressure and age 65+, with 30-day mortality."
    lede="Score pneumonia severity with CURB-65."
    about="CURB-65 (Lim et al. 2003), recommended by the British Thoracic Society, gives a point for each of five items. 30-day mortality ranges from 0.7% at 0 to 57% at 5; 0–1 can often be treated at home, 2 needs hospital assessment and 3 or more is severe. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['confusion', 'urea', 'rr', 'bp', 'age'], 'data' => ['score' => config('health_data.scores.curb65')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a 70-year-old with a respiratory rate of 32 score?', 'answer' => '2 of 5: Score 2 (moderate severity).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="confusion" label="New confusion" :checked="false" />
        <x-calc.checkbox name="urea" label="Urea over 7 mmol/L (BUN over 19 mg/dL)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="rr" label="Respiratory rate 30 or more" :checked="false" />
        <x-calc.checkbox name="bp" label="Systolic BP under 90 or diastolic 60 or less" :checked="false" />
    </div>

    <x-calc.checkbox name="age" label="Age 65 or older" :checked="false" />

    <x-calc.result label="CURB-65" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['confusion' => false, 'urea' => false, 'rr' => false, 'bp' => false, 'age' => false],
        'Highest' => ['confusion' => true, 'urea' => true, 'rr' => true, 'bp' => true, 'age' => true],
        'Older, fast breathing' => ['confusion' => false, 'urea' => false, 'rr' => true, 'bp' => false, 'age' => true],
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
            <li>CURB-65: sum of item points (maximum 5)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
