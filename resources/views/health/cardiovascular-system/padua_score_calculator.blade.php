<x-calc.page
    title="Padua Score Calculator - SolveKit"
    description="Free Padua prediction score calculator: risk of venous thromboembolism in hospital medical patients from 11 risk factors, with the high-risk cut-off of 4."
    lede="Score VTE risk in hospital patients."
    about="The Padua Prediction Score (Barbar et al. 2010) helps decide thromboprophylaxis in medical inpatients. Scores of 4 or more are high risk: about 11% developed VTE without prophylaxis versus 0.3% below 4. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['cancer', 'vte', 'mobility', 'thrombophilia', 'trauma', 'age', 'failure', 'mi', 'infection', 'obesity', 'hormones'], 'data' => ['score' => config('health_data.scores.padua')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does active cancer with reduced mobility score?', 'answer' => '6 of 20: High risk (4 or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="cancer" label="Active cancer" :checked="false" />
        <x-calc.checkbox name="vte" label="Previous VTE (excluding superficial thrombosis)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="mobility" label="Reduced mobility (bed rest for at least 3 days)" :checked="false" />
        <x-calc.checkbox name="thrombophilia" label="Known thrombophilic condition" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="trauma" label="Recent trauma or surgery (within a month)" :checked="false" />
        <x-calc.checkbox name="age" label="Age 70 or older" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="failure" label="Heart and/or respiratory failure" :checked="false" />
        <x-calc.checkbox name="mi" label="Acute heart attack or ischaemic stroke" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="infection" label="Acute infection and/or rheumatological disorder" :checked="false" />
        <x-calc.checkbox name="obesity" label="Obesity (BMI 30 or more)" :checked="false" />
    </div>

    <x-calc.checkbox name="hormones" label="Ongoing hormonal treatment" :checked="false" />

    <x-calc.result label="Padua Prediction Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cancer' => false, 'vte' => false, 'mobility' => false, 'thrombophilia' => false, 'trauma' => false, 'age' => false, 'failure' => false, 'mi' => false, 'infection' => false, 'obesity' => false, 'hormones' => false],
        'Highest' => ['cancer' => true, 'vte' => true, 'mobility' => true, 'thrombophilia' => true, 'trauma' => true, 'age' => true, 'failure' => true, 'mi' => true, 'infection' => true, 'obesity' => true, 'hormones' => true],
        'Cancer, bed rest' => ['cancer' => true, 'vte' => false, 'mobility' => true, 'thrombophilia' => false, 'trauma' => false, 'age' => false, 'failure' => false, 'mi' => false, 'infection' => false, 'obesity' => false, 'hormones' => false],
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
            <li>Padua Prediction Score: sum of item points (maximum 20)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
