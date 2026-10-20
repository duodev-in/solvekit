<x-calc.page
    title="Enthalpy Calculator - SolveKit"
    description="Free enthalpy calculator: H = U + PV, or ΔH = mc_pΔT at constant pressure."
    lede="Find enthalpy."
    about="Enthalpy is internal energy plus flow work. At constant pressure its change is the heat added."
    :calc="['engine' => 'ph-thermo', 'tool' => 'enthalpy', 'fields' => ['mode', 'U', 'P', 'V', 'm', 'cp', 'dT', 'out'], 'unitFields' => ['U' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'cp' => collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'specific_heat', 'speed', 'temperature_difference', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is ΔH for heating 2 kg of water by 30 K?', 'answer' => '250.92 kJ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['upv' => 'H = U + PV', 'cp' => 'ΔH = m c_p ΔT (constant pressure)']" selected="cp" />
        <div data-show-when="mode:upv">
            <x-calc.field name="U" label="Internal energy" value="100" placeholder="Internal energy">
                <label for="calc-U-unit" class="sr-only">Internal energy unit</label>
                <select id="calc-U-unit" name="U-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kj')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:upv">
            <x-calc.field name="P" label="Pressure" value="101.325" min="0" placeholder="Pressure">
                <label for="calc-P-unit" class="sr-only">Pressure unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:upv">
            <x-calc.field name="V" label="Volume" value="50" min="0" placeholder="Volume">
                <label for="calc-V-unit" class="sr-only">Volume unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:cp">
            <x-calc.field name="m" label="Mass" value="2" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:cp">
            <x-calc.field name="cp" label="Specific heat c_p" value="4182" min="0" placeholder="Specific heat c_p">
                <label for="calc-cp-unit" class="sr-only">Specific heat c_p unit</label>
                <select id="calc-cp-unit" name="cp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'jkgk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:cp">
            <x-calc.field name="dT" label="Temperature change" value="30" placeholder="Temperature change">
                <label for="calc-dT-unit" class="sr-only">Temperature change unit</label>
                <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="kj" />
    </div>

    <x-calc.result label="Enthalpy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kj', 'mode' => 'cp', 'U' => 100, 'U-unit' => 'kj', 'P' => 101.325, 'P-unit' => 'kpa', 'V' => 50, 'V-unit' => 'l', 'm' => 2, 'm-unit' => 'kg', 'cp' => 4182, 'cp-unit' => 'jkgk', 'dT' => 30, 'dT-unit' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pv' => ['label' => 'Flow work PV'],
            'kwh' => ['label' => 'In kWh'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
