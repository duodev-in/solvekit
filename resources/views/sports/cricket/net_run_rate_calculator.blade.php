<x-calc.page
    title="Net Run Rate Calculator - SolveKit"
    description="Free net run rate calculator: NRR across matches, with overs as 18.4 and all-out innings counted correctly."
    lede="Find net run rate."
    about="Net run rate is the run rate scored minus the run rate conceded over a tournament. A side bowled out counts its full quota of overs."
    :calc="['engine' => 'sp-ball', 'tool' => 'nrr', 'fields' => ['matches'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the NRR of the example matches?', 'answer' => '+0.308.'],
    ]"
>
    <x-calc.textarea name="matches" label="Matches: runs for, overs faced, runs against, overs bowled (one match per line; all out = full quota)" value="180, 20, 150, 20
142, 18.4, 160, 20
201, 20, 205, 19.5" rows="3" />

    <x-calc.result label="Net run rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['matches' => '180, 20, 150, 20
142, 18.4, 160, 20
201, 20, 205, 19.5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rf' => ['label' => 'Run rate for'],
            'ra' => ['label' => 'Run rate against'],
            'totals' => ['label' => 'Totals'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
