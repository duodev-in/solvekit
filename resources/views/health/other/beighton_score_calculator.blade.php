<x-calc.page
    title="Beighton Score Calculator - SolveKit"
    description="Free Beighton score calculator: joint hypermobility from nine tests (little fingers, thumbs, elbows, knees and forward bend), with the 2017 age cut-offs."
    lede="Score joint hypermobility (Beighton)."
    about="The Beighton score (1973) gives a point for each of nine manoeuvres. The 2017 hypermobile Ehlers–Danlos criteria count generalised joint hypermobility at 6 or more before puberty, 5 or more for adults up to 50 and 4 or more over 50. Hypermobility alone is common and often harmless. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['pinky_l', 'pinky_r', 'thumb_l', 'thumb_r', 'elbow_l', 'elbow_r', 'knee_l', 'knee_r', 'palms'], 'data' => ['score' => config('health_data.scores.beighton')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does bending both little fingers back and touching both thumbs to the forearm score?', 'answer' => '4 of 9: 4: hypermobile if over 50.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="pinky_l" label="Left little finger bends back over 90°" :checked="false" />
        <x-calc.checkbox name="pinky_r" label="Right little finger bends back over 90°" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="thumb_l" label="Left thumb touches the forearm" :checked="false" />
        <x-calc.checkbox name="thumb_r" label="Right thumb touches the forearm" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="elbow_l" label="Left elbow bends back over 10°" :checked="false" />
        <x-calc.checkbox name="elbow_r" label="Right elbow bends back over 10°" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="knee_l" label="Left knee bends back over 10°" :checked="false" />
        <x-calc.checkbox name="knee_r" label="Right knee bends back over 10°" :checked="false" />
    </div>

    <x-calc.checkbox name="palms" label="Palms flat on the floor with knees straight" :checked="false" />

    <x-calc.result label="Beighton score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pinky_l' => false, 'pinky_r' => false, 'thumb_l' => false, 'thumb_r' => false, 'elbow_l' => false, 'elbow_r' => false, 'knee_l' => false, 'knee_r' => false, 'palms' => false],
        'Highest' => ['pinky_l' => true, 'pinky_r' => true, 'thumb_l' => true, 'thumb_r' => true, 'elbow_l' => true, 'elbow_r' => true, 'knee_l' => true, 'knee_r' => true, 'palms' => true],
        'Hands' => ['pinky_l' => true, 'pinky_r' => true, 'thumb_l' => true, 'thumb_r' => true, 'elbow_l' => false, 'elbow_r' => false, 'knee_l' => false, 'knee_r' => false, 'palms' => false],
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
            <li>Beighton score: sum of item points (maximum 9)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
