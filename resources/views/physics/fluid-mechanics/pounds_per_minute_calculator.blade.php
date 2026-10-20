<x-calc.page
    title="Pounds per Minute Calculator - SolveKit"
    description="Free pounds per minute calculator: air mass flow from CFM, pressure and temperature."
    lede="Convert CFM to lb/min."
    about="Mass flow is volumetric flow times density, and gas density depends on pressure and temperature."
    :calc="['engine' => 'ph-fluid', 'tool' => 'lb_per_min', 'fields' => ['Q', 'P', 'T', 'M', 'out'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'flow', 'force', 'length', 'mass', 'mass_flow', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 500 CFM of air at standard conditions?', 'answer' => '37.4429 lb/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q" label="Air flow (actual)" value="500" min="0" placeholder="Air flow (actual)">
            <label for="calc-Q-unit" class="sr-only">Air flow (actual) unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cfm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="P" label="Absolute pressure" value="14.696" min="0" placeholder="Absolute pressure">
            <label for="calc-P-unit" class="sr-only">Absolute pressure unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="70" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="M" label="Molar mass (g/mol)" value="28.9647" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['kgs' => 'kg/s', 'gs' => 'g/s', 'kgmin' => 'kg/min', 'kgh' => 'kg/h', 'lbs' => 'lb/s', 'lbmin' => 'lb/min', 'lbh' => 'lb/h']" selected="lbmin" />
    </div>

    <x-calc.result label="Mass flow" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'lbmin', 'Q' => 500, 'Q-unit' => 'cfm', 'P' => 14.696, 'P-unit' => 'psi', 'T' => 70, 'T-unit' => 'f', 'M' => 28.9647],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rho' => ['label' => 'Gas density'],
            'kgh' => ['label' => 'In kg/h'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
