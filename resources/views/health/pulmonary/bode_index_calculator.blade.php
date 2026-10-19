<x-calc.page
    title="BODE Index Calculator - SolveKit"
    description="Free BODE index calculator: COPD prognosis from Body mass index, airflow Obstruction (FEV₁), Dyspnoea (mMRC) and Exercise capacity (6-minute walk)."
    lede="Score COPD prognosis with BODE."
    about="The BODE index (Celli et al. 2004) predicts survival in COPD better than FEV₁ alone. Scores of 0–10 fall into four quartiles, with approximate 4-year survival of 80%, 67%, 57% and 18% in the original study. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['bmi', 'fev1', 'mmrc', 'walk'], 'data' => ['score' => config('health_data.scores.bode')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does FEV₁ 40%, mMRC 3 and a 200 m walk score with BMI 20?', 'answer' => '7 of 10: Quartile 4 (7–10).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bmi" label="Body mass index" :options="['o0' => 'Over 21 (0 points)', 'o1' => '21 or less (1 point)']" selected="o0" />
        <x-calc.select name="fev1" label="FEV₁ % predicted (after bronchodilator)" :options="['o0' => '65% or more (0 points)', 'o1' => '50–64% (1 point)', 'o2' => '36–49% (2 points)', 'o3' => '35% or less (3 points)']" selected="o1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mmrc" label="Breathlessness (mMRC scale)" :options="['o0' => '0–1: breathless only with strenuous exercise or hurrying (0 points)', 'o1' => '2: walks slower than peers or stops for breath (1 point)', 'o2' => '3: stops after about 100 m or a few minutes (2 points)', 'o3' => '4: too breathless to leave the house or dress (3 points)']" selected="o1" />
        <x-calc.select name="walk" label="Six-minute walk distance" :options="['o0' => '350 m or more (0 points)', 'o1' => '250–349 m (1 point)', 'o2' => '150–249 m (2 points)', 'o3' => '149 m or less (3 points)']" selected="o1" />
    </div>

    <x-calc.result label="BODE index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bmi' => 'o0', 'fev1' => 'o1', 'mmrc' => 'o1', 'walk' => 'o1'],
        'Highest' => ['bmi' => 'o1', 'fev1' => 'o3', 'mmrc' => 'o3', 'walk' => 'o3'],
        'Severe COPD' => ['bmi' => 'o1', 'fev1' => 'o2', 'mmrc' => 'o2', 'walk' => 'o2'],
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
            <li>BODE index: sum of item points (maximum 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
