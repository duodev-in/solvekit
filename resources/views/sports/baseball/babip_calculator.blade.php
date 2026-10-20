<x-calc.page
    title="BABIP Calculator - SolveKit"
    description="Free BABIP calculator: batting average on balls in play."
    lede="Find BABIP."
    about="BABIP is the batting average on balls put in play (not home runs or strikeouts). Most players sit near .300, so big swings often reflect luck."
    :calc="['engine' => 'sp-ball', 'tool' => 'babip', 'fields' => ['H', 'HR', 'AB', 'K', 'SF'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the BABIP of the example line?', 'answer' => '.305.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="H" label="Hits" value="150" min="0" step="any" />
        <x-calc.field name="HR" label="Home runs" value="25" min="0" step="any" />
        <x-calc.field name="AB" label="At-bats" value="550" min="1" step="any" />
        <x-calc.field name="K" label="Strikeouts" value="120" min="0" step="any" />
        <x-calc.field name="SF" label="Sacrifice flies" value="5" min="0" step="any" />
    </div>

    <x-calc.result label="BABIP" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['H' => 150, 'HR' => 25, 'AB' => 550, 'K' => 120, 'SF' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bip' => ['label' => 'Balls in play'],
            'note' => ['label' => 'Context'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
