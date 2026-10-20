<x-calc.page
    title="Virtual Temperature Calculator - SolveKit"
    description="Free virtual temperature calculator: temperature dry air would need to match the density of moist air."
    lede="Find virtual temperature."
    about="Humid air is lighter than dry air at the same temperature. The virtual temperature folds that into the temperature for density and buoyancy calculations."
    :calc="['engine' => 'ph-thermo', 'tool' => 'virtual_temperature', 'fields' => ['T', 'by', 'rh', 'Td', 'Tw', 'p', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Td' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tw' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'p' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is T_v at 25 °C and 50%?', 'answer' => '26.7733 °C.'],
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
            <x-calc.field name="rh" label="Relative humidity (%)" value="50" min="0" step="any" />
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
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Virtual temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'T' => 25, 'T-unit' => 'c', 'by' => 'rh', 'rh' => 50, 'Td' => 13.9, 'Td-unit' => 'c', 'Tw' => 17.9, 'Tw-unit' => 'c', 'p' => 101.325, 'p-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'approx' => ['label' => 'Approximation T(1 + 0.61w)'],
            'diff' => ['label' => 'Warmer than the actual temperature by'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
