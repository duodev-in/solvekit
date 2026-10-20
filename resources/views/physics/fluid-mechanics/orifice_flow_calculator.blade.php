<x-calc.page
    title="Orifice Flow Calculator - SolveKit"
    description="Free orifice flow calculator: flow through an orifice plate from diameters and pressure drop."
    lede="Find flow through an orifice."
    about="An orifice plate measures flow from the pressure drop it creates: Q = C_dA√(2ΔP/ρ(1 − β⁴))."
    :calc="['engine' => 'ph-fluid', 'tool' => 'orifice', 'fields' => ['d', 'D', 'dP', 'rho', 'Cd', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'flow', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What flows through a 25 mm orifice in a 50 mm pipe at 20 kPa?', 'answer' => '117.471 L/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d" label="Orifice diameter" value="25" placeholder="Orifice diameter">
            <label for="calc-d-unit" class="sr-only">Orifice diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D" label="Pipe diameter" value="50" placeholder="Pipe diameter">
            <label for="calc-D-unit" class="sr-only">Pipe diameter unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dP" label="Pressure difference" value="20" min="0" placeholder="Pressure difference">
            <label for="calc-dP-unit" class="sr-only">Pressure difference unit</label>
            <select id="calc-dP-unit" name="dP-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rho" label="Fluid density" value="998" min="0" placeholder="Fluid density">
            <label for="calc-rho-unit" class="sr-only">Fluid density unit</label>
            <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Cd" label="Discharge coefficient" value="0.61" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="lmin" />
    </div>

    <x-calc.result label="Flow rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'lmin', 'd' => 25, 'd-unit' => 'mm', 'D' => 50, 'D-unit' => 'mm', 'dP' => 20, 'dP-unit' => 'kpa', 'rho' => 998, 'rho-unit' => 'kgm3', 'Cd' => 0.61],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'beta' => ['label' => 'Diameter ratio β'],
            'v' => ['label' => 'Velocity in the orifice'],
            'm' => ['label' => 'Mass flow'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
