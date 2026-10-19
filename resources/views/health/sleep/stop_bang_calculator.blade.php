<x-calc.page
    title="STOP-BANG Calculator - SolveKit"
    description="Free STOP-BANG calculator: screen for obstructive sleep apnoea with eight yes/no questions (snoring, tiredness, observed apnoea, blood pressure, BMI, age, neck size, sex)."
    lede="Screen for obstructive sleep apnoea."
    about="STOP-Bang (Chung et al. 2008) is a validated screening questionnaire for obstructive sleep apnoea. Each yes scores 1; 0–2 is low risk, 3–4 intermediate and 5–8 high risk of moderate to severe sleep apnoea. A sleep study confirms the diagnosis. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['snore', 'tired', 'observed', 'pressure', 'bmi', 'age', 'neck', 'male'], 'data' => ['score' => config('health_data.scores.stopbang')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What is the score for a 55-year-old man who snores and is tired?', 'answer' => '4 of 8: Intermediate risk (3–4).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="snore" label="Snoring loudly (heard through closed doors)" :checked="false" />
        <x-calc.checkbox name="tired" label="Often tired, fatigued or sleepy during the day" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="observed" label="Someone has seen you stop breathing during sleep" :checked="false" />
        <x-calc.checkbox name="pressure" label="Treated for high blood pressure" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="bmi" label="BMI over 35 kg/m²" :checked="false" />
        <x-calc.checkbox name="age" label="Age over 50" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="neck" label="Neck circumference over 40 cm (16 in)" :checked="false" />
        <x-calc.checkbox name="male" label="Male" :checked="false" />
    </div>

    <x-calc.result label="STOP-Bang score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['snore' => false, 'tired' => false, 'observed' => false, 'pressure' => false, 'bmi' => false, 'age' => false, 'neck' => false, 'male' => false],
        'Highest' => ['snore' => true, 'tired' => true, 'observed' => true, 'pressure' => true, 'bmi' => true, 'age' => true, 'neck' => true, 'male' => true],
        'Typical' => ['snore' => true, 'tired' => true, 'observed' => false, 'pressure' => false, 'bmi' => false, 'age' => true, 'neck' => false, 'male' => true],
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
            <li>STOP-Bang score: sum of item points (maximum 8)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
