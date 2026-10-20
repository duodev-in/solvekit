<x-calc.page
    title="Passer Rating Calculator - SolveKit"
    description="Free passer rating calculator: NFL and NCAA quarterback ratings."
    lede="Find a passer rating."
    about="The NFL rating combines completion rate, yards, touchdowns and interceptions per attempt, capped at 158.3."
    :calc="['engine' => 'sp-ball', 'tool' => 'passer_rating', 'fields' => ['league', 'C', 'A', 'Y', 'TD', 'INT'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the rating for 25 of 35, 300 yards, 3 TD, 1 INT?', 'answer' => '114.0.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="league" label="Formula" :options="['nfl' => 'NFL and CFL', 'ncaa' => 'NCAA (college)']" selected="nfl" />
        <x-calc.field name="C" label="Completions" value="25" min="0" step="any" />
        <x-calc.field name="A" label="Attempts" value="35" min="1" step="any" />
        <x-calc.field name="Y" label="Passing yards" value="300" min="0" step="any" />
        <x-calc.field name="TD" label="Touchdowns" value="3" min="0" step="any" />
        <x-calc.field name="INT" label="Interceptions" value="1" min="0" step="any" />
    </div>

    <x-calc.result label="Passer rating" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['league' => 'nfl', 'C' => 25, 'A' => 35, 'Y' => 300, 'TD' => 3, 'INT' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'parts' => ['label' => 'Components (each 0 to 2.375)'],
            'perfect' => ['label' => 'Scale'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
