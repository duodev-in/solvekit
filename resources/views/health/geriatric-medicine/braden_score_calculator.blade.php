<x-calc.page
    title="Braden Score Calculator - SolveKit"
    description="Free Braden Scale calculator: pressure injury (bedsore) risk from sensory perception, moisture, activity, mobility, nutrition and friction, scored 6–23."
    lede="Score pressure injury risk (Braden)."
    about="The Braden Scale (Bergstrom et al. 1987) is the most used pressure injury risk tool. Lower scores mean higher risk: 19–23 no significant risk, 15–18 mild, 13–14 moderate, 10–12 high and 9 or less very high. Nurses use it to plan turning, support surfaces and nutrition. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['sensory', 'moisture', 'activity', 'mobility', 'nutrition', 'friction'], 'data' => ['score' => config('health_data.scores.braden')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a bedfast, very limited mobility patient with occasional moisture score?', 'answer' => '16 of 23: Mild risk (15–18).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sensory" label="Sensory perception" :options="['o0' => 'Completely limited (1 point)', 'o1' => 'Very limited (2 points)', 'o2' => 'Slightly limited (3 points)', 'o3' => 'No impairment (4 points)']" selected="o3" />
        <x-calc.select name="moisture" label="Moisture" :options="['o0' => 'Constantly moist (1 point)', 'o1' => 'Very moist (2 points)', 'o2' => 'Occasionally moist (3 points)', 'o3' => 'Rarely moist (4 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="activity" label="Activity" :options="['o0' => 'Bedfast (1 point)', 'o1' => 'Chairfast (2 points)', 'o2' => 'Walks occasionally (3 points)', 'o3' => 'Walks frequently (4 points)']" selected="o3" />
        <x-calc.select name="mobility" label="Mobility" :options="['o0' => 'Completely immobile (1 point)', 'o1' => 'Very limited (2 points)', 'o2' => 'Slightly limited (3 points)', 'o3' => 'No limitation (4 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="nutrition" label="Nutrition" :options="['o0' => 'Very poor (1 point)', 'o1' => 'Probably inadequate (2 points)', 'o2' => 'Adequate (3 points)', 'o3' => 'Excellent (4 points)']" selected="o2" />
        <x-calc.select name="friction" label="Friction and shear" :options="['o0' => 'Problem (1 point)', 'o1' => 'Potential problem (2 points)', 'o2' => 'No apparent problem (3 points)']" selected="o2" />
    </div>

    <x-calc.result label="Braden Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensory' => 'o3', 'moisture' => 'o3', 'activity' => 'o3', 'mobility' => 'o3', 'nutrition' => 'o2', 'friction' => 'o2'],
        'Highest' => ['sensory' => 'o3', 'moisture' => 'o3', 'activity' => 'o3', 'mobility' => 'o3', 'nutrition' => 'o3', 'friction' => 'o2'],
        'Bedfast' => ['sensory' => 'o3', 'moisture' => 'o2', 'activity' => 'o0', 'mobility' => 'o1', 'nutrition' => 'o2', 'friction' => 'o2'],
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
            <li>Braden Scale: sum of item points (maximum 23)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
