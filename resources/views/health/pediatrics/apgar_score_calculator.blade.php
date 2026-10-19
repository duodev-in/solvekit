<x-calc.page
    title="APGAR Score Calculator - SolveKit"
    description="Free Apgar score calculator: Appearance, Pulse, Grimace, Activity and Respiration at 1 and 5 minutes after birth, scored 0–10."
    lede="Score a newborn's Apgar."
    about="Virginia Apgar's score (1953) is taken at 1 and 5 minutes after birth (and every 5 minutes to 20 if under 7). Each of five signs scores 0–2. AAP and ACOG: 7–10 is reassuring, 4–6 moderately abnormal and 0–3 low. It describes the baby's condition; it does not predict long-term outcome on its own. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['appearance', 'pulse', 'grimace', 'activity', 'respiration'], 'data' => ['score' => config('health_data.scores.apgar')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a baby with blue hands and feet and otherwise perfect signs score?', 'answer' => '9 of 10: Reassuring (7–10).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="appearance" label="Appearance (skin colour)" :options="['o0' => 'Pink all over (2 points)', 'o1' => 'Pink body, blue hands and feet (1 point)', 'o2' => 'Blue or pale all over (0 points)']" selected="o0" />
        <x-calc.select name="pulse" label="Pulse (heart rate)" :options="['o0' => '100 or more (2 points)', 'o1' => 'Under 100 (1 point)', 'o2' => 'Absent (0 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="grimace" label="Grimace (reflex irritability)" :options="['o0' => 'Cries, coughs or sneezes (2 points)', 'o1' => 'Grimaces (1 point)', 'o2' => 'No response (0 points)']" selected="o0" />
        <x-calc.select name="activity" label="Activity (muscle tone)" :options="['o0' => 'Active movement (2 points)', 'o1' => 'Some flexion (1 point)', 'o2' => 'Limp (0 points)']" selected="o0" />
    </div>

    <x-calc.select name="respiration" label="Respiration" :options="['o0' => 'Strong cry (2 points)', 'o1' => 'Weak, irregular or gasping (1 point)', 'o2' => 'Absent (0 points)']" selected="o0" />

    <x-calc.result label="Apgar score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['appearance' => 'o0', 'pulse' => 'o0', 'grimace' => 'o0', 'activity' => 'o0', 'respiration' => 'o0'],
        'Highest' => ['appearance' => 'o0', 'pulse' => 'o0', 'grimace' => 'o0', 'activity' => 'o0', 'respiration' => 'o0'],
        'Blue hands' => ['appearance' => 'o1', 'pulse' => 'o0', 'grimace' => 'o0', 'activity' => 'o0', 'respiration' => 'o0'],
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
            <li>Apgar score: sum of item points (maximum 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
