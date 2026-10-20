<x-calc.page
    title="Usage Rate Calculator - SolveKit"
    description="Free usage rate calculator: share of team plays a player uses while on the court."
    lede="Find usage rate."
    about="Usage rate estimates the share of team possessions a player ends with a shot, free throws or a turnover while on the floor."
    :calc="['engine' => 'sp-ball', 'tool' => 'usage', 'fields' => ['FGA', 'FTA', 'TOV', 'MP', 'tFGA', 'tFTA', 'tTOV', 'tMP'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the usage rate in the example?', 'answer' => '28.48%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="FGA" label="Player FGA" value="18" min="0" step="any" />
        <x-calc.field name="FTA" label="Player FTA" value="6" min="0" step="any" />
        <x-calc.field name="TOV" label="Player turnovers" value="3" min="0" step="any" />
        <x-calc.field name="MP" label="Player minutes" value="36" min="1" step="any" />
        <x-calc.field name="tFGA" label="Team FGA" value="88" min="1" step="any" />
        <x-calc.field name="tFTA" label="Team FTA" value="22" min="0" step="any" />
        <x-calc.field name="tTOV" label="Team turnovers" value="13" min="0" step="any" />
        <x-calc.field name="tMP" label="Team minutes (240 for regulation)" value="240" min="1" step="any" />
    </div>

    <x-calc.result label="Usage rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['FGA' => 18, 'FTA' => 6, 'TOV' => 3, 'MP' => 36, 'tFGA' => 88, 'tFTA' => 22, 'tTOV' => 13, 'tMP' => 240],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'band' => ['label' => 'Context'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
