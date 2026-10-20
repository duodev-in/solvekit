<x-calc.page
    title="Winning Percentage Calculator - SolveKit"
    description="Free winning percentage calculator: win percentage with ties and games behind."
    lede="Find a winning percentage."
    about="Winning percentage is wins (plus half of ties) divided by games."
    :calc="['engine' => 'sp-ball', 'tool' => 'win_pct', 'fields' => ['W', 'L', 'T', 'lw', 'll'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 50–30–2?', 'answer' => '.622.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="W" label="Wins" value="50" min="0" step="any" />
        <x-calc.field name="L" label="Losses" value="30" min="0" step="any" />
        <x-calc.field name="T" label="Ties (or draws)" value="2" min="0" step="any" />
        <x-calc.field name="lw" label="Leader’s wins (optional)" value="55" min="0" step="any" />
        <x-calc.field name="ll" label="Leader’s losses (optional)" value="27" min="0" step="any" />
    </div>

    <x-calc.result label="Winning percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['W' => 50, 'L' => 30, 'T' => 2, 'lw' => 55, 'll' => 27],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'games' => ['label' => 'Games played'],
            'gb' => ['label' => 'Games behind the leader'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
