<x-calc.page
    title="CHA2DS2-Vasc Calculator - SolveKit"
    description="Free CHA₂DS₂-VASc calculator: stroke risk in atrial fibrillation from heart failure, hypertension, age, diabetes, previous stroke, vascular disease and sex, with the annual stroke rate."
    lede="Score stroke risk in atrial fibrillation."
    about="CHA₂DS₂-VASc (Lip et al. 2010) estimates stroke risk in non-valvular atrial fibrillation. Each letter adds a point (2 for age 75+ and previous stroke). The annual ischaemic stroke rates without anticoagulation come from the Swedish AF cohort (Friberg et al. 2012). The 2024 ESC guideline now uses CHA₂DS₂-VA without the sex point. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['chf', 'htn', 'age', 'dm', 'stroke', 'vascular', 'sex'], 'data' => ['score' => config('health_data.scores.cha2ds2vasc')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What is the score for a 70-year-old woman with hypertension?', 'answer' => '3 of 9: About 3.2% a year risk of ischaemic stroke, TIA or embolism without anticoagulation. ESC 2020: anticoagulation should be considered at 1 in men (2 in women) and is recommended from 2 in men (3 in women).'],
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

    <x-calc.select name="sex" label="Sex" :options="['o0' => 'Male (0 points)', 'o1' => 'Female (1 point)']" selected="o0" />

    <x-calc.result label="CHA₂DS₂-VASc score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['chf' => false, 'htn' => false, 'age' => 'o0', 'dm' => false, 'stroke' => false, 'vascular' => false, 'sex' => 'o0'],
        'Highest' => ['chf' => true, 'htn' => true, 'age' => 'o2', 'dm' => true, 'stroke' => true, 'vascular' => true, 'sex' => 'o1'],
        'Woman 70 with hypertension' => ['chf' => false, 'htn' => true, 'age' => 'o1', 'dm' => false, 'stroke' => false, 'vascular' => false, 'sex' => 'o1'],
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
            <li>CHA₂DS₂-VASc score: sum of item points (maximum 9)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
