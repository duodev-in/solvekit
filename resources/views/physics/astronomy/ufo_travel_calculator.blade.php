<x-calc.page
    title="UFO Travel Calculator - SolveKit"
    description="Free interstellar travel calculator: trip time to nearby stars for travellers and for Earth, at constant speed or constant acceleration."
    lede="Plan a trip to the stars."
    about="Moving clocks run slow, so near light speed the crew ages less than people at home. At a steady 1 g with a mid-way flip, the galactic centre is about 20 years away for the crew."
    :calc="['engine' => 'ph-astro', 'tool' => 'ufo_travel', 'fields' => ['dest', 'd', 'mode', 'v', 'a'], 'unitFields' => ['d' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'a' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long is a trip to Proxima Centauri at 0.5c?', 'answer' => '7.35515 years on board; Earth sees 8.493 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dest" label="Destination" :options="['proxima' => 'Proxima Centauri (4.2465 ly)', 'barnard' => 'Barnard’s Star (5.96 ly)', 'sirius' => 'Sirius (8.6 ly)', 'trappist' => 'TRAPPIST-1 (40.7 ly)', 'vega' => 'Vega (25 ly)', 'centre' => 'Galactic centre (26,670 ly)', 'andromeda' => 'Andromeda Galaxy (2.5 million ly)', 'custom' => 'Other distance']" selected="proxima" />
        <div data-show-when="dest:custom">
            <x-calc.field name="d" label="Distance" value="10" min="0" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ly')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="mode" label="Travel" :options="['speed' => 'At a constant speed', 'accel' => 'Accelerate, flip, decelerate']" selected="speed" />
        <div data-show-when="mode:speed">
            <x-calc.field name="v" label="Cruise speed" value="0.5" placeholder="Cruise speed">
                <label for="calc-v-unit" class="sr-only">Cruise speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:accel">
            <x-calc.field name="a" label="Acceleration" value="1" placeholder="Acceleration">
                <label for="calc-a-unit" class="sr-only">Acceleration unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'g0')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Time on board" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dest' => 'proxima', 'd' => 10, 'd-unit' => 'ly', 'mode' => 'speed', 'v' => 0.5, 'v-unit' => 'c', 'a' => 1, 'a-unit' => 'g0'],
        '1 g to the galactic centre' => ['dest' => 'centre', 'd' => 10, 'd-unit' => 'ly', 'mode' => 'accel', 'v' => 0.5, 'v-unit' => 'c', 'a' => 1, 'a-unit' => 'g0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'earth' => ['label' => 'Time on Earth'],
            'vmax' => ['label' => 'Top speed'],
            'gamma' => ['label' => 'Top Lorentz factor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
