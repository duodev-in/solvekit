<x-calc.page
    title="RCRI Calculator - SolveKit"
    description="Free RCRI calculator: the Revised Cardiac Risk Index (Lee) for major cardiac complications after non-cardiac surgery, from six predictors."
    lede="Score cardiac risk before surgery."
    about="The Revised Cardiac Risk Index (Lee et al. 1999) counts six predictors: high-risk surgery, ischaemic heart disease, heart failure, cerebrovascular disease, insulin-treated diabetes and creatinine over 2 mg/dL. The original rates were 0.4%, 0.9%, 6.6% and 11% for 0, 1, 2 and 3+ points; later studies (Duceppe et al. 2017) found higher rates. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['surgery', 'ihd', 'chf', 'cvd', 'insulin', 'creatinine'], 'data' => ['score' => config('health_data.scores.rcri')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What class is abdominal surgery in someone with ischaemic heart disease?', 'answer' => '2 of 6: Class III (2).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="surgery" label="High-risk surgery (intraperitoneal, intrathoracic or suprainguinal vascular)" :checked="false" />
        <x-calc.checkbox name="ihd" label="Ischaemic heart disease" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="chf" label="Congestive heart failure" :checked="false" />
        <x-calc.checkbox name="cvd" label="Cerebrovascular disease (stroke or TIA)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="insulin" label="Diabetes treated with insulin" :checked="false" />
        <x-calc.checkbox name="creatinine" label="Creatinine over 2 mg/dL (177 µmol/L)" :checked="false" />
    </div>

    <x-calc.result label="Revised Cardiac Risk Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['surgery' => false, 'ihd' => false, 'chf' => false, 'cvd' => false, 'insulin' => false, 'creatinine' => false],
        'Highest' => ['surgery' => true, 'ihd' => true, 'chf' => true, 'cvd' => true, 'insulin' => true, 'creatinine' => true],
        'Surgery with IHD' => ['surgery' => true, 'ihd' => true, 'chf' => false, 'cvd' => false, 'insulin' => false, 'creatinine' => false],
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
            <li>Revised Cardiac Risk Index: sum of item points (maximum 6)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
