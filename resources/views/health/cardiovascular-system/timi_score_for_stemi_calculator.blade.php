<x-calc.page
    title="TIMI Score for STEMI Calculator - SolveKit"
    description="Free TIMI risk score for STEMI calculator: 30-day mortality after ST-elevation myocardial infarction from age, history, blood pressure, heart rate, Killip class, weight, location and time to treatment."
    lede="Score STEMI risk with TIMI."
    about="The TIMI risk score for STEMI (Morrow et al. 2000) was derived from patients treated with fibrinolysis in the InTIME II trial. Scores range from 0 to 14; 30-day mortality rose from 0.8% at 0 to 35.9% at over 8. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['age', 'history', 'sbp', 'hr', 'killip', 'weight', 'anterior', 'time'], 'data' => ['score' => config('health_data.scores.timi_stemi')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does age 70 with anterior ST elevation score?', 'answer' => '3 of 14: About 4.4% 30-day mortality in the derivation cohort.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="age" label="Age" :options="['o0' => 'Under 65 (0 points)', 'o1' => '65–74 (2 points)', 'o2' => '75 or older (3 points)']" selected="o0" />
        <x-calc.checkbox name="history" label="Diabetes, hypertension or angina" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="sbp" label="Systolic BP under 100 mmHg" :checked="false" />
        <x-calc.checkbox name="hr" label="Heart rate over 100" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="killip" label="Killip class II–IV" :checked="false" />
        <x-calc.checkbox name="weight" label="Weight under 67 kg (148 lb)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="anterior" label="Anterior ST elevation or left bundle branch block" :checked="false" />
        <x-calc.checkbox name="time" label="Time to treatment over 4 hours" :checked="false" />
    </div>

    <x-calc.result label="TIMI risk score for STEMI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 'o0', 'history' => false, 'sbp' => false, 'hr' => false, 'killip' => false, 'weight' => false, 'anterior' => false, 'time' => false],
        'Highest' => ['age' => 'o2', 'history' => true, 'sbp' => true, 'hr' => true, 'killip' => true, 'weight' => true, 'anterior' => true, 'time' => true],
        'Age 70, anterior' => ['age' => 'o1', 'history' => false, 'sbp' => false, 'hr' => false, 'killip' => false, 'weight' => false, 'anterior' => true, 'time' => false],
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
            <li>TIMI risk score for STEMI: sum of item points (maximum 14)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
