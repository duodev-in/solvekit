<x-calc.page
    title="GCS Calculator (Glasgow Coma Scale) - SolveKit"
    description="Free GCS calculator: Glasgow Coma Scale from eye, verbal and motor responses (3–15), with mild, moderate and severe bands."
    lede="Score the Glasgow Coma Scale."
    about="The Glasgow Coma Scale (Teasdale & Jennett 1974) rates the best eye (1–4), verbal (1–5) and motor (1–6) responses. 13–15 is mild, 9–12 moderate and 3–8 severe impairment; report the parts too, as in E3 V4 M6. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['eye', 'verbal', 'motor'], 'data' => ['score' => config('health_data.scores.gcs')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What is the GCS for eyes opening to sound, confused speech and obeying commands?', 'answer' => '13 of 15: Mild (13–15).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="eye" label="Eye opening" :options="['o0' => 'Spontaneous (4 points)', 'o1' => 'To sound (3 points)', 'o2' => 'To pressure (2 points)', 'o3' => 'None (1 point)']" selected="o0" />
        <x-calc.select name="verbal" label="Verbal response" :options="['o0' => 'Oriented (5 points)', 'o1' => 'Confused (4 points)', 'o2' => 'Words (3 points)', 'o3' => 'Sounds (2 points)', 'o4' => 'None (1 point)']" selected="o0" />
    </div>

    <x-calc.select name="motor" label="Motor response" :options="['o0' => 'Obeys commands (6 points)', 'o1' => 'Localising (5 points)', 'o2' => 'Normal flexion (withdraws) (4 points)', 'o3' => 'Abnormal flexion (3 points)', 'o4' => 'Extension (2 points)', 'o5' => 'None (1 point)']" selected="o0" />

    <x-calc.result label="Glasgow Coma Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eye' => 'o0', 'verbal' => 'o0', 'motor' => 'o0'],
        'Highest' => ['eye' => 'o0', 'verbal' => 'o0', 'motor' => 'o0'],
        'E3 V4 M6' => ['eye' => 'o1', 'verbal' => 'o1', 'motor' => 'o0'],
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
            <li>Glasgow Coma Scale: sum of item points (maximum 15)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
