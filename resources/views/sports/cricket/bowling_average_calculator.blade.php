<x-calc.page
    title="Bowling Average Calculator - SolveKit"
    description="Free bowling average calculator: runs conceded per wicket, with strike rate and economy."
    lede="Find a bowling average."
    about="A bowling average is runs conceded per wicket: lower is better."
    :calc="['engine' => 'sp-ball', 'tool' => 'bowling_average', 'fields' => ['R', 'W', 'O'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the average for 450 runs and 20 wickets?', 'answer' => '22.50.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Runs conceded" value="450" min="0" step="any" />
        <x-calc.field name="W" label="Wickets" value="20" min="1" step="any" />
        <x-calc.field name="O" label="Overs bowled (optional; 12.3 = 12½)" value="150" min="0" step="any" />
    </div>

    <x-calc.result label="Bowling average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['R' => 450, 'W' => 20, 'O' => 150],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sr' => ['label' => 'Bowling strike rate (balls per wicket)'],
            'econ' => ['label' => 'Economy rate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
