<x-calc.page
    title="Bowling Score Calculator - SolveKit"
    description="Free bowling score calculator: ten-pin score frame by frame from your rolls."
    lede="Score a bowling game."
    about="Strikes score 10 plus the next two rolls and spares 10 plus the next one."
    :calc="['engine' => 'sp-misc', 'tool' => 'bowling_score', 'fields' => ['rolls'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does the example game score?', 'answer' => '236.'],
    ]"
>
    <x-calc.field name="rolls" label="Rolls (X strike, / spare, - miss, or pin counts)" value="X 7/ 9- X X X 8/ X X XXX" type="text" inputmode="text" />

    <x-calc.result label="Total score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rolls' => 'X 7/ 9- X X X 8/ X X XXX'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'frames' => ['label' => 'Frames completed'],
            'strikes' => ['label' => 'Strikes'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Score card" name="card" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
