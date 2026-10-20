<x-calc.page
    title="Cricket Batting Average Calculator - SolveKit"
    description="Free cricket batting average calculator: runs per dismissal, allowing for not-outs."
    lede="Find a batting average in cricket."
    about="A cricket batting average divides runs by the number of times out, so not-out innings help."
    :calc="['engine' => 'sp-ball', 'tool' => 'cricket_average', 'fields' => ['R', 'I', 'NO'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the average of 1,200 runs in 30 innings with 4 not outs?', 'answer' => '46.15.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Runs" value="1200" min="0" step="any" />
        <x-calc.field name="I" label="Innings" value="30" min="1" step="any" />
        <x-calc.field name="NO" label="Not outs" value="4" min="0" step="any" />
    </div>

    <x-calc.result label="Batting average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['R' => 1200, 'I' => 30, 'NO' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'outs' => ['label' => 'Dismissals'],
            'perInn' => ['label' => 'Runs per innings'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
