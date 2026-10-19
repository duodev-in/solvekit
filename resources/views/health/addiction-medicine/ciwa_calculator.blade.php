<x-calc.page
    title="CIWA Calculator - SolveKit"
    description="Free CIWA-Ar calculator: Clinical Institute Withdrawal Assessment for Alcohol, ten items scored 0–67 with the severity bands."
    lede="Score alcohol withdrawal severity."
    about="The CIWA-Ar (Sullivan et al. 1989) is used by clinicians to rate alcohol withdrawal: nine items scored 0–7 and orientation 0–4. Under about 8–10 means minimal withdrawal, 8–15 moderate and above 15 severe. It guides monitoring; treatment decisions belong to the clinical team. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['nausea', 'tremor', 'sweats', 'anxiety', 'agitation', 'tactile', 'auditory', 'visual', 'headache', 'orientation'], 'data' => ['score' => config('health_data.scores.ciwa')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What severity is a total of 12?', 'answer' => 'A score of 12 is moderate withdrawal (8–15).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="nausea" label="Nausea and vomiting" :options="['o0' => '0: none (0 points)', 'o1' => '1: mild nausea, no vomiting (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: intermittent nausea with dry heaves (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: constant nausea, frequent dry heaves and vomiting (7 points)']" selected="o0" />
        <x-calc.select name="tremor" label="Tremor" :options="['o0' => '0: none (0 points)', 'o1' => '1: not visible, can be felt (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: moderate, with arms extended (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: severe, even with arms not extended (7 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sweats" label="Paroxysmal sweats" :options="['o0' => '0: none (0 points)', 'o1' => '1: barely perceptible, palms moist (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: beads of sweat on forehead (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: drenching sweats (7 points)']" selected="o0" />
        <x-calc.select name="anxiety" label="Anxiety" :options="['o0' => '0: at ease (0 points)', 'o1' => '1: mildly anxious (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: moderately anxious or guarded (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: acute panic (7 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="agitation" label="Agitation" :options="['o0' => '0: normal activity (0 points)', 'o1' => '1: somewhat more than normal (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: moderately fidgety and restless (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: paces or thrashes about (7 points)']" selected="o0" />
        <x-calc.select name="tactile" label="Tactile disturbances" :options="['o0' => '0: none (0 points)', 'o1' => '1: very mild itching, pins and needles or numbness (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: moderately severe hallucinations (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: continuous hallucinations (7 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="auditory" label="Auditory disturbances" :options="['o0' => '0: not present (0 points)', 'o1' => '1: very mild harshness or ability to frighten (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: moderately severe hallucinations (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: continuous hallucinations (7 points)']" selected="o0" />
        <x-calc.select name="visual" label="Visual disturbances" :options="['o0' => '0: not present (0 points)', 'o1' => '1: very mild sensitivity (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: moderately severe hallucinations (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: continuous hallucinations (7 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="headache" label="Headache, fullness in head" :options="['o0' => '0: not present (0 points)', 'o1' => '1: very mild (1 point)', 'o2' => '2 (2 points)', 'o3' => '3 (3 points)', 'o4' => '4: moderately severe (4 points)', 'o5' => '5 (5 points)', 'o6' => '6 (6 points)', 'o7' => '7: extremely severe (7 points)']" selected="o0" />
        <x-calc.select name="orientation" label="Orientation and clouding of sensorium" :options="['o0' => '0: oriented, can do serial additions (0 points)', 'o1' => '1: cannot do serial additions or unsure of date (1 point)', 'o2' => '2: disoriented for date by up to 2 days (2 points)', 'o3' => '3: disoriented for date by more than 2 days (3 points)', 'o4' => '4: disoriented for place or person (4 points)']" selected="o0" />
    </div>

    <x-calc.result label="CIWA-Ar" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['nausea' => 'o0', 'tremor' => 'o0', 'sweats' => 'o0', 'anxiety' => 'o0', 'agitation' => 'o0', 'tactile' => 'o0', 'auditory' => 'o0', 'visual' => 'o0', 'headache' => 'o0', 'orientation' => 'o0'],
        'Highest' => ['nausea' => 'o7', 'tremor' => 'o7', 'sweats' => 'o7', 'anxiety' => 'o7', 'agitation' => 'o7', 'tactile' => 'o7', 'auditory' => 'o7', 'visual' => 'o7', 'headache' => 'o7', 'orientation' => 'o4'],
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
            <li>CIWA-Ar: sum of item points (maximum 67)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
