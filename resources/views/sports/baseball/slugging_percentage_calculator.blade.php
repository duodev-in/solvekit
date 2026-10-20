<x-calc.page
    title="Slugging Percentage Calculator - SolveKit"
    description="Free slugging percentage calculator: SLG from singles, doubles, triples and home runs, with isolated power."
    lede="Find slugging percentage."
    about="Slugging percentage is total bases per at-bat: a single counts one base and a home run four."
    :calc="['engine' => 'sp-ball', 'tool' => 'slugging', 'fields' => ['s1', 's2', 's3', 'HR', 'AB'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the SLG of the example line?', 'answer' => '.489.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="s1" label="Singles" value="100" min="0" step="any" />
        <x-calc.field name="s2" label="Doubles" value="30" min="0" step="any" />
        <x-calc.field name="s3" label="Triples" value="3" min="0" step="any" />
        <x-calc.field name="HR" label="Home runs" value="25" min="0" step="any" />
        <x-calc.field name="AB" label="At-bats" value="550" min="1" step="any" />
    </div>

    <x-calc.result label="Slugging percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['s1' => 100, 's2' => 30, 's3' => 3, 'HR' => 25, 'AB' => 550],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tb' => ['label' => 'Total bases'],
            'iso' => ['label' => 'Isolated power (SLG − AVG)'],
            'avg' => ['label' => 'Batting average'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
