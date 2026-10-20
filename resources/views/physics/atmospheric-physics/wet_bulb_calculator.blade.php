<x-calc.page
    title="Wet Bulb Calculator - SolveKit"
    description="Free wet-bulb temperature calculator: wet bulb from temperature and humidity, with heat-stress guidance."
    lede="Find the wet-bulb temperature."
    about="The wet-bulb temperature is the lowest temperature evaporative cooling can reach. Above about 31–35 °C people cannot cool themselves."
    :calc="['engine' => 'ph-thermo', 'tool' => 'wet_bulb', 'fields' => ['T', 'rh', 'p', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'p' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the wet bulb at 30 °C and 50%?', 'answer' => '22.005 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Air temperature" value="30" placeholder="Air temperature">
            <label for="calc-T-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rh" label="Relative humidity (%)" value="50" min="0" step="any" />
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

    <x-calc.result label="Wet-bulb temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'T' => 30, 'T-unit' => 'c', 'rh' => 50, 'p' => 101.325, 'p-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'stull' => ['label' => 'Stull (2011) formula for comparison'],
            'depression' => ['label' => 'Wet-bulb depression'],
            'risk' => ['label' => 'Heat stress'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
