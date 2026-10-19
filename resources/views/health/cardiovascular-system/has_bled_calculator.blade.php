<x-calc.page
    title="HAS-BLED Calculator - SolveKit"
    description="Free HAS-BLED calculator: major bleeding risk on anticoagulation in atrial fibrillation from nine risk factors, with bleeds per 100 patient-years."
    lede="Score bleeding risk on anticoagulants."
    about="HAS-BLED (Pisters et al. 2010) scores Hypertension, Abnormal kidney or liver function, Stroke, Bleeding, Labile INR, Elderly (over 65) and Drugs or alcohol, one point each. A score of 3 or more marks high bleeding risk: guidelines use it to correct modifiable risks and schedule closer review, not as a reason to withhold anticoagulation. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['htn', 'renal', 'liver', 'stroke', 'bleeding', 'inr', 'elderly', 'drugs', 'alcohol'], 'data' => ['score' => config('health_data.scores.hasbled')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does age over 65 with antiplatelet use score?', 'answer' => '2 of 9: About 1.88 major bleeds per 100 patient-years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="htn" label="Hypertension (uncontrolled, systolic over 160 mmHg)" :checked="false" />
        <x-calc.checkbox name="renal" label="Abnormal kidney function (dialysis, transplant or creatinine 2.26 mg/dL / 200 µmol/L or more)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="liver" label="Abnormal liver function (cirrhosis, or bilirubin over 2× and AST/ALT over 3× normal)" :checked="false" />
        <x-calc.checkbox name="stroke" label="Previous stroke" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="bleeding" label="Previous major bleeding or bleeding tendency" :checked="false" />
        <x-calc.checkbox name="inr" label="Labile INR (time in range under 60%)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="elderly" label="Age over 65" :checked="false" />
        <x-calc.checkbox name="drugs" label="Antiplatelet drugs or NSAIDs" :checked="false" />
    </div>

    <x-calc.checkbox name="alcohol" label="Alcohol, 8 or more drinks a week" :checked="false" />

    <x-calc.result label="HAS-BLED score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['htn' => false, 'renal' => false, 'liver' => false, 'stroke' => false, 'bleeding' => false, 'inr' => false, 'elderly' => false, 'drugs' => false, 'alcohol' => false],
        'Highest' => ['htn' => true, 'renal' => true, 'liver' => true, 'stroke' => true, 'bleeding' => true, 'inr' => true, 'elderly' => true, 'drugs' => true, 'alcohol' => true],
        'Older on aspirin' => ['htn' => false, 'renal' => false, 'liver' => false, 'stroke' => false, 'bleeding' => false, 'inr' => false, 'elderly' => true, 'drugs' => true, 'alcohol' => false],
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
            <li>HAS-BLED score: sum of item points (maximum 9)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
