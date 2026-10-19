<x-calc.page
    title="ICH Score Calculator - SolveKit"
    description="Free ICH score calculator: 30-day mortality in intracerebral haemorrhage from GCS, haematoma volume, intraventricular blood, location and age."
    lede="Score intracerebral haemorrhage severity."
    about="The ICH score (Hemphill et al. 2001) ranges from 0 to 6. In the original cohort, 30-day mortality was 0%, 13%, 26%, 72% and 97% for scores 0 to 4, and 100% at 5. Use the ICH Volume (ABC/2) calculator for the volume. The score should support, not replace, clinical judgement on care. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['gcs', 'volume', 'ivh', 'infratentorial', 'age'], 'data' => ['score' => config('health_data.scores.ich')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does GCS 10 with a 35 mL bleed score?', 'answer' => '2 of 6: Score 2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gcs" label="Glasgow Coma Scale" :options="['o0' => '13–15 (0 points)', 'o1' => '5–12 (1 point)', 'o2' => '3–4 (2 points)']" selected="o0" />
        <x-calc.select name="volume" label="Haematoma volume" :options="['o0' => 'Under 30 mL (0 points)', 'o1' => '30 mL or more (1 point)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="ivh" label="Intraventricular haemorrhage" :checked="false" />
        <x-calc.checkbox name="infratentorial" label="Infratentorial origin" :checked="false" />
    </div>

    <x-calc.select name="age" label="Age" :options="['o0' => 'Under 80 (0 points)', 'o1' => '80 or older (1 point)']" selected="o0" />

    <x-calc.result label="ICH score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['gcs' => 'o0', 'volume' => 'o0', 'ivh' => false, 'infratentorial' => false, 'age' => 'o0'],
        'Highest' => ['gcs' => 'o2', 'volume' => 'o1', 'ivh' => true, 'infratentorial' => true, 'age' => 'o1'],
        'GCS 10, 35 mL' => ['gcs' => 'o1', 'volume' => 'o1', 'ivh' => false, 'infratentorial' => false, 'age' => 'o0'],
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
            <li>ICH score: sum of item points (maximum 6)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
