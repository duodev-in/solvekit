<x-calc.page
    title="Fan Calculator - SolveKit"
    description="Free fan calculator: fan shaft power and the fan affinity laws for a speed change."
    lede="Find fan power and speed effects."
    about="Fan power is flow × pressure ÷ efficiency. Changing speed changes flow linearly, pressure with the square and power with the cube."
    :calc="['engine' => 'ph-fluid', 'tool' => 'fan', 'fields' => ['Q', 'dp', 'eff', 'n1', 'n2', 'out'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'dp' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'power', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What power does 3,000 m³/h at 400 Pa need?', 'answer' => '555.556 W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q" label="Air flow" value="3000" min="0" placeholder="Air flow">
            <label for="calc-Q-unit" class="sr-only">Air flow unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm3h')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dp" label="Fan pressure rise" value="400" min="0" placeholder="Fan pressure rise">
            <label for="calc-dp-unit" class="sr-only">Fan pressure rise unit</label>
            <select id="calc-dp-unit" name="dp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'pa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="eff" label="Fan efficiency (%)" value="60" min="0" step="any" />
        <x-calc.field name="n1" label="Current speed (rpm, for affinity laws)" value="1450" min="0" step="any" />
        <x-calc.field name="n2" label="New speed (rpm)" value="1200" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="w" />
    </div>

    <x-calc.result label="Shaft power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'w', 'Q' => 3000, 'Q-unit' => 'm3h', 'dp' => 400, 'dp-unit' => 'pa', 'eff' => 60, 'n1' => 1450, 'n2' => 1200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'air' => ['label' => 'Air power'],
            'Q2' => ['label' => 'Flow at the new speed'],
            'p2' => ['label' => 'Pressure at the new speed'],
            'P2' => ['label' => 'Power at the new speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
