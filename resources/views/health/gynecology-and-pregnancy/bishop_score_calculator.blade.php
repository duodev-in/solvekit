<x-calc.page
    title="Bishop Score Calculator - SolveKit"
    description="Free Bishop score calculator: cervical readiness for induction of labour from dilation, effacement, station, consistency and position."
    lede="Score the cervix with the Bishop score."
    about="The Bishop score (1964) rates five features of the cervix on vaginal examination, 0–13. ACOG: a score over 8 means induction is about as likely to end in vaginal birth as spontaneous labour; 6 or less is unfavourable and cervical ripening is often used first. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['dilation', 'effacement', 'station', 'consistency', 'position'], 'data' => ['score' => config('health_data.scores.bishop')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does 2 cm, 50% effaced, station −1, soft and mid-position score?', 'answer' => '7 of 13: Intermediate (7–8).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dilation" label="Cervical dilation" :options="['o0' => 'Closed (0 points)', 'o1' => '1–2 cm (1 point)', 'o2' => '3–4 cm (2 points)', 'o3' => '5 cm or more (3 points)']" selected="o0" />
        <x-calc.select name="effacement" label="Effacement" :options="['o0' => '0–30% (0 points)', 'o1' => '40–50% (1 point)', 'o2' => '60–70% (2 points)', 'o3' => '80% or more (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="station" label="Fetal station" :options="['o0' => '−3 (0 points)', 'o1' => '−2 (1 point)', 'o2' => '−1 or 0 (2 points)', 'o3' => '+1 or +2 (3 points)']" selected="o0" />
        <x-calc.select name="consistency" label="Cervical consistency" :options="['o0' => 'Firm (0 points)', 'o1' => 'Medium (1 point)', 'o2' => 'Soft (2 points)']" selected="o0" />
    </div>

    <x-calc.select name="position" label="Cervical position" :options="['o0' => 'Posterior (0 points)', 'o1' => 'Mid (1 point)', 'o2' => 'Anterior (2 points)']" selected="o0" />

    <x-calc.result label="Bishop score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dilation' => 'o0', 'effacement' => 'o0', 'station' => 'o0', 'consistency' => 'o0', 'position' => 'o0'],
        'Highest' => ['dilation' => 'o3', 'effacement' => 'o3', 'station' => 'o3', 'consistency' => 'o2', 'position' => 'o2'],
        'Typical' => ['dilation' => 'o1', 'effacement' => 'o1', 'station' => 'o2', 'consistency' => 'o2', 'position' => 'o1'],
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
            <li>Bishop score: sum of item points (maximum 13)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
