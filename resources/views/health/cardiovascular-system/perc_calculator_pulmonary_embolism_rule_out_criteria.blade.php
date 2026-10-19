<x-calc.page
    title="PERC Calculator - Pulmonary Embolism Rule-Out Criteria - SolveKit"
    description="Free PERC calculator: the eight Pulmonary Embolism Rule-out Criteria; with low clinical suspicion and no criteria present, PE is ruled out without a D-dimer."
    lede="Apply the PERC rule."
    about="The PERC rule (Kline et al. 2004) is used only when a clinician already judges the probability of PE to be low (under 15%). If none of the eight criteria are present, the chance of PE is below the testing threshold and no D-dimer is needed. Any criterion makes the rule positive. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['age', 'hr', 'spo2', 'leg', 'haemoptysis', 'surgery', 'vte', 'hormones'], 'data' => ['score' => config('health_data.scores.perc')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'Is a 45-year-old with heart rate 90 and SpO₂ 98% PERC negative?', 'answer' => 'Yes: 0 of 8 criteria, PERC negative (0 criteria).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="age" label="Age 50 or older" :checked="false" />
        <x-calc.checkbox name="hr" label="Heart rate 100 or more" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="spo2" label="Oxygen saturation under 95% on room air" :checked="false" />
        <x-calc.checkbox name="leg" label="Unilateral leg swelling" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="haemoptysis" label="Coughing up blood (haemoptysis)" :checked="false" />
        <x-calc.checkbox name="surgery" label="Surgery or trauma needing anaesthesia in the last 4 weeks" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="vte" label="Previous PE or DVT" :checked="false" />
        <x-calc.checkbox name="hormones" label="Hormone use (oral contraceptives, HRT or oestrogen)" :checked="false" />
    </div>

    <x-calc.result label="PERC rule" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => false, 'hr' => false, 'spo2' => false, 'leg' => false, 'haemoptysis' => false, 'surgery' => false, 'vte' => false, 'hormones' => false],
        'Highest' => ['age' => true, 'hr' => true, 'spo2' => true, 'leg' => true, 'haemoptysis' => true, 'surgery' => true, 'vte' => true, 'hormones' => true],
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
            <li>PERC rule: sum of item points (maximum 8)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
