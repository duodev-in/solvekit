<x-calc.page
    title="MEWS Score Calculator - SolveKit"
    description="Free MEWS calculator: Modified Early Warning Score from systolic BP, heart rate, respiratory rate, temperature and AVPU, with the escalation bands."
    lede="Score the Modified Early Warning Score."
    about="MEWS (Subbe et al. 2001) scores five observations 0–3. A total of 5 or more was linked with a higher risk of death and ICU admission. Many hospitals now use NEWS2 instead. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['sbp', 'hr', 'rr', 'temp', 'avpu'], 'data' => ['score' => config('health_data.scores.mews')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does heart rate 115 and respiratory rate 22 score with other observations normal?', 'answer' => '4 of 14: Raised (3–4).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sbp" label="Systolic BP (mmHg)" :options="['o0' => '70 or less (3 points)', 'o1' => '71–80 (2 points)', 'o2' => '81–100 (1 point)', 'o3' => '101–199 (0 points)', 'o4' => '200 or more (2 points)']" selected="o3" />
        <x-calc.select name="hr" label="Heart rate (bpm)" :options="['o0' => 'Under 40 (2 points)', 'o1' => '41–50 (1 point)', 'o2' => '51–100 (0 points)', 'o3' => '101–110 (1 point)', 'o4' => '111–129 (2 points)', 'o5' => '130 or more (3 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="rr" label="Respiratory rate (breaths a minute)" :options="['o0' => 'Under 9 (2 points)', 'o1' => '9–14 (0 points)', 'o2' => '15–20 (1 point)', 'o3' => '21–29 (2 points)', 'o4' => '30 or more (3 points)']" selected="o1" />
        <x-calc.select name="temp" label="Temperature (°C)" :options="['o0' => 'Under 35 (2 points)', 'o1' => '35.0–38.4 (0 points)', 'o2' => '38.5 or more (2 points)']" selected="o1" />
    </div>

    <x-calc.select name="avpu" label="Consciousness (AVPU)" :options="['o0' => 'Alert (0 points)', 'o1' => 'Reacts to voice (1 point)', 'o2' => 'Reacts to pain (2 points)', 'o3' => 'Unresponsive (3 points)']" selected="o0" />

    <x-calc.result label="Modified Early Warning Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sbp' => 'o3', 'hr' => 'o2', 'rr' => 'o1', 'temp' => 'o1', 'avpu' => 'o0'],
        'Highest' => ['sbp' => 'o0', 'hr' => 'o5', 'rr' => 'o4', 'temp' => 'o0', 'avpu' => 'o3'],
        'Tachycardic' => ['sbp' => 'o3', 'hr' => 'o4', 'rr' => 'o3', 'temp' => 'o1', 'avpu' => 'o0'],
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
            <li>Modified Early Warning Score: sum of item points (maximum 14)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
