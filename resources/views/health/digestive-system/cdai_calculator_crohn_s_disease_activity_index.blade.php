<x-calc.page
    title="CDAI calculator (Crohn's Disease Activity Index) - SolveKit"
    description="Free CDAI calculator: Crohn's Disease Activity Index from a 7-day diary, complications, antidiarrhoeal use, abdominal mass, haematocrit and weight."
    lede="Calculate the Crohn's Disease Activity Index."
    about="The CDAI (Best et al. 1976) adds weighted items: 2 × liquid stools over 7 days, 5 × the sum of daily abdominal pain ratings (0–3), 7 × the sum of daily well-being ratings (0–4), 20 per complication, 30 for antidiarrhoeal use, 10 × abdominal mass (0, 2 or 5), 6 × (47 or 42 − haematocrit) and the percentage below standard weight. Under 150 is remission and over 450 severe. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'cdai', 'fields' => ['stools', 'pain', 'wellbeing', 'arthritis', 'iritis', 'skin', 'anal', 'fistula', 'fever', 'antidiarrheal', 'mass', 'sex', 'hct', 'weight', 'standard']]"
    :how-to="[
        ['name' => 'Fill in the 7-day diary totals', 'text' => ''],
        ['name' => 'Tick complications', 'text' => ''],
        ['name' => 'Enter haematocrit and weights', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the CDAI for 21 stools, pain 7, well-being 7, Hct 40 and 3 kg under standard weight (man)?', 'answer' => '173: Mildly active (150–220).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="stools" label="Liquid or soft stools (7-day total)" value="21" min="0" step="1" />
        <x-calc.field name="pain" label="Abdominal pain (sum of 7 daily 0–3)" value="7" min="0" max="21" step="1" />
        <x-calc.field name="wellbeing" label="General well-being (sum of 7 daily 0–4)" value="7" min="0" max="28" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="arthritis" label="Arthritis or joint pain" :checked="false" />
        <x-calc.checkbox name="iritis" label="Iritis or uveitis" :checked="false" />
        <x-calc.checkbox name="skin" label="Erythema nodosum, pyoderma or mouth ulcers" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="anal" label="Anal fissure, fistula or abscess" :checked="false" />
        <x-calc.checkbox name="fistula" label="Other fistula" :checked="false" />
        <x-calc.checkbox name="fever" label="Fever over 37.8 °C in the past week" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="antidiarrheal" label="Taking antidiarrhoeal medicine" :checked="false" />
        <x-calc.select name="mass" label="Abdominal mass" :options="['0' => 'None', '2' => 'Questionable', '5' => 'Definite']" selected="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.field name="hct" label="Haematocrit" value="40" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="weight" label="Weight" value="62" min="0" step="any" suffix="kg" />
    </div>

    <x-calc.field name="standard" label="Standard (ideal) weight" value="65" min="0" step="any" suffix="kg" />

    <x-calc.result label="Crohn's Disease Activity Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['stools' => 21, 'pain' => 7, 'wellbeing' => 7, 'sex' => 'male', 'hct' => 40, 'weight' => 62, 'standard' => 65, 'mass' => '0', 'arthritis' => false, 'iritis' => false, 'skin' => false, 'anal' => false, 'fistula' => false, 'fever' => false, 'antidiarrheal' => false],
        'Flare' => ['stools' => 45, 'pain' => 14, 'wellbeing' => 18, 'anal' => true, 'antidiarrheal' => true, 'sex' => 'female', 'hct' => 33, 'weight' => 52, 'standard' => 60, 'mass' => '2', 'arthritis' => false, 'iritis' => false, 'skin' => false, 'fistula' => false, 'fever' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'parts' => ['label' => 'Parts'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CDAI = 2 S + 5 P + 7 W + 20 C + 30 A + 10 M + 6 ΔHct + %wt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
