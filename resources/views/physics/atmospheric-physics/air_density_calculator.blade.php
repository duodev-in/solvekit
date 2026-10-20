<x-calc.page
    title="Air Density Calculator - SolveKit"
    description="Free air density calculator: density of dry or humid air from pressure, temperature and humidity."
    lede="Find air density."
    about="Air density falls with altitude and temperature. Humid air is lighter than dry air because water molecules are lighter than nitrogen and oxygen."
    :calc="['engine' => 'ph-thermo', 'tool' => 'air_density', 'fields' => ['T', 'by', 'rh', 'Td', 'Tw', 'p', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Td' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tw' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'p' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the density of dry air at 25 °C and 1 atm?', 'answer' => '1.18389 kg/m³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Air temperature" value="25" placeholder="Air temperature">
            <label for="calc-T-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="by" label="Humidity given as" :options="['rh' => 'Relative humidity', 'dew' => 'Dew point', 'wet' => 'Wet-bulb temperature']" selected="rh" />
        <div data-show-when="by:rh">
            <x-calc.field name="rh" label="Relative humidity (%)" value="0" min="0" step="any" />
        </div>
        <div data-show-when="by:dew">
            <x-calc.field name="Td" label="Dew point" value="13.9" placeholder="Dew point">
                <label for="calc-Td-unit" class="sr-only">Dew point unit</label>
                <select id="calc-Td-unit" name="Td-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:wet">
            <x-calc.field name="Tw" label="Wet-bulb temperature" value="17.9" placeholder="Wet-bulb temperature">
                <label for="calc-Tw-unit" class="sr-only">Wet-bulb temperature unit</label>
                <select id="calc-Tw-unit" name="Tw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="p" label="Air pressure" value="101.325" min="0" placeholder="Air pressure">
            <label for="calc-p-unit" class="sr-only">Air pressure unit</label>
            <select id="calc-p-unit" name="p-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
    </div>

    <x-calc.result label="Air density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kgm3', 'T' => 25, 'T-unit' => 'c', 'by' => 'rh', 'rh' => 0, 'Td' => 13.9, 'Td-unit' => 'c', 'Tw' => 17.9, 'Tw-unit' => 'c', 'p' => 101.325, 'p-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dry' => ['label' => 'Dry air at the same pressure and temperature'],
            'std' => ['label' => 'Compared with the standard 1.225 kg/m³'],
            'Tv' => ['label' => 'Virtual temperature'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
