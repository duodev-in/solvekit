<x-calc.page
    title="RPE Calculator - SolveKit"
    description="Free RPE calculator: estimated 1RM from a set at a rated effort, and loads for other reps and RPEs."
    lede="Use RPE to set loads."
    about="Rate of perceived exertion counts reps in reserve: RPE 8 means two more reps were possible. The RPE chart turns that into a percentage of 1RM."
    :calc="['engine' => 'sp-misc', 'tool' => 'rpe', 'fields' => ['w', 'r', 'rpe', 'unit'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What 1RM does 140 kg × 5 at RPE 8 suggest?', 'answer' => '172.6 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Weight lifted" value="140" min="1" step="any" />
        <x-calc.field name="r" label="Reps" value="5" min="1" step="any" />
        <x-calc.select name="rpe" label="RPE" :options="['7' => '7 (three reps left)', '8' => '8 (two reps left)', '9' => '9 (one rep left)', '10' => '10 (no reps left)', '9.5' => '9.5', '8.5' => '8.5', '7.5' => '7.5', '6.5' => '6.5']" selected="8" />
        <x-calc.select name="unit" label="Weights in" :options="['kg' => 'kg', 'lb' => 'lb']" selected="kg" />
    </div>

    <x-calc.result label="Estimated 1RM" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 140, 'r' => 5, 'rpe' => '8', 'unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pct' => ['label' => 'That set as % of 1RM'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Loads for other reps and RPE" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
