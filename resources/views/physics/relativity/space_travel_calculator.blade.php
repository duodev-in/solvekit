<x-calc.page
    title="Space Travel Calculator - SolveKit"
    description="Free space travel calculator: ship time, Earth time and fuel for a constant-acceleration flip-and-burn trip."
    lede="Plan a relativistic trip."
    about="Accelerate at 1 g to the midpoint, flip, and decelerate. Proper time grows only logarithmically with distance, but the fuel needed grows exponentially."
    :calc="['engine' => 'ph-astro', 'tool' => 'space_travel', 'fields' => ['d', 'a', 've'], 'unitFields' => ['d' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'a' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 've' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 1 g trip to Proxima Centauri?', 'answer' => '3.54209 years on board.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d" label="Distance" value="4.2465" min="0" placeholder="Distance">
            <label for="calc-d-unit" class="sr-only">Distance unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ly')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="a" label="Acceleration (and deceleration)" value="1" placeholder="Acceleration (and deceleration)">
            <label for="calc-a-unit" class="sr-only">Acceleration (and deceleration) unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g0')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ve" label="Exhaust speed (for fuel)" value="1" placeholder="Exhaust speed (for fuel)">
            <label for="calc-ve-unit" class="sr-only">Exhaust speed (for fuel) unit</label>
            <select id="calc-ve-unit" name="ve-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Ship time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['d' => 4.2465, 'd-unit' => 'ly', 'a' => 1, 'a-unit' => 'g0', 've' => 1, 've-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'earth' => ['label' => 'Earth time'],
            'vmax' => ['label' => 'Top speed'],
            'ratio' => ['label' => 'Mass ratio needed (rocket equation)'],
            'fuel' => ['label' => 'Fuel per kilogram of payload'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
