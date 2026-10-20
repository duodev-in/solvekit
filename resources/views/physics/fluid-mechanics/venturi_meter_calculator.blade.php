<x-calc.page
    title="Venturi Meter Calculator - SolveKit"
    description="Free venturi meter calculator: flow rate from inlet and throat diameters and pressure difference."
    lede="Find flow through a venturi."
    about="A venturi narrows smoothly, so the pressure drop at the throat measures the flow with little permanent loss."
    :calc="['engine' => 'ph-fluid', 'tool' => 'venturi', 'fields' => ['D1', 'D2', 'dP', 'rho', 'Cd', 'out'], 'unitFields' => ['D1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'flow', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What flows through a 100/50 mm venturi at 15 kPa?', 'answer' => '653.758 L/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="D1" label="Inlet diameter" value="100" placeholder="Inlet diameter">
            <label for="calc-D1-unit" class="sr-only">Inlet diameter unit</label>
            <select id="calc-D1-unit" name="D1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D2" label="Throat diameter" value="50" placeholder="Throat diameter">
            <label for="calc-D2-unit" class="sr-only">Throat diameter unit</label>
            <select id="calc-D2-unit" name="D2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dP" label="Pressure difference" value="15" min="0" placeholder="Pressure difference">
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
        <x-calc.field name="Cd" label="Discharge coefficient" value="0.98" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="lmin" />
    </div>

    <x-calc.result label="Flow rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'lmin', 'D1' => 100, 'D1-unit' => 'mm', 'D2' => 50, 'D2-unit' => 'mm', 'dP' => 15, 'dP-unit' => 'kpa', 'rho' => 998, 'rho-unit' => 'kgm3', 'Cd' => 0.98],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v1' => ['label' => 'Inlet velocity'],
            'v2' => ['label' => 'Throat velocity'],
            'beta' => ['label' => 'Diameter ratio β'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
