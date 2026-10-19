<x-calc.page
    title="Revised Geneva Score Calculator for Pulmonary Embolism - SolveKit"
    description="Free revised Geneva score calculator: clinical probability of pulmonary embolism from eight objective items, including heart rate."
    lede="Score PE probability with Geneva."
    about="The revised Geneva score (Le Gal et al. 2006) uses only objective items, so it does not depend on the clinician's judgement. 0–3 points is low probability (about 8% had PE), 4–10 intermediate (28%) and 11 or more high (74%). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['age', 'previous', 'surgery', 'cancer', 'pain', 'haemoptysis', 'hr', 'palpation'], 'data' => ['score' => config('health_data.scores.geneva')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does heart rate 95+ with unilateral leg pain score?', 'answer' => '8 of 22: Intermediate probability (4–10).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="age" label="Age over 65" :checked="false" />
        <x-calc.checkbox name="previous" label="Previous DVT or PE" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="surgery" label="Surgery under general anaesthesia or lower-limb fracture in the last month" :checked="false" />
        <x-calc.checkbox name="cancer" label="Active cancer (or cured less than a year ago)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="pain" label="Unilateral leg pain" :checked="false" />
        <x-calc.checkbox name="haemoptysis" label="Haemoptysis" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="hr" label="Heart rate" :options="['o0' => 'Under 75 (0 points)', 'o1' => '75–94 (3 points)', 'o2' => '95 or more (5 points)']" selected="o0" />
        <x-calc.checkbox name="palpation" label="Pain on deep-vein palpation of the leg and unilateral oedema" :checked="false" />
    </div>

    <x-calc.result label="Revised Geneva score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => false, 'previous' => false, 'surgery' => false, 'cancer' => false, 'pain' => false, 'haemoptysis' => false, 'hr' => 'o0', 'palpation' => false],
        'Highest' => ['age' => true, 'previous' => true, 'surgery' => true, 'cancer' => true, 'pain' => true, 'haemoptysis' => true, 'hr' => 'o2', 'palpation' => true],
        'Fast heart, leg pain' => ['age' => false, 'previous' => false, 'surgery' => false, 'cancer' => false, 'pain' => true, 'haemoptysis' => false, 'hr' => 'o2', 'palpation' => false],
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
            <li>Revised Geneva score: sum of item points (maximum 22)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
