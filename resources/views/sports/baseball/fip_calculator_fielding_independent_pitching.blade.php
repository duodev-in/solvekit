<x-calc.page
    title="FIP Calculator (Fielding Independent Pitching) - SolveKit"
    description="Free FIP calculator: fielding independent pitching from home runs, walks, hit batters and strikeouts."
    lede="Find a pitcher’s FIP."
    about="FIP measures what a pitcher controls (strikeouts, walks, hit batters and home runs) and puts it on the ERA scale with a season constant published by FanGraphs."
    :calc="['engine' => 'sp-ball', 'tool' => 'fip', 'fields' => ['HR', 'BB', 'HBP', 'K', 'IP', 'C', 'ERA'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is FIP for the example line?', 'answer' => '3.25.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="HR" label="Home runs allowed" value="20" min="0" step="any" />
        <x-calc.field name="BB" label="Walks" value="50" min="0" step="any" />
        <x-calc.field name="HBP" label="Hit batters" value="6" min="0" step="any" />
        <x-calc.field name="K" label="Strikeouts" value="200" min="0" step="any" />
        <x-calc.field name="IP" label="Innings pitched (6.1 = 6⅓)" value="190" min="0" step="any" />
        <x-calc.field name="C" label="FIP constant (season value; about 3.1–3.2)" value="3.1" step="any" />
        <x-calc.field name="ERA" label="ERA (optional, to compare)" value="3.4" min="0" step="any" />
    </div>

    <x-calc.result label="FIP" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['HR' => 20, 'BB' => 50, 'HBP' => 6, 'K' => 200, 'IP' => 190, 'C' => 3.1, 'ERA' => 3.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'core' => ['label' => 'Before the constant'],
            'vs' => ['label' => 'Compared with ERA'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
