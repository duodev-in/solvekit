<x-calc.page
    title="eFG Calculator - SolveKit"
    description="Free eFG% calculator: effective field-goal percentage that credits three-pointers."
    lede="Find effective field-goal percentage."
    about="eFG% counts a made three as 1.5 field goals, because it is worth 50% more than a two."
    :calc="['engine' => 'sp-ball', 'tool' => 'efg', 'fields' => ['FG', 'P3', 'FGA'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is eFG% for 8 of 15 with 3 threes?', 'answer' => '63.33%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="FG" label="Field goals made" value="8" min="0" step="any" />
        <x-calc.field name="P3" label="Three-pointers made" value="3" min="0" step="any" />
        <x-calc.field name="FGA" label="Field-goal attempts" value="15" min="1" step="any" />
    </div>

    <x-calc.result label="Effective field-goal percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['FG' => 8, 'P3' => 3, 'FGA' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'fg' => ['label' => 'Plain FG%'],
            'boost' => ['label' => 'Added by three-pointers'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
