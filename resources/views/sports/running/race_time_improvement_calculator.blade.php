<x-calc.page
    title="Race Time Improvement Calculator - SolveKit"
    description="Free race time improvement calculator: the improvement needed for a goal time and how realistic it is."
    lede="Plan a race-time improvement."
    about="Compare your current and goal times as a percentage, per week of training."
    :calc="['engine' => 'sp-run', 'tool' => 'race_improvement', 'fields' => ['race', 'dist', 'now', 'goal', 'weeks'], 'unitFields' => ['dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How big a step is 25:00 to 23:30?', 'answer' => '6%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="race" label="Race distance" :options="['1500' => '1500 m', 'mile' => '1 mile', '3k' => '3 km', '5k' => '5 km', '8k' => '8 km', '10k' => '10 km', '15k' => '15 km', '10mi' => '10 miles', 'half' => 'Half marathon', 'marathon' => 'Marathon', 'custom' => 'Other distance']" selected="5k" />
        <div data-show-when="race:custom">
            <x-calc.field name="dist" label="Distance" value="7" placeholder="Distance">
                <label for="calc-dist-unit" class="sr-only">Distance unit</label>
                <select id="calc-dist-unit" name="dist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="now" label="Current time (h:mm:ss)" value="25:00" type="text" inputmode="text" />
        <x-calc.field name="goal" label="Goal time (h:mm:ss)" value="23:30" type="text" inputmode="text" />
        <x-calc.field name="weeks" label="Weeks of training" value="12" min="1" step="any" />
    </div>

    <x-calc.result label="Improvement needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['race' => '5k', 'dist' => 7, 'dist-unit' => 'km', 'now' => '25:00', 'goal' => '23:30', 'weeks' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pace' => ['label' => 'Pace change per km'],
            'perWeek' => ['label' => 'Per week'],
            'realism' => ['label' => 'How realistic'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
