<x-calc.page
    title="Gout Diagnosis Calculator - SolveKit"
    description="Free gout diagnosis calculator: the primary-care diagnostic rule for gout (Janssens 2010) from sex, history, symptoms, big-toe involvement, cardiovascular disease and uric acid."
    lede="Estimate the probability of gout."
    about="For a patient with a painful joint, the Janssens rule adds points for male sex (2), a previous attack (2), onset within a day (0.5), redness (1), big-toe involvement (2.5), hypertension or cardiovascular disease (1.5) and serum uric acid above 5.88 mg/dL (3.5). A score of 8 or more meant about 80% had gout; 4 or less about 2%. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['male', 'previous', 'onset', 'redness', 'mtp', 'cvd', 'urate'], 'data' => ['score' => config('health_data.scores.gout')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What is the score for a man with a red big toe and high uric acid?', 'answer' => '9 of 13 points: High probability (≥ 8).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="male" label="Male sex" :checked="false" />
        <x-calc.checkbox name="previous" label="Previous patient-reported arthritis attack" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="onset" label="Onset within one day" :checked="false" />
        <x-calc.checkbox name="redness" label="Joint redness" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="mtp" label="Big-toe joint (first MTP) involved" :checked="false" />
        <x-calc.checkbox name="cvd" label="Hypertension or at least one cardiovascular disease" :checked="false" />
    </div>

    <x-calc.checkbox name="urate" label="Serum uric acid above 5.88 mg/dL (0.35 mmol/L)" :checked="false" />

    <x-calc.result label="Gout diagnostic rule" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['male' => false, 'previous' => false, 'onset' => false, 'redness' => false, 'mtp' => false, 'cvd' => false, 'urate' => false],
        'Highest' => ['male' => true, 'previous' => true, 'onset' => true, 'redness' => true, 'mtp' => true, 'cvd' => true, 'urate' => true],
        'Typical gout' => ['male' => true, 'previous' => false, 'onset' => false, 'redness' => true, 'mtp' => true, 'cvd' => false, 'urate' => true],
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
            <li>Gout diagnostic rule: sum of item points (maximum 13)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
