<x-calc.page
    title="DAPT calculator - SolveKit"
    description="Free DAPT score calculator: whether continuing dual antiplatelet therapy beyond 12 months after a coronary stent is likely to help more than harm (Yeh et al. 2016)."
    lede="Score the DAPT benefit–risk balance."
    about="The DAPT score (Yeh et al., JAMA 2016) is for people who have taken dual antiplatelet therapy for 12 months after PCI without a major bleed or ischaemic event. Age lowers the score; smoking, diabetes, heart attack, previous PCI, small or paclitaxel stents, heart failure and vein-graft PCI raise it. 2 or more favours continuing; under 2 favours stopping. Medicines should only be changed by the treating doctor. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['age', 'smoker', 'dm', 'mi', 'prior', 'paclitaxel', 'small', 'chf', 'graft'], 'data' => ['score' => config('health_data.scores.dapt')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a 60-year-old smoker with diabetes and a heart attack at presentation score?', 'answer' => '3 of 10: 2 or more: benefit likely to outweigh bleeding.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="age" label="Age" :options="['o0' => 'Under 65 (0 points)', 'o1' => '65–74 (-1 points)', 'o2' => '75 or older (-2 points)']" selected="o0" />
        <x-calc.checkbox name="smoker" label="Cigarette smoking (now or in the last year)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="dm" label="Diabetes" :checked="false" />
        <x-calc.checkbox name="mi" label="Heart attack at presentation" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="prior" label="Previous PCI or heart attack" :checked="false" />
        <x-calc.checkbox name="paclitaxel" label="Paclitaxel-eluting stent" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="small" label="Stent diameter under 3 mm" :checked="false" />
        <x-calc.checkbox name="chf" label="Heart failure or LVEF under 30%" :checked="false" />
    </div>

    <x-calc.checkbox name="graft" label="Vein graft PCI" :checked="false" />

    <x-calc.result label="DAPT score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 'o0', 'smoker' => false, 'dm' => false, 'mi' => false, 'prior' => false, 'paclitaxel' => false, 'small' => false, 'chf' => false, 'graft' => false],
        'Highest' => ['age' => 'o0', 'smoker' => true, 'dm' => true, 'mi' => true, 'prior' => true, 'paclitaxel' => true, 'small' => true, 'chf' => true, 'graft' => true],
        'Smoker with diabetes' => ['age' => 'o0', 'smoker' => true, 'dm' => true, 'mi' => true, 'prior' => false, 'paclitaxel' => false, 'small' => false, 'chf' => false, 'graft' => false],
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
            <li>DAPT score: sum of item points (maximum 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
