<x-calc.page
    title="Wells Score Calculator for DVT - SolveKit"
    description="Free Wells score for DVT calculator: likelihood of deep vein thrombosis from ten clinical items, with the two-tier DVT likely or unlikely result."
    lede="Score the likelihood of DVT."
    about="The modified Wells score for DVT (Wells et al., N Engl J Med 2003) adds a point for each of nine findings and subtracts 2 when another diagnosis is at least as likely. 1 or less is “DVT unlikely”: a normal D-dimer then rules out DVT. 2 or more is “DVT likely” and an ultrasound is usually next. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['cancer', 'paralysis', 'bedridden', 'tender', 'leg', 'calf', 'pitting', 'veins', 'previous', 'alternative'], 'data' => ['score' => config('health_data.scores.wells_dvt')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a swollen calf (over 3 cm) with pitting oedema and tenderness score?', 'answer' => '3 of 9: DVT likely (2 or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="cancer" label="Active cancer (treatment within 6 months or palliative)" :checked="false" />
        <x-calc.checkbox name="paralysis" label="Paralysis, paresis or recent plaster cast of a leg" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="bedridden" label="Bedridden 3 or more days, or major surgery in the last 12 weeks" :checked="false" />
        <x-calc.checkbox name="tender" label="Localised tenderness along the deep veins" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="leg" label="Entire leg swollen" :checked="false" />
        <x-calc.checkbox name="calf" label="Calf swelling over 3 cm compared with the other leg" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="pitting" label="Pitting oedema confined to the symptomatic leg" :checked="false" />
        <x-calc.checkbox name="veins" label="Collateral superficial (non-varicose) veins" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="previous" label="Previously documented DVT" :checked="false" />
        <x-calc.checkbox name="alternative" label="An alternative diagnosis is at least as likely as DVT" :checked="false" />
    </div>

    <x-calc.result label="Wells score for DVT" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cancer' => false, 'paralysis' => false, 'bedridden' => false, 'tender' => false, 'leg' => false, 'calf' => false, 'pitting' => false, 'veins' => false, 'previous' => false, 'alternative' => false],
        'Highest' => ['cancer' => true, 'paralysis' => true, 'bedridden' => true, 'tender' => true, 'leg' => true, 'calf' => true, 'pitting' => true, 'veins' => true, 'previous' => true, 'alternative' => false],
        'Swollen calf' => ['cancer' => false, 'paralysis' => false, 'bedridden' => false, 'tender' => true, 'leg' => false, 'calf' => true, 'pitting' => true, 'veins' => false, 'previous' => false, 'alternative' => false],
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
            <li>Wells score for DVT: sum of item points (maximum 9)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
