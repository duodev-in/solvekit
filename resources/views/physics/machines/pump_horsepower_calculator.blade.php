<x-calc.page
    title="Pump Horsepower Calculator - SolveKit"
    description="Free pump power calculator: hydraulic and shaft power from flow, head or pressure, specific gravity and efficiency."
    lede="Find the power a pump needs."
    about="Hydraulic power is ρgQH (or ΔP × Q); the motor must supply that divided by the pump efficiency."
    :calc="['engine' => 'ph-mach', 'tool' => 'pump_power', 'fields' => ['Q', 'mode', 'H', 'dP', 'sg', 'eff', 'out'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'H' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'power', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What power pumps 30 m³/h of water up 20 m at 70%?', 'answer' => '2.33485 kW.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q" label="Flow rate" value="30" min="0" placeholder="Flow rate">
            <label for="calc-Q-unit" class="sr-only">Flow rate unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm3h')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mode" label="Head given as" :options="['head' => 'Height (head)', 'pressure' => 'Pressure rise']" selected="head" />
        <div data-show-when="mode:head">
            <x-calc.field name="H" label="Total head" value="20" placeholder="Total head">
                <label for="calc-H-unit" class="sr-only">Total head unit</label>
                <select id="calc-H-unit" name="H-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:pressure">
            <x-calc.field name="dP" label="Pressure rise" value="2" min="0" placeholder="Pressure rise">
                <label for="calc-dP-unit" class="sr-only">Pressure rise unit</label>
                <select id="calc-dP-unit" name="dP-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'bar')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="sg" label="Specific gravity" value="1" min="0" step="any" />
        <x-calc.field name="eff" label="Pump efficiency (%)" value="70" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="kw" />
    </div>

    <x-calc.result label="Shaft power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kw', 'Q' => 30, 'Q-unit' => 'm3h', 'mode' => 'head', 'H' => 20, 'H-unit' => 'm', 'dP' => 2, 'dP-unit' => 'bar', 'sg' => 1, 'eff' => 70],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'hyd' => ['label' => 'Hydraulic power'],
            'motor' => ['label' => 'Motor with a 15% margin'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
