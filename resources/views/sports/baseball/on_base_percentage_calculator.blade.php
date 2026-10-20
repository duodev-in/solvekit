<x-calc.page
    title="On Base Percentage Calculator - SolveKit"
    description="Free OBP calculator: on-base percentage from hits, walks, hit by pitch, at-bats and sacrifice flies."
    lede="Find on-base percentage."
    about="On-base percentage counts how often a batter reaches base by a hit, walk or hit-by-pitch."
    :calc="['engine' => 'sp-ball', 'tool' => 'obp', 'fields' => ['H', 'BB', 'HBP', 'AB', 'SF'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the OBP of the example line?', 'answer' => '.388.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="H" label="Hits" value="150" min="0" step="any" />
        <x-calc.field name="BB" label="Walks" value="70" min="0" step="any" />
        <x-calc.field name="HBP" label="Hit by pitch" value="5" min="0" step="any" />
        <x-calc.field name="AB" label="At-bats" value="500" min="1" step="any" />
        <x-calc.field name="SF" label="Sacrifice flies" value="5" min="0" step="any" />
    </div>

    <x-calc.result label="On-base percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['H' => 150, 'BB' => 70, 'HBP' => 5, 'AB' => 500, 'SF' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tob' => ['label' => 'Times on base'],
            'pa' => ['label' => 'Plate appearances counted'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
