<x-calc.page
    title="Average Triathlon Finishing Time Calculator - SolveKit"
    description="Free triathlon finishing time calculator: your total from swim, bike and run paces and transitions."
    lede="Find your triathlon finishing time."
    about="Add the swim, both transitions, the bike and the run for sprint, Olympic, 70.3 or full distance."
    :calc="['engine' => 'sp-run', 'tool' => 'tri_time', 'fields' => ['dist', 'swim', 't1', 'bike', 't2', 'run'], 'unitFields' => ['bike' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does the example Olympic triathlon add up to?', 'answer' => '2:55:43.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dist" label="Distance" :options="['sprint' => 'Sprint (750 m, 20 km, 5 km)', 'olympic' => 'Olympic (1.5 km, 40 km, 10 km)', 'half' => '70.3 (1.9 km, 90 km, 21.1 km)', 'full' => 'Full (3.8 km, 180 km, 42.2 km)']" selected="olympic" />
        <x-calc.field name="swim" label="Swim pace per 100 m (m:ss)" value="2:00" type="text" inputmode="text" />
        <x-calc.field name="t1" label="T1 transition (m:ss)" value="3:00" type="text" inputmode="text" />
        <x-calc.field name="bike" label="Bike average speed" value="28" placeholder="Bike average speed">
            <label for="calc-bike-unit" class="sr-only">Bike average speed unit</label>
            <select id="calc-bike-unit" name="bike-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t2" label="T2 transition (m:ss)" value="2:00" type="text" inputmode="text" />
        <x-calc.field name="run" label="Run pace per km (m:ss)" value="5:30" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Finishing time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dist' => 'olympic', 'swim' => '2:00', 't1' => '3:00', 'bike' => 28, 'bike-unit' => 'kmh', 't2' => '2:00', 'run' => '5:30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'swim' => ['label' => 'Swim'],
            't1' => ['label' => 'T1'],
            'bike' => ['label' => 'Bike'],
            't2' => ['label' => 'T2'],
            'run' => ['label' => 'Run'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
