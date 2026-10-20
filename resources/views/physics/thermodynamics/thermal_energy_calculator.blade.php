<x-calc.page
    title="Thermal Energy Calculator - SolveKit"
    description="Free thermal energy calculator: Q = mcΔT, solved for any value."
    lede="Solve Q = mcΔT."
    about="Heating a mass needs its specific heat times the temperature rise. Water’s high specific heat makes it slow to heat and cool."
    :calc="['engine' => 'ph-thermo', 'tool' => 'thermal_energy', 'fields' => ['solve', 'Q', 'm', 'c', 'dT', 'out_Q', 'out_m', 'out_c', 'out_dT'], 'unitFields' => ['Q' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'c' => collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['Q', 'energy', 'force', 'length', 'mass', 'specific_heat', 'speed', 'temperature_difference'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What heat raises 1 kg of water by 80 K?', 'answer' => '334.56 kJ.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Q' => 'Heat energy', 'm' => 'Mass', 'c' => 'Specific heat', 'dT' => 'Temperature change']" selected="Q" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m,c,dT" hidden>
            <x-calc.field name="Q" label="Heat energy" value="334.56" placeholder="Heat energy">
                <label for="calc-Q-unit" class="sr-only">Heat energy unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kj')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,c,dT">
            <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,m,dT">
            <x-calc.field name="c" label="Specific heat" value="4182" min="0" placeholder="Specific heat">
                <label for="calc-c-unit" class="sr-only">Specific heat unit</label>
                <select id="calc-c-unit" name="c-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'jkgk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,m,c">
            <x-calc.field name="dT" label="Temperature change" value="80" placeholder="Temperature change">
                <label for="calc-dT-unit" class="sr-only">Temperature change unit</label>
                <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q">
            <x-calc.select name="out_Q" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="kj" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:c" hidden>
            <x-calc.select name="out_c" label="Show the result in" :options="['jkgk' => 'J/(kg·K)', 'kjkgk' => 'kJ/(kg·K)', 'jgk' => 'J/(g·K)', 'calgc' => 'cal/(g·°C)', 'btulbf' => 'BTU/(lb·°F)']" selected="jkgk" />
        </div>
        <div data-show-when="solve:dT" hidden>
            <x-calc.select name="out_dT" label="Show the result in" :options="['k' => 'K', 'c' => '°C', 'f' => '°F', 'r' => '°R']" selected="k" />
        </div>
    </div>

    <x-calc.result label="Heat energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Q', 'Q' => 334.56, 'Q-unit' => 'kj', 'out_Q' => 'kj', 'm' => 1, 'm-unit' => 'kg', 'out_m' => 'kg', 'c' => 4182, 'c-unit' => 'jkgk', 'out_c' => 'jkgk', 'dT' => 80, 'dT-unit' => 'k', 'out_dT' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'kwh' => ['label' => 'In kWh'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = m c ΔT</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
