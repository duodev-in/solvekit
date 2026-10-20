<x-calc.page
    title="Adiabatic Process Calculator - SolveKit"
    description="Free adiabatic process calculator: final pressure, volume and temperature with PV^γ = constant."
    lede="Solve an adiabatic process."
    about="Compressing a gas quickly, with no time to lose heat, raises its temperature sharply: a diesel engine ignites its fuel this way."
    :calc="['engine' => 'ph-thermo', 'tool' => 'adiabatic', 'fields' => ['P1', 'V1', 'T1', 'gamma', 'know', 'V2', 'P2', 'out'], 'unitFields' => ['P1' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'V1' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'V2' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'P2' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What temperature does air reach compressed 10:1?', 'answer' => '463.21 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P1" label="Initial pressure" value="100" min="0" placeholder="Initial pressure">
            <label for="calc-P1-unit" class="sr-only">Initial pressure unit</label>
            <select id="calc-P1-unit" name="P1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V1" label="Initial volume" value="1" min="0" placeholder="Initial volume">
            <label for="calc-V1-unit" class="sr-only">Initial volume unit</label>
            <select id="calc-V1-unit" name="V1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T1" label="Initial temperature" value="20" placeholder="Initial temperature">
            <label for="calc-T1-unit" class="sr-only">Initial temperature unit</label>
            <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gamma" label="γ (1.4 for air)" value="1.4" min="1" step="any" />
        <x-calc.select name="know" label="Final state given by" :options="['V' => 'Final volume', 'P' => 'Final pressure']" selected="V" />
        <div data-show-when="know:V">
            <x-calc.field name="V2" label="Final volume" value="0.1" min="0" placeholder="Final volume">
                <label for="calc-V2-unit" class="sr-only">Final volume unit</label>
                <select id="calc-V2-unit" name="V2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="know:P">
            <x-calc.field name="P2" label="Final pressure" value="2512" min="0" placeholder="Final pressure">
                <label for="calc-P2-unit" class="sr-only">Final pressure unit</label>
                <select id="calc-P2-unit" name="P2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Final temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'P1' => 100, 'P1-unit' => 'kpa', 'V1' => 1, 'V1-unit' => 'l', 'T1' => 20, 'T1-unit' => 'c', 'gamma' => 1.4, 'know' => 'V', 'V2' => 0.1, 'V2-unit' => 'l', 'P2' => 2512, 'P2-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'P2' => ['label' => 'Final pressure'],
            'V2' => ['label' => 'Final volume'],
            'W' => ['label' => 'Work done on the gas'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
