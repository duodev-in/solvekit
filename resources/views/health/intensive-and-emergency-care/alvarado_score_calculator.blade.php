<x-calc.page
    title="Alvarado Score Calculator - SolveKit"
    description="Free Alvarado score calculator: likelihood of appendicitis from eight symptoms, signs and blood tests (MANTRELS)."
    lede="Score the likelihood of appendicitis."
    about="The Alvarado score (1986) uses Migration of pain, Anorexia, Nausea, Tenderness in the right lower quadrant (2), Rebound, Elevated temperature, Leucocytosis (2) and Shift to the left. 0–4 makes appendicitis unlikely, 5–6 possible, 7–8 probable and 9–10 very probable. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['migration', 'anorexia', 'nausea', 'tender', 'rebound', 'fever', 'wbc', 'shift'], 'data' => ['score' => config('health_data.scores.alvarado')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does migrating pain, nausea, RLQ tenderness and a high white count score?', 'answer' => '6 of 10: Possible appendicitis (5–6).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="migration" label="Migration of pain to the right lower quadrant" :checked="false" />
        <x-calc.checkbox name="anorexia" label="Loss of appetite" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="nausea" label="Nausea or vomiting" :checked="false" />
        <x-calc.checkbox name="tender" label="Tenderness in the right lower quadrant" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="rebound" label="Rebound tenderness" :checked="false" />
        <x-calc.checkbox name="fever" label="Temperature 37.3 °C (99.1 °F) or more" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="wbc" label="White cell count over 10,000/µL" :checked="false" />
        <x-calc.checkbox name="shift" label="Neutrophils over 75% (left shift)" :checked="false" />
    </div>

    <x-calc.result label="Alvarado score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['migration' => false, 'anorexia' => false, 'nausea' => false, 'tender' => false, 'rebound' => false, 'fever' => false, 'wbc' => false, 'shift' => false],
        'Highest' => ['migration' => true, 'anorexia' => true, 'nausea' => true, 'tender' => true, 'rebound' => true, 'fever' => true, 'wbc' => true, 'shift' => true],
        'Classic' => ['migration' => true, 'anorexia' => false, 'nausea' => true, 'tender' => true, 'rebound' => false, 'fever' => false, 'wbc' => true, 'shift' => false],
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
            <li>Alvarado score: sum of item points (maximum 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
