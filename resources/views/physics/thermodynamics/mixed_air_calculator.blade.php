<x-calc.page
    title="Mixed Air Calculator - SolveKit"
    description="Free mixed air calculator: temperature and humidity of two mixed air streams by mass and energy balance."
    lede="Mix two air streams."
    about="Mixing two air streams conserves dry air, water and energy. The result lies on a straight line between them on the psychrometric chart."
    :calc="['engine' => 'ph-thermo', 'tool' => 'mixed_air', 'fields' => ['Q1', 'T1', 'rh1', 'Q2', 'T2', 'rh2', 'p', 'out'], 'unitFields' => ['Q1' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Q2' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'T2' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'p' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the mix of the example streams?', 'answer' => '23.9628 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q1" label="Stream 1 flow" value="1000" min="0" placeholder="Stream 1 flow">
            <label for="calc-Q1-unit" class="sr-only">Stream 1 flow unit</label>
            <select id="calc-Q1-unit" name="Q1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm3h')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T1" label="Stream 1 temperature" value="30" placeholder="Stream 1 temperature">
            <label for="calc-T1-unit" class="sr-only">Stream 1 temperature unit</label>
            <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rh1" label="Stream 1 relative humidity (%)" value="60" min="0" step="any" />
        <x-calc.field name="Q2" label="Stream 2 flow" value="3000" min="0" placeholder="Stream 2 flow">
            <label for="calc-Q2-unit" class="sr-only">Stream 2 flow unit</label>
            <select id="calc-Q2-unit" name="Q2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm3h')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T2" label="Stream 2 temperature" value="22" placeholder="Stream 2 temperature">
            <label for="calc-T2-unit" class="sr-only">Stream 2 temperature unit</label>
            <select id="calc-T2-unit" name="T2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rh2" label="Stream 2 relative humidity (%)" value="50" min="0" step="any" />
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

    <x-calc.result label="Mixed air temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'Q1' => 1000, 'Q1-unit' => 'm3h', 'T1' => 30, 'T1-unit' => 'c', 'rh1' => 60, 'Q2' => 3000, 'Q2-unit' => 'm3h', 'T2' => 22, 'T2-unit' => 'c', 'rh2' => 50, 'p' => 101.325, 'p-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rh' => ['label' => 'Mixed relative humidity'],
            'W' => ['label' => 'Humidity ratio'],
            'h' => ['label' => 'Enthalpy'],
            'dew' => ['label' => 'Dew point'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
