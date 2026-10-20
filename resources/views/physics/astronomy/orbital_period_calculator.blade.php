<x-calc.page
    title="Orbital Period Calculator - SolveKit"
    description="Free orbital period calculator: period from orbit size and central mass, or from the density of the body for a grazing orbit."
    lede="Find an orbital period."
    about="The period depends only on the semi-major axis and the central mass. For an orbit skimming the surface it depends only on the body’s density: about 85 minutes for Earth."
    :calc="['engine' => 'ph-astro', 'tool' => 'orbital_period', 'fields' => ['mode', 'a', 'M', 'rho', 'out'], 'unitFields' => ['a' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'astronomical', 'density', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Moon’s orbital period from 384,400 km?', 'answer' => '27.4518 d.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Know" :options="['mass' => 'Semi-major axis and central mass', 'density' => 'Central body density (grazing orbit)']" selected="mass" />
        <div data-show-when="mode:mass">
            <x-calc.field name="a" label="Semi-major axis" value="384400" min="0" placeholder="Semi-major axis">
                <label for="calc-a-unit" class="sr-only">Semi-major axis unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:mass">
            <x-calc.field name="M" label="Central mass" value="1" min="0" placeholder="Central mass">
                <label for="calc-M-unit" class="sr-only">Central mass unit</label>
                <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mearth')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:density">
            <x-calc.field name="rho" label="Mean density" value="5.51" min="0" placeholder="Mean density">
                <label for="calc-rho-unit" class="sr-only">Mean density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="day" />
    </div>

    <x-calc.result label="Orbital period" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'day', 'mode' => 'mass', 'a' => 384400, 'a-unit' => 'km', 'M' => 1, 'M-unit' => 'mearth', 'rho' => 5.51, 'rho-unit' => 'gcm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'human' => ['label' => 'Readable'],
            'v' => ['label' => 'Mean orbital speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
