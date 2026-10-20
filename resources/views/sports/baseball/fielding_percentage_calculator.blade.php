<x-calc.page
    title="Fielding Percentage Calculator - SolveKit"
    description="Free fielding percentage calculator: FPCT from putouts, assists and errors."
    lede="Find fielding percentage."
    about="Fielding percentage is the share of chances handled without an error: (putouts + assists) ÷ total chances."
    :calc="['engine' => 'sp-ball', 'tool' => 'fielding_pct', 'fields' => ['PO', 'A', 'E'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is FPCT with 300 putouts, 120 assists and 8 errors?', 'answer' => '.981.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="PO" label="Putouts" value="300" min="0" step="any" />
        <x-calc.field name="A" label="Assists" value="120" min="0" step="any" />
        <x-calc.field name="E" label="Errors" value="8" min="0" step="any" />
    </div>

    <x-calc.result label="Fielding percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['PO' => 300, 'A' => 120, 'E' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tc' => ['label' => 'Total chances'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
