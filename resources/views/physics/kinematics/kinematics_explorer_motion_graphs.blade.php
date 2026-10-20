<x-calc.page
    title="Kinematics Explorer: Motion Graphs - SolveKit"
    description="Free motion graph calculator: build a journey from segments of constant acceleration and see its velocity–time and position–time graphs."
    lede="Draw velocity and position graphs."
    about="Describe a journey as segments of constant acceleration. The velocity graph is made of straight lines, the area under it is the displacement, and the position graph curves wherever the acceleration is not zero."
    :calc="['engine' => 'ph-mech', 'tool' => 'motion_graphs', 'fields' => ['u', 'segments', 'out'], 'unitFields' => ['u' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Where does the default journey end?', 'answer' => 'At 145 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="u" label="Initial velocity" value="0" placeholder="Initial velocity">
            <label for="calc-u-unit" class="sr-only">Initial velocity unit</label>
            <select id="calc-u-unit" name="u-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.textarea name="segments" label="Segments: duration (s), acceleration (m/s²) per line" value="5, 2
10, 0
4, -2.5" rows="3" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Final displacement" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'u' => 0, 'u-unit' => 'ms', 'segments' => '5, 2
10, 0
4, -2.5'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Position–time graph" name="position" />
        <x-calc.plot heading="Velocity–time graph" name="velocity" />
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Final velocity'],
            'dist' => ['label' => 'Distance travelled'],
            'time' => ['label' => 'Total time'],
            'vmax' => ['label' => 'Top speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
