<x-calc.page
    title="Gravitational Time Dilation Calculator - SolveKit"
    description="Free gravitational time dilation calculator: how much faster a higher clock runs, for GPS and other examples."
    lede="Find gravitational time dilation."
    about="Clocks deeper in a gravitational well tick slower. A GPS satellite clock gains about 45.7 µs per day from gravity alone."
    :calc="['engine' => 'ph-astro', 'tool' => 'grav_time_dilation', 'fields' => ['body', 'M', 'R', 'h1', 'h2'], 'unitFields' => ['M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'R' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'h1' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'h2' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does a GPS clock gain per day from gravity?', 'answer' => '45.7241 µs.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="body" label="Body" :options="['sun' => 'Sun', 'mercury' => 'Mercury', 'venus' => 'Venus', 'earth' => 'Earth', 'moon' => 'Moon', 'mars' => 'Mars', 'ceres' => 'Ceres', 'jupiter' => 'Jupiter', 'io' => 'Io', 'europa' => 'Europa', 'ganymede' => 'Ganymede', 'saturn' => 'Saturn', 'titan' => 'Titan', 'uranus' => 'Uranus', 'neptune' => 'Neptune', 'pluto' => 'Pluto', 'custom' => 'Other (enter the value)']" selected="earth" />
        <div data-show-when="body:custom">
            <x-calc.field name="M" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-M-unit" class="sr-only">Mass unit</label>
                <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mearth')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="body:custom">
            <x-calc.field name="R" label="Radius" value="6371" min="0" placeholder="Radius">
                <label for="calc-R-unit" class="sr-only">Radius unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="h1" label="Lower clock height" value="0" min="0" placeholder="Lower clock height">
            <label for="calc-h1-unit" class="sr-only">Lower clock height unit</label>
            <select id="calc-h1-unit" name="h1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h2" label="Higher clock height" value="20200" min="0" placeholder="Higher clock height">
            <label for="calc-h2-unit" class="sr-only">Higher clock height unit</label>
            <select id="calc-h2-unit" name="h2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Higher clock gains per day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['body' => 'earth', 'M' => 1, 'M-unit' => 'mearth', 'R' => 6371, 'R-unit' => 'km', 'h1' => 0, 'h1-unit' => 'km', 'h2' => 20200, 'h2-unit' => 'km'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Rate ratio (higher ÷ lower)'],
            'year' => ['label' => 'Per year'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
