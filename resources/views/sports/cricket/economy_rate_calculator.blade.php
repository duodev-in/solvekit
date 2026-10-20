<x-calc.page
    title="Economy Rate Calculator - SolveKit"
    description="Free economy rate calculator: runs conceded per over, with balls as 12.3 overs."
    lede="Find a bowler’s economy rate."
    about="Economy rate is runs conceded per over bowled."
    :calc="['engine' => 'sp-ball', 'tool' => 'economy', 'fields' => ['R', 'O', 'W'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the economy for 38 runs in 10 overs?', 'answer' => '3.80.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Runs conceded" value="38" min="0" step="any" />
        <x-calc.field name="O" label="Overs bowled (12.3 = 12½)" value="10" min="0" step="any" />
        <x-calc.field name="W" label="Wickets (optional)" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="Economy rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['R' => 38, 'O' => 10, 'W' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'balls' => ['label' => 'Balls bowled'],
            'sr' => ['label' => 'Strike rate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
