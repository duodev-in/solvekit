<x-calc.page
    title="LRINEC Score Calculator - SolveKit"
    description="Free LRINEC score calculator: Laboratory Risk Indicator for Necrotizing Fasciitis from CRP, white count, haemoglobin, sodium, creatinine and glucose."
    lede="Score the risk of necrotising fasciitis."
    about="LRINEC (Wong et al. 2004) uses six routine blood tests. 5 or less is low risk, 6–7 intermediate and 8 or more high risk. Later studies found it misses some cases, so a low score never overrides clinical suspicion: necrotising fasciitis is a surgical emergency. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['crp', 'wbc', 'hb', 'na', 'creatinine', 'glucose'], 'data' => ['score' => config('health_data.scores.lrinec')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does CRP 200, white count 20 and sodium 132 score?', 'answer' => '7 of 13: Intermediate risk (6–7).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="crp" label="C-reactive protein" :options="['o0' => 'Under 150 mg/L (0 points)', 'o1' => '150 mg/L or more (4 points)']" selected="o0" />
        <x-calc.select name="wbc" label="White cell count (×10⁹/L)" :options="['o0' => 'Under 15 (0 points)', 'o1' => '15–25 (1 point)', 'o2' => 'Over 25 (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="hb" label="Haemoglobin" :options="['o0' => 'Over 13.5 g/dL (0 points)', 'o1' => '11–13.5 g/dL (1 point)', 'o2' => 'Under 11 g/dL (2 points)']" selected="o0" />
        <x-calc.select name="na" label="Sodium" :options="['o0' => '135 mmol/L or more (0 points)', 'o1' => 'Under 135 mmol/L (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="creatinine" label="Creatinine" :options="['o0' => '1.6 mg/dL (141 µmol/L) or less (0 points)', 'o1' => 'Over 1.6 mg/dL (141 µmol/L) (2 points)']" selected="o0" />
        <x-calc.select name="glucose" label="Glucose" :options="['o0' => '180 mg/dL (10 mmol/L) or less (0 points)', 'o1' => 'Over 180 mg/dL (10 mmol/L) (1 point)']" selected="o0" />
    </div>

    <x-calc.result label="LRINEC score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['crp' => 'o0', 'wbc' => 'o0', 'hb' => 'o0', 'na' => 'o0', 'creatinine' => 'o0', 'glucose' => 'o0'],
        'Highest' => ['crp' => 'o1', 'wbc' => 'o2', 'hb' => 'o2', 'na' => 'o1', 'creatinine' => 'o1', 'glucose' => 'o1'],
        'High CRP' => ['crp' => 'o1', 'wbc' => 'o1', 'hb' => 'o0', 'na' => 'o1', 'creatinine' => 'o0', 'glucose' => 'o0'],
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
            <li>LRINEC score: sum of item points (maximum 13)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
