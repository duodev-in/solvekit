<x-calc.page
    title="Diabetes Risk Calculator - SolveKit"
    description="Free diabetes risk calculator: the American Diabetes Association type 2 diabetes risk test, scoring age, sex, family history, blood pressure, activity and weight."
    lede="Check your risk of type 2 diabetes."
    about="The ADA risk test (Bang et al. 2009) adds points for age, male sex, gestational diabetes, a parent or sibling with diabetes, high blood pressure, inactivity and weight category. A score of 5 or more means increased risk of having undiagnosed type 2 diabetes, and a blood test is advised. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['age_band', 'sex', 'gdm', 'family', 'bp', 'active', 'weight_band'], 'data' => ['score' => config('health_data.scores.ada_diabetes')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does the default answer set score?', 'answer' => '2 of 11 points: Lower risk.'],
        ['question' => 'What is the highest possible score?', 'answer' => '11 of 11 points.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="age_band" label="Age" :options="['o0' => 'Under 40 (0 points)', 'o1' => '40–49 (1 point)', 'o2' => '50–59 (2 points)', 'o3' => '60 or older (3 points)']" selected="o1" />
        <x-calc.select name="sex" label="Sex" :options="['o0' => 'Woman (0 points)', 'o1' => 'Man (1 point)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="gdm" label="Ever diagnosed with gestational diabetes (women)" :checked="false" />
        <x-calc.checkbox name="family" label="Mother, father, sister or brother with diabetes" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="bp" label="Ever diagnosed with high blood pressure" :checked="false" />
        <x-calc.select name="active" label="Physically active" :options="['o0' => 'Yes (0 points)', 'o1' => 'No (1 point)']" selected="o0" />
    </div>

    <x-calc.select name="weight_band" label="Weight category (BMI)" :options="['o0' => 'BMI under 25 (0 points)', 'o1' => 'BMI 25–29.9 (1 point)', 'o2' => 'BMI 30–39.9 (2 points)', 'o3' => 'BMI 40 or more (3 points)']" selected="o1" />

    <x-calc.result label="ADA diabetes risk score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age_band' => 'o1', 'sex' => 'o0', 'gdm' => false, 'family' => false, 'bp' => false, 'active' => 'o0', 'weight_band' => 'o1'],
        'Highest' => ['age_band' => 'o3', 'sex' => 'o1', 'gdm' => true, 'family' => true, 'bp' => true, 'active' => 'o1', 'weight_band' => 'o3'],
        'Overweight man 50' => ['age_band' => 'o2', 'sex' => 'o1', 'gdm' => false, 'family' => true, 'bp' => false, 'active' => 'o0', 'weight_band' => 'o1'],
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
            <li>ADA diabetes risk score: sum of item points (maximum 11)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
