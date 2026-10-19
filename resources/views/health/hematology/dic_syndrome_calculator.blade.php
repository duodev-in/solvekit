<x-calc.page
    title="DIC Syndrome Calculator - SolveKit"
    description="Free DIC calculator: the ISTH overt disseminated intravascular coagulation score from platelets, D-dimer, PT and fibrinogen."
    lede="Score overt DIC (ISTH)."
    about="The ISTH score (Taylor et al. 2001) is used only when a condition that can cause DIC is present (sepsis, trauma, cancer, obstetric complications). A total of 5 or more is compatible with overt DIC; under 5 suggests non-overt DIC and the score should be repeated. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['platelets', 'fibrin', 'pt', 'fibrinogen'], 'data' => ['score' => config('health_data.scores.dic')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does platelets 40, a strong D-dimer rise and PT prolonged by 4 s score?', 'answer' => '6 of 8: Compatible with overt DIC (5 or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="platelets" label="Platelet count (× 10⁹/L)" :options="['o0' => 'Over 100 (0 points)', 'o1' => '50–100 (1 point)', 'o2' => 'Under 50 (2 points)']" selected="o0" />
        <x-calc.select name="fibrin" label="Fibrin marker (D-dimer or FDP)" :options="['o0' => 'No increase (0 points)', 'o1' => 'Moderate increase (2 points)', 'o2' => 'Strong increase (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="pt" label="Prolonged prothrombin time" :options="['o0' => 'Under 3 seconds (0 points)', 'o1' => '3–6 seconds (1 point)', 'o2' => 'Over 6 seconds (2 points)']" selected="o0" />
        <x-calc.select name="fibrinogen" label="Fibrinogen" :options="['o0' => 'Over 1 g/L (0 points)', 'o1' => '1 g/L or less (1 point)']" selected="o0" />
    </div>

    <x-calc.result label="ISTH overt DIC score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['platelets' => 'o0', 'fibrin' => 'o0', 'pt' => 'o0', 'fibrinogen' => 'o0'],
        'Highest' => ['platelets' => 'o2', 'fibrin' => 'o2', 'pt' => 'o2', 'fibrinogen' => 'o1'],
        'Septic' => ['platelets' => 'o2', 'fibrin' => 'o2', 'pt' => 'o1', 'fibrinogen' => 'o0'],
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
            <li>ISTH overt DIC score: sum of item points (maximum 8)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
