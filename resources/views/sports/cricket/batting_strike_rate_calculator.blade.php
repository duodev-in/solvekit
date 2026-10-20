<x-calc.page
    title="Batting Strike Rate Calculator - SolveKit"
    description="Free cricket strike rate calculator: runs per 100 balls faced."
    lede="Find a batting strike rate."
    about="Strike rate is runs scored per 100 balls faced: how fast a batter scores."
    :calc="['engine' => 'sp-ball', 'tool' => 'strike_rate', 'fields' => ['R', 'B'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the strike rate for 85 off 60 balls?', 'answer' => '141.67.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Runs" value="85" min="0" step="any" />
        <x-calc.field name="B" label="Balls faced" value="60" min="1" step="any" />
    </div>

    <x-calc.result label="Batting strike rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['R' => 85, 'B' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rpo' => ['label' => 'Runs per over'],
            'band' => ['label' => 'Context'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
