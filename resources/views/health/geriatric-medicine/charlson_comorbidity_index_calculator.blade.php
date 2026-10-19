<x-calc.page
    title="Charlson Comorbidity Index Calculator - SolveKit"
    description="Free Charlson Comorbidity Index calculator: the age-adjusted CCI from 16 conditions and age, with the estimated 10-year survival."
    lede="Calculate the Charlson Comorbidity Index."
    about="The Charlson Comorbidity Index (Charlson et al. 1987) weights conditions by their effect on mortality (1 to 6 points) and adds a point per decade from age 50. The original 10-year survival estimate is 0.983^exp(0.9 × CCI). It is widely used in research to adjust for comorbidity; modern survival is generally better than the 1980s cohort. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['mi', 'chf', 'pvd', 'cvd', 'dementia', 'copd', 'ctd', 'ulcer', 'liver', 'diabetes', 'hemiplegia', 'ckd', 'tumour', 'leukaemia', 'lymphoma', 'aids', 'age'], 'data' => ['score' => config('health_data.scores.charlson')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a 72-year-old with heart failure and uncomplicated diabetes score?', 'answer' => '5 of 37: Estimated 10-year survival about 21% by the Charlson equation (an old cohort; modern survival is usually better).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="mi" label="Heart attack (myocardial infarction)" :checked="false" />
        <x-calc.checkbox name="chf" label="Congestive heart failure" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="pvd" label="Peripheral vascular disease" :checked="false" />
        <x-calc.checkbox name="cvd" label="Stroke or TIA" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="dementia" label="Dementia" :checked="false" />
        <x-calc.checkbox name="copd" label="Chronic lung disease" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="ctd" label="Connective tissue disease" :checked="false" />
        <x-calc.checkbox name="ulcer" label="Peptic ulcer disease" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="liver" label="Liver disease" :options="['o0' => 'None (0 points)', 'o1' => 'Mild (chronic hepatitis or cirrhosis without portal hypertension) (1 point)', 'o2' => 'Moderate to severe (3 points)']" selected="o0" />
        <x-calc.select name="diabetes" label="Diabetes" :options="['o0' => 'None or diet-controlled (0 points)', 'o1' => 'Uncomplicated (1 point)', 'o2' => 'With end-organ damage (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="hemiplegia" label="Hemiplegia" :checked="false" />
        <x-calc.checkbox name="ckd" label="Moderate to severe chronic kidney disease" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="tumour" label="Solid tumour" :options="['o0' => 'None (0 points)', 'o1' => 'Localised (2 points)', 'o2' => 'Metastatic (6 points)']" selected="o0" />
        <x-calc.checkbox name="leukaemia" label="Leukaemia" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="lymphoma" label="Lymphoma" :checked="false" />
        <x-calc.checkbox name="aids" label="AIDS" :checked="false" />
    </div>

    <x-calc.select name="age" label="Age (age-adjusted index)" :options="['o0' => 'Under 50 (0 points)', 'o1' => '50–59 (1 point)', 'o2' => '60–69 (2 points)', 'o3' => '70–79 (3 points)', 'o4' => '80 or older (4 points)']" selected="o0" />

    <x-calc.result label="Charlson Comorbidity Index (age-adjusted)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mi' => false, 'chf' => false, 'pvd' => false, 'cvd' => false, 'dementia' => false, 'copd' => false, 'ctd' => false, 'ulcer' => false, 'liver' => 'o0', 'diabetes' => 'o0', 'hemiplegia' => false, 'ckd' => false, 'tumour' => 'o0', 'leukaemia' => false, 'lymphoma' => false, 'aids' => false, 'age' => 'o0'],
        'Highest' => ['mi' => true, 'chf' => true, 'pvd' => true, 'cvd' => true, 'dementia' => true, 'copd' => true, 'ctd' => true, 'ulcer' => true, 'liver' => 'o2', 'diabetes' => 'o2', 'hemiplegia' => true, 'ckd' => true, 'tumour' => 'o2', 'leukaemia' => true, 'lymphoma' => true, 'aids' => true, 'age' => 'o4'],
        'Older with HF' => ['mi' => false, 'chf' => true, 'pvd' => false, 'cvd' => false, 'dementia' => false, 'copd' => false, 'ctd' => false, 'ulcer' => false, 'liver' => 'o0', 'diabetes' => 'o1', 'hemiplegia' => false, 'ckd' => false, 'tumour' => 'o0', 'leukaemia' => false, 'lymphoma' => false, 'aids' => false, 'age' => 'o3'],
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
            <li>Charlson Comorbidity Index (age-adjusted): sum of item points (maximum 37)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
