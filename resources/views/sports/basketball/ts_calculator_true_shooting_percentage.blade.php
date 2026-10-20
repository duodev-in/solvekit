<x-calc.page
    title="TS Calculator (True Shooting Percentage) - SolveKit"
    description="Free true shooting percentage calculator: TS% from points, field-goal and free-throw attempts."
    lede="Find true shooting percentage."
    about="True shooting measures scoring efficiency including threes and free throws: points ÷ (2 × (FGA + 0.44 FTA))."
    :calc="['engine' => 'sp-ball', 'tool' => 'ts', 'fields' => ['PTS', 'FGA', 'FTA'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is TS% for 25 points on 18 FGA and 6 FTA?', 'answer' => '60.56%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="PTS" label="Points" value="25" min="0" step="any" />
        <x-calc.field name="FGA" label="Field-goal attempts" value="18" min="0" step="any" />
        <x-calc.field name="FTA" label="Free-throw attempts" value="6" min="0" step="any" />
    </div>

    <x-calc.result label="True shooting percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['PTS' => 25, 'FGA' => 18, 'FTA' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tsa' => ['label' => 'True shooting attempts'],
            'band' => ['label' => 'Rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
