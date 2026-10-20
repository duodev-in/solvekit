<x-calc.page
    title="Triathlon Training Calculator - SolveKit"
    description="Free triathlon training calculator: weekly hours by sport, training phases and taper."
    lede="Split your training time."
    about="A general guide to dividing training time between swim, bike and run, with base, build and taper phases."
    :calc="['engine' => 'sp-run', 'tool' => 'tri_training', 'fields' => ['dist', 'hours', 'weeks'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How should 8 hours a week be split for an Olympic race?', 'answer' => '1.8 / 3.6 / 2.6 h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dist" label="Race" :options="['sprint' => 'Sprint', 'olympic' => 'Olympic', 'half' => '70.3', 'full' => 'Full distance']" selected="olympic" />
        <x-calc.field name="hours" label="Hours a week you can train" value="8" min="1" step="any" />
        <x-calc.field name="weeks" label="Weeks until the race" value="16" min="4" step="any" />
    </div>

    <x-calc.result label="Weekly split at peak" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dist' => 'olympic', 'hours' => 8, 'weeks' => 16],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'swim' => ['label' => 'Swim'],
            'bike' => ['label' => 'Bike'],
            'run' => ['label' => 'Run'],
            'phases' => ['label' => 'Phases'],
            'taper' => ['label' => 'Taper'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
