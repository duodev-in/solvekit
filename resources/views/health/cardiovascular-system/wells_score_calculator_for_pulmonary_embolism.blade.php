<x-calc.page
    title="Wells Score Calculator for Pulmonary Embolism - SolveKit"
    description="Free Wells score for PE calculator: probability of pulmonary embolism from seven clinical criteria, with the three-tier and two-tier (PE likely or unlikely) interpretations."
    lede="Score the probability of pulmonary embolism."
    about="The Wells criteria for PE (Wells et al. 2000, 2001) give 3 points for signs of DVT and for PE being the most likely diagnosis, 1.5 for heart rate over 100, immobilisation or surgery and previous VTE, and 1 for haemoptysis and cancer. Three-tier: under 2 low, 2–6 moderate, over 6 high. Two-tier: 4 or less “PE unlikely” (a normal D-dimer then rules out PE). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['dvt', 'likely', 'hr', 'immobile', 'previous', 'haemoptysis', 'cancer'], 'data' => ['score' => config('health_data.scores.wells_pe')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does PE as the most likely diagnosis with heart rate over 100 score?', 'answer' => '4.5 of 12.5: Moderate (2–6), two-tier “PE likely”.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="dvt" label="Clinical signs and symptoms of DVT" :checked="false" />
        <x-calc.checkbox name="likely" label="PE is the most likely diagnosis" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="hr" label="Heart rate over 100" :checked="false" />
        <x-calc.checkbox name="immobile" label="Immobilisation for 3 or more days, or surgery in the last 4 weeks" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="previous" label="Previous PE or DVT" :checked="false" />
        <x-calc.checkbox name="haemoptysis" label="Haemoptysis" :checked="false" />
    </div>

    <x-calc.checkbox name="cancer" label="Cancer (treated in the last 6 months or palliative)" :checked="false" />

    <x-calc.result label="Wells score for PE" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dvt' => false, 'likely' => false, 'hr' => false, 'immobile' => false, 'previous' => false, 'haemoptysis' => false, 'cancer' => false],
        'Highest' => ['dvt' => true, 'likely' => true, 'hr' => true, 'immobile' => true, 'previous' => true, 'haemoptysis' => true, 'cancer' => true],
        'Likely, tachycardic' => ['dvt' => false, 'likely' => true, 'hr' => true, 'immobile' => false, 'previous' => false, 'haemoptysis' => false, 'cancer' => false],
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
            <li>Wells score for PE: sum of item points (maximum 12.5)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
