<x-calc.page
    title="VTE Risk Score Calculator in Pregnancy - SolveKit"
    description="Free VTE risk score in pregnancy: the RCOG Green-top Guideline 37a risk factors for blood clots in pregnancy and after birth, with the thromboprophylaxis bands."
    lede="Score blood clot risk in pregnancy."
    about="The RCOG (2015) scores pre-existing, obstetric and transient risk factors. Antenatally, 4 or more points suggests considering thromboprophylaxis from the first trimester and 3 points from 28 weeks; after birth, 2 or more suggests at least 10 days. Previous VTE always needs specialist planning. Medicines are decided by the maternity team. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['previous', 'surgical_vte', 'thrombophilia_high', 'comorbid', 'family', 'thrombophilia_low', 'age', 'bmi', 'parity', 'smoker', 'varicose', 'preeclampsia', 'art', 'multiple', 'delivery', 'operative', 'prolonged', 'pph', 'preterm', 'stillbirth', 'surgery', 'hyperemesis', 'ohss', 'infection', 'immobile'], 'data' => ['score' => config('health_data.scores.vte_pregnancy')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does age over 35, BMI 32 and a caesarean in labour score?', 'answer' => '4 of 43: Antenatally, the guideline advises considering thromboprophylaxis from the first trimester; previous VTE needs specialist planning. Decisions rest with the maternity team.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="previous" label="Previous VTE (except a single event after major surgery)" :checked="false" />
        <x-calc.checkbox name="surgical_vte" label="Previous VTE provoked by major surgery" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="thrombophilia_high" label="Known high-risk thrombophilia" :checked="false" />
        <x-calc.checkbox name="comorbid" label="Medical comorbidity (cancer, heart failure, active lupus, IBD, inflammatory arthritis, nephrotic syndrome, type 1 diabetes with nephropathy, sickle cell disease, injecting drug use)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="family" label="Family history of unprovoked or oestrogen-related VTE in a first-degree relative" :checked="false" />
        <x-calc.checkbox name="thrombophilia_low" label="Known low-risk thrombophilia (no VTE)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="age" label="Age over 35" :checked="false" />
        <x-calc.select name="bmi" label="Body mass index (booking)" :options="['o0' => 'Under 30 (0 points)', 'o1' => '30–39.9 (1 point)', 'o2' => '40 or more (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="parity" label="Parity 3 or more" :checked="false" />
        <x-calc.checkbox name="smoker" label="Smoker" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="varicose" label="Gross varicose veins" :checked="false" />
        <x-calc.checkbox name="preeclampsia" label="Pre-eclampsia in this pregnancy" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="art" label="IVF or assisted reproduction (antenatal only)" :checked="false" />
        <x-calc.checkbox name="multiple" label="Multiple pregnancy" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="delivery" label="Delivery (postnatal)" :options="['o0' => 'Not delivered or vaginal birth (0 points)', 'o1' => 'Elective caesarean (1 point)', 'o2' => 'Caesarean in labour (2 points)']" selected="o0" />
        <x-calc.checkbox name="operative" label="Mid-cavity or rotational operative delivery" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="prolonged" label="Prolonged labour (over 24 hours)" :checked="false" />
        <x-calc.checkbox name="pph" label="Postpartum haemorrhage over 1 litre or transfusion" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="preterm" label="Preterm birth before 37 weeks in this pregnancy" :checked="false" />
        <x-calc.checkbox name="stillbirth" label="Stillbirth in this pregnancy" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="surgery" label="Any surgery in pregnancy or after birth (except immediate perineal repair)" :checked="false" />
        <x-calc.checkbox name="hyperemesis" label="Hyperemesis" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="ohss" label="Ovarian hyperstimulation syndrome (first trimester only)" :checked="false" />
        <x-calc.checkbox name="infection" label="Current systemic infection" :checked="false" />
    </div>

    <x-calc.checkbox name="immobile" label="Immobility or dehydration" :checked="false" />

    <x-calc.result label="RCOG VTE risk score in pregnancy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['previous' => false, 'surgical_vte' => false, 'thrombophilia_high' => false, 'comorbid' => false, 'family' => false, 'thrombophilia_low' => false, 'age' => false, 'bmi' => 'o0', 'parity' => false, 'smoker' => false, 'varicose' => false, 'preeclampsia' => false, 'art' => false, 'multiple' => false, 'delivery' => 'o0', 'operative' => false, 'prolonged' => false, 'pph' => false, 'preterm' => false, 'stillbirth' => false, 'surgery' => false, 'hyperemesis' => false, 'ohss' => false, 'infection' => false, 'immobile' => false],
        'Highest' => ['previous' => true, 'surgical_vte' => true, 'thrombophilia_high' => true, 'comorbid' => true, 'family' => true, 'thrombophilia_low' => true, 'age' => true, 'bmi' => 'o2', 'parity' => true, 'smoker' => true, 'varicose' => true, 'preeclampsia' => true, 'art' => true, 'multiple' => true, 'delivery' => 'o2', 'operative' => true, 'prolonged' => true, 'pph' => true, 'preterm' => true, 'stillbirth' => true, 'surgery' => true, 'hyperemesis' => true, 'ohss' => true, 'infection' => true, 'immobile' => true],
        'After caesarean' => ['previous' => false, 'surgical_vte' => false, 'thrombophilia_high' => false, 'comorbid' => false, 'family' => false, 'thrombophilia_low' => false, 'age' => true, 'bmi' => 'o1', 'parity' => false, 'smoker' => false, 'varicose' => false, 'preeclampsia' => false, 'art' => false, 'multiple' => false, 'delivery' => 'o2', 'operative' => false, 'prolonged' => false, 'pph' => false, 'preterm' => false, 'stillbirth' => false, 'surgery' => false, 'hyperemesis' => false, 'ohss' => false, 'infection' => false, 'immobile' => false],
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
            <li>RCOG VTE risk score in pregnancy: sum of item points (maximum 43)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
