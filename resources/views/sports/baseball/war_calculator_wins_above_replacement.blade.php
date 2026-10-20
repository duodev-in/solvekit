<x-calc.page
    title="WAR Calculator (Wins Above Replacement) - SolveKit"
    description="Free WAR calculator: position-player wins above replacement from component runs, using the FanGraphs framework."
    lede="Find WAR from component runs."
    about="WAR adds a player’s batting, base-running and fielding value to positional, league and replacement adjustments, then divides by runs per win. The components come from a stats site; this page combines them and shows the working."
    :calc="['engine' => 'sp-ball', 'tool' => 'war', 'fields' => ['bat', 'br', 'fld', 'pos', 'lg', 'rep', 'rpw'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What WAR do the example components give?', 'answer' => '5.7.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bat" label="Batting runs" value="25" step="any" />
        <x-calc.field name="br" label="Base-running runs" value="2" step="any" />
        <x-calc.field name="fld" label="Fielding runs" value="5" step="any" />
        <x-calc.field name="pos" label="Positional adjustment (runs)" value="2.5" step="any" />
        <x-calc.field name="lg" label="League adjustment (runs)" value="1" step="any" />
        <x-calc.field name="rep" label="Replacement-level runs" value="20" step="any" />
        <x-calc.field name="rpw" label="Runs per win" value="9.8" min="1" step="any" />
    </div>

    <x-calc.result label="WAR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bat' => 25, 'br' => 2, 'fld' => 5, 'pos' => 2.5, 'lg' => 1, 'rep' => 20, 'rpw' => 9.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rar' => ['label' => 'Runs above replacement'],
            'band' => ['label' => 'Rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
