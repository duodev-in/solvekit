<x-calc.page
    title="Magnitude of Acceleration Calculator - SolveKit"
    description="Free magnitude of acceleration calculator: size and direction of an acceleration vector from its components."
    lede="Find the size of an acceleration vector."
    about="An acceleration with components aₓ, a_y and a_z has magnitude √(aₓ² + a_y² + a_z²). Phone accelerometers report exactly these components, so this is how total g-force is worked out."
    :calc="['engine' => 'ph-mech', 'tool' => 'accel_magnitude', 'fields' => ['ax', 'ay', 'az', 'out'], 'unitFields' => ['ax' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 'ay' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 'az' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the magnitude of (3, 4, 0) m/s²?', 'answer' => '5 m/s².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ax" label="aₓ" value="3" placeholder="aₓ">
            <label for="calc-ax-unit" class="sr-only">aₓ unit</label>
            <select id="calc-ax-unit" name="ax-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ay" label="a_y" value="4" placeholder="a_y">
            <label for="calc-ay-unit" class="sr-only">a_y unit</label>
            <select id="calc-ay-unit" name="ay-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="az" label="a_z" value="0" placeholder="a_z">
            <label for="calc-az-unit" class="sr-only">a_z unit</label>
            <select id="calc-az-unit" name="az-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
    </div>

    <x-calc.result label="Magnitude of acceleration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms2', 'ax' => 3, 'ax-unit' => 'ms2', 'ay' => 4, 'ay-unit' => 'ms2', 'az' => 0, 'az-unit' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g' => ['label' => 'In g'],
            'dir' => ['label' => 'Direction in the x–y plane'],
            'elev' => ['label' => 'Angle above the x–y plane'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
