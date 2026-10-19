<x-calc.page
    title="CHA2DS2-VA Calculator - SolveKit"
    description="Free CHA₂DS₂-VA calculator: the 2024 ESC stroke-risk score for atrial fibrillation (CHA₂DS₂-VASc without sex), with the anticoagulation recommendation band."
    lede="Score stroke risk with CHA₂DS₂-VA."
    about="The 2024 ESC atrial fibrillation guideline (Van Gelder et al.) replaced CHA₂DS₂-VASc with CHA₂DS₂-VA, dropping female sex as a risk factor. Oral anticoagulation is recommended at 2 or more and should be considered at 1, alongside bleeding risk and the person's preferences. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['chf', 'htn', 'age', 'dm', 'stroke', 'vascular'], 'data' => ['score' => config('health_data.scores.cha2ds2va')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a 70-year-old with hypertension score?', 'answer' => '2 of 8: High risk (2 or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="chf" label="Congestive heart failure (or LV dysfunction)" :checked="false" />
        <x-calc.checkbox name="htn" label="Hypertension" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="age" label="Age" :options="['o0' => 'Under 65 (0 points)', 'o1' => '65–74 (1 point)', 'o2' => '75 or older (2 points)']" selected="o0" />
        <x-calc.checkbox name="dm" label="Diabetes" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="stroke" label="Previous stroke, TIA or thromboembolism" :checked="false" />
        <x-calc.checkbox name="vascular" label="Vascular disease (previous MI, peripheral artery disease or aortic plaque)" :checked="false" />
    </div>

    <x-calc.result label="CHA₂DS₂-VA score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['chf' => false, 'htn' => false, 'age' => 'o0', 'dm' => false, 'stroke' => false, 'vascular' => false],
        'Highest' => ['chf' => true, 'htn' => true, 'age' => 'o2', 'dm' => true, 'stroke' => true, 'vascular' => true],
        'Age 70 with hypertension' => ['chf' => false, 'htn' => true, 'age' => 'o1', 'dm' => false, 'stroke' => false, 'vascular' => false],
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
            <li>CHA₂DS₂-VA score: sum of item points (maximum 8)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
