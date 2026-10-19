<x-calc.page
    title="PSI Calculator - SolveKit"
    description="Free PSI calculator: the Pneumonia Severity Index (PORT score), 20 items for 30-day mortality class I–V in community-acquired pneumonia."
    lede="Score pneumonia severity (PSI/PORT)."
    about="The Pneumonia Severity Index (Fine et al. 1997) adds age (minus 10 for women) and points for nursing-home residence, five illnesses, five examination findings and seven test results. People 50 or under with none of the illnesses or examination findings are class I. Classes I–II are usually treated at home, III may need a short stay, and IV–V hospital care. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'psi', 'fields' => ['age', 'sex', 'nursing', 'cancer', 'liver', 'chf', 'cvd', 'renal', 'mental', 'rr', 'sbp', 'temp', 'pulse', 'ph', 'bun', 'na', 'glucose', 'hct', 'o2', 'effusion']]"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
        ['name' => 'Tick the findings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What class is a 65-year-old man with no other findings?', 'answer' => 'Class II (65 points; 30-day mortality about 0.6% in the derivation cohort).'],
        ['question' => 'And a 78-year-old woman with heart failure, confusion and BUN over 30?', 'answer' => 'Class IV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="65" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.checkbox name="nursing" label="Nursing home resident" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="cancer" label="Cancer (active)" :checked="false" />
        <x-calc.checkbox name="liver" label="Liver disease" :checked="false" />
        <x-calc.checkbox name="chf" label="Heart failure" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="cvd" label="Stroke or cerebrovascular disease" :checked="false" />
        <x-calc.checkbox name="renal" label="Kidney disease" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="mental" label="Altered mental status" :checked="false" />
        <x-calc.checkbox name="rr" label="Respiratory rate 30 or more" :checked="false" />
        <x-calc.checkbox name="sbp" label="Systolic BP under 90" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="temp" label="Temperature under 35 °C or 40 °C or more" :checked="false" />
        <x-calc.checkbox name="pulse" label="Pulse 125 or more" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="ph" label="Arterial pH under 7.35" :checked="false" />
        <x-calc.checkbox name="bun" label="BUN 30 mg/dL (urea 11 mmol/L) or more" :checked="false" />
        <x-calc.checkbox name="na" label="Sodium under 130 mmol/L" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="glucose" label="Glucose 250 mg/dL (14 mmol/L) or more" :checked="false" />
        <x-calc.checkbox name="hct" label="Hematocrit under 30%" :checked="false" />
        <x-calc.checkbox name="o2" label="PaO₂ under 60 or SpO₂ under 90%" :checked="false" />
    </div>

    <x-calc.checkbox name="effusion" label="Pleural effusion on X-ray" :checked="false" />

    <x-calc.result label="Pneumonia Severity Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 65, 'sex' => 'male', 'nursing' => false, 'cancer' => false, 'liver' => false, 'chf' => false, 'cvd' => false, 'renal' => false, 'mental' => false, 'rr' => false, 'sbp' => false, 'temp' => false, 'pulse' => false, 'ph' => false, 'bun' => false, 'na' => false, 'glucose' => false, 'hct' => false, 'o2' => false, 'effusion' => false],
        'Older woman' => ['age' => 78, 'sex' => 'female', 'chf' => true, 'mental' => true, 'bun' => true, 'nursing' => false, 'cancer' => false, 'liver' => false, 'cvd' => false, 'renal' => false, 'rr' => false, 'sbp' => false, 'temp' => false, 'pulse' => false, 'ph' => false, 'na' => false, 'glucose' => false, 'hct' => false, 'o2' => false, 'effusion' => false],
        'Young' => ['age' => 35, 'sex' => 'female', 'nursing' => false, 'cancer' => false, 'liver' => false, 'chf' => false, 'cvd' => false, 'renal' => false, 'mental' => false, 'rr' => false, 'sbp' => false, 'temp' => false, 'pulse' => false, 'ph' => false, 'bun' => false, 'na' => false, 'glucose' => false, 'hct' => false, 'o2' => false, 'effusion' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'points' => ['label' => 'Points'],
            'care' => ['label' => 'Site of care'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>points = age + findings</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
