<x-calc.page
    title="HEART Score Calculator - SolveKit"
    description="Free HEART score calculator: risk of a major cardiac event in 6 weeks for chest pain in the emergency department, from History, ECG, Age, Risk factors and Troponin."
    lede="Score chest pain with HEART."
    about="The HEART score (Six et al. 2008) rates five items 0–2. In the validation by Backus et al. (2013), scores of 0–3 had about 1.7% risk of a major adverse cardiac event in 6 weeks, 4–6 about 16.6% and 7–10 about 50%. It is for clinicians assessing chest pain, not for self-assessment of symptoms: call emergency services for chest pain. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['history', 'ecg', 'age', 'risk', 'troponin'], 'data' => ['score' => config('health_data.scores.heart')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does the default (moderate age and risk factors) score?', 'answer' => '2 of 10: Low (0–3).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="history" label="History" :options="['o0' => 'Slightly suspicious (0 points)', 'o1' => 'Moderately suspicious (1 point)', 'o2' => 'Highly suspicious (2 points)']" selected="o0" />
        <x-calc.select name="ecg" label="ECG" :options="['o0' => 'Normal (0 points)', 'o1' => 'Non-specific repolarisation changes (1 point)', 'o2' => 'Significant ST deviation (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="age" label="Age" :options="['o0' => 'Under 45 (0 points)', 'o1' => '45–64 (1 point)', 'o2' => '65 or older (2 points)']" selected="o1" />
        <x-calc.select name="risk" label="Risk factors (hypertension, high cholesterol, diabetes, obesity, smoking, family history)" :options="['o0' => 'None known (0 points)', 'o1' => '1 or 2 (1 point)', 'o2' => '3 or more, or known atherosclerotic disease (2 points)']" selected="o1" />
    </div>

    <x-calc.select name="troponin" label="Initial troponin" :options="['o0' => 'At or below the normal limit (0 points)', 'o1' => '1–3 × the normal limit (1 point)', 'o2' => 'Over 3 × the normal limit (2 points)']" selected="o0" />

    <x-calc.result label="HEART score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['history' => 'o0', 'ecg' => 'o0', 'age' => 'o1', 'risk' => 'o1', 'troponin' => 'o0'],
        'Highest' => ['history' => 'o2', 'ecg' => 'o2', 'age' => 'o2', 'risk' => 'o2', 'troponin' => 'o2'],
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
            <li>HEART score: sum of item points (maximum 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
