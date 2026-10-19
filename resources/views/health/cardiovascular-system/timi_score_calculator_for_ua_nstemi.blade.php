<x-calc.page
    title="TIMI Score Calculator for UA/NSTEMI - SolveKit"
    description="Free TIMI risk score for unstable angina and NSTEMI: seven yes/no items for the 14-day risk of death, heart attack or urgent revascularisation."
    lede="Score UA/NSTEMI risk with TIMI."
    about="The TIMI risk score for UA/NSTEMI (Antman et al., JAMA 2000) adds one point for each of seven items. The 14-day risk of death, new or recurrent MI or urgent revascularisation rose from 4.7% at 0–1 to 40.9% at 6–7. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['age', 'risk', 'cad', 'aspirin', 'angina', 'st', 'marker'], 'data' => ['score' => config('health_data.scores.timi_ua')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does age 65+, aspirin use and ST deviation score?', 'answer' => '3 of 7: About 13.2% risk of death, MI or urgent revascularisation by 14 days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="age" label="Age 65 or older" :checked="false" />
        <x-calc.checkbox name="risk" label="3 or more coronary risk factors (family history, hypertension, high cholesterol, diabetes, smoking)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="cad" label="Known coronary artery disease (stenosis 50% or more)" :checked="false" />
        <x-calc.checkbox name="aspirin" label="Aspirin use in the last 7 days" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="angina" label="Severe angina (2 or more episodes in 24 hours)" :checked="false" />
        <x-calc.checkbox name="st" label="ST deviation of 0.5 mm or more" :checked="false" />
    </div>

    <x-calc.checkbox name="marker" label="Positive cardiac marker" :checked="false" />

    <x-calc.result label="TIMI risk score for UA/NSTEMI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => false, 'risk' => false, 'cad' => false, 'aspirin' => false, 'angina' => false, 'st' => false, 'marker' => false],
        'Highest' => ['age' => true, 'risk' => true, 'cad' => true, 'aspirin' => true, 'angina' => true, 'st' => true, 'marker' => true],
        'Three items' => ['age' => true, 'risk' => false, 'cad' => false, 'aspirin' => true, 'angina' => false, 'st' => true, 'marker' => false],
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
            <li>TIMI risk score for UA/NSTEMI: sum of item points (maximum 7)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
