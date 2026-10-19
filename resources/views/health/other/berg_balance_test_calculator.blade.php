<x-calc.page
    title="Berg Balance Test Calculator - SolveKit"
    description="Free Berg Balance Scale calculator: 14 balance tasks scored 0–4 each (0–56), with the fall-risk bands."
    lede="Score balance with the Berg Balance Scale."
    about="The Berg Balance Scale (Berg et al. 1989) is a widely used test of static and dynamic balance in older adults and after stroke. 41–56 is low fall risk, 21–40 medium and 0–20 high; a score under 45 is often used to flag increased fall risk. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['sit_stand', 'stand', 'sit', 'stand_sit', 'transfers', 'eyes_closed', 'feet_together', 'reach', 'pick_up', 'look_behind', 'turn', 'stool', 'tandem', 'one_leg'], 'data' => ['score' => config('health_data.scores.berg')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does needing supervision for the last four tasks score?', 'answer' => '46 of 56: Low fall risk (41–56).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sit_stand" label="Sitting to standing" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
        <x-calc.select name="stand" label="Standing unsupported (2 minutes)" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sit" label="Sitting unsupported (2 minutes)" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
        <x-calc.select name="stand_sit" label="Standing to sitting" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="transfers" label="Transfers" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
        <x-calc.select name="eyes_closed" label="Standing with eyes closed (10 seconds)" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="feet_together" label="Standing with feet together (1 minute)" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
        <x-calc.select name="reach" label="Reaching forward with outstretched arm" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="pick_up" label="Picking up an object from the floor" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
        <x-calc.select name="look_behind" label="Turning to look behind over each shoulder" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="turn" label="Turning 360°" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
        <x-calc.select name="stool" label="Placing alternate feet on a step or stool" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="tandem" label="Standing with one foot in front" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
        <x-calc.select name="one_leg" label="Standing on one leg" :options="['o0' => '0: unable or needs maximal help (0 points)', 'o1' => '1: needs moderate help (1 point)', 'o2' => '2: needs minimal help or supervision (2 points)', 'o3' => '3: able with some limitation (3 points)', 'o4' => '4: able safely and independently (4 points)']" selected="o4" />
    </div>

    <x-calc.result label="Berg Balance Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sit_stand' => 'o4', 'stand' => 'o4', 'sit' => 'o4', 'stand_sit' => 'o4', 'transfers' => 'o4', 'eyes_closed' => 'o4', 'feet_together' => 'o4', 'reach' => 'o4', 'pick_up' => 'o4', 'look_behind' => 'o4', 'turn' => 'o4', 'stool' => 'o4', 'tandem' => 'o4', 'one_leg' => 'o4'],
        'Highest' => ['sit_stand' => 'o4', 'stand' => 'o4', 'sit' => 'o4', 'stand_sit' => 'o4', 'transfers' => 'o4', 'eyes_closed' => 'o4', 'feet_together' => 'o4', 'reach' => 'o4', 'pick_up' => 'o4', 'look_behind' => 'o4', 'turn' => 'o4', 'stool' => 'o4', 'tandem' => 'o4', 'one_leg' => 'o4'],
        'Supervision' => ['sit_stand' => 'o4', 'stand' => 'o4', 'sit' => 'o4', 'stand_sit' => 'o4', 'transfers' => 'o4', 'eyes_closed' => 'o4', 'feet_together' => 'o4', 'reach' => 'o4', 'pick_up' => 'o4', 'look_behind' => 'o2', 'turn' => 'o2', 'stool' => 'o2', 'tandem' => 'o2', 'one_leg' => 'o2'],
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
            <li>Berg Balance Scale: sum of item points (maximum 56)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
