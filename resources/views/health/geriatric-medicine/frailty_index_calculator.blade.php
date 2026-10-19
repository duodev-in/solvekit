<x-calc.page
    title="Frailty Index Calculator - SolveKit"
    description="Free frailty calculator: the FRAIL scale (Fatigue, Resistance, Ambulation, Illnesses, Loss of weight) for robust, pre-frail or frail."
    lede="Screen for frailty with the FRAIL scale."
    about="The FRAIL scale (Morley et al. 2012) is a five-question frailty screen recommended by the International Conference of Frailty and Sarcopenia Research. 0 is robust, 1–2 pre-frail and 3–5 frail. Exercise, enough protein and a medicine review can reverse early frailty. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['fatigue', 'resistance', 'ambulation', 'illness', 'loss'], 'data' => ['score' => config('health_data.scores.frail')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does fatigue and difficulty with stairs score?', 'answer' => '2 of 5: Pre-frail (1–2).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="fatigue" label="Fatigue: tired most or all of the time in the past 4 weeks" :checked="false" />
        <x-calc.checkbox name="resistance" label="Resistance: difficulty walking up 10 steps without resting or aids" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="ambulation" label="Ambulation: difficulty walking 300 m (a block or two) without aids" :checked="false" />
        <x-calc.checkbox name="illness" label="Illnesses: 5 or more of 11 conditions (hypertension, diabetes, cancer, lung disease, heart attack, heart failure, angina, asthma, arthritis, stroke, kidney disease)" :checked="false" />
    </div>

    <x-calc.checkbox name="loss" label="Loss of weight: more than 5% in the past year" :checked="false" />

    <x-calc.result label="FRAIL scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fatigue' => false, 'resistance' => false, 'ambulation' => false, 'illness' => false, 'loss' => false],
        'Highest' => ['fatigue' => true, 'resistance' => true, 'ambulation' => true, 'illness' => true, 'loss' => true],
        'Two items' => ['fatigue' => true, 'resistance' => true, 'ambulation' => false, 'illness' => false, 'loss' => false],
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
            <li>FRAIL scale: sum of item points (maximum 5)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
