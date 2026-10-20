<x-calc.page
    title="Density Altitude Calculator - SolveKit"
    description="Free density altitude calculator: the altitude an aircraft performs as if at, from elevation, pressure, temperature and dew point."
    lede="Find density altitude."
    about="Hot, high and humid air is thin. Density altitude is the standard-atmosphere altitude with the same density, and it decides take-off and climb performance."
    :calc="['engine' => 'ph-thermo', 'tool' => 'density_altitude', 'fields' => ['elev', 'alt', 'T', 'Td', 'out'], 'unitFields' => ['elev' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'alt' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Td' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the density altitude at 5,000 ft and 30 °C?', 'answer' => '7,980.28 ft.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="elev" label="Field elevation" value="5000" placeholder="Field elevation">
            <label for="calc-elev-unit" class="sr-only">Field elevation unit</label>
            <select id="calc-elev-unit" name="elev-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="alt" label="Altimeter setting" value="29.92" min="0" placeholder="Altimeter setting">
            <label for="calc-alt-unit" class="sr-only">Altimeter setting unit</label>
            <select id="calc-alt-unit" name="alt-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'inhg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Outside air temperature" value="30" placeholder="Outside air temperature">
            <label for="calc-T-unit" class="sr-only">Outside air temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Td" label="Dew point" value="10" placeholder="Dew point">
            <label for="calc-Td-unit" class="sr-only">Dew point unit</label>
            <select id="calc-Td-unit" name="Td-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="ft" />
    </div>

    <x-calc.result label="Density altitude" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ft', 'elev' => 5000, 'elev-unit' => 'ft', 'alt' => 29.92, 'alt-unit' => 'inhg', 'T' => 30, 'T-unit' => 'c', 'Td' => 10, 'Td-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pa' => ['label' => 'Pressure altitude'],
            'station' => ['label' => 'Station pressure'],
            'rho' => ['label' => 'Air density'],
            'perf' => ['label' => 'Performance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
