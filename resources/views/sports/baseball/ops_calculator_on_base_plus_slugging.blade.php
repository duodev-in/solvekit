<x-calc.page
    title="OPS Calculator (On-Base Plus Slugging) - SolveKit"
    description="Free OPS calculator: on-base plus slugging from a batting line, with OBP and SLG."
    lede="Find OPS."
    about="OPS adds on-base percentage and slugging percentage into one measure of hitting; .800 is good and .900 excellent."
    :calc="['engine' => 'sp-ball', 'tool' => 'ops', 'fields' => ['s1', 's2', 's3', 'HR', 'BB', 'HBP', 'AB', 'SF'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the OPS of the example line?', 'answer' => '.859.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="s1" label="Singles" value="100" min="0" step="any" />
        <x-calc.field name="s2" label="Doubles" value="30" min="0" step="any" />
        <x-calc.field name="s3" label="Triples" value="3" min="0" step="any" />
        <x-calc.field name="HR" label="Home runs" value="25" min="0" step="any" />
        <x-calc.field name="BB" label="Walks" value="70" min="0" step="any" />
        <x-calc.field name="HBP" label="Hit by pitch" value="5" min="0" step="any" />
        <x-calc.field name="AB" label="At-bats" value="550" min="1" step="any" />
        <x-calc.field name="SF" label="Sacrifice flies" value="5" min="0" step="any" />
    </div>

    <x-calc.result label="OPS" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['s1' => 100, 's2' => 30, 's3' => 3, 'HR' => 25, 'BB' => 70, 'HBP' => 5, 'AB' => 550, 'SF' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'obp' => ['label' => 'On-base percentage'],
            'slg' => ['label' => 'Slugging percentage'],
            'band' => ['label' => 'Rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
