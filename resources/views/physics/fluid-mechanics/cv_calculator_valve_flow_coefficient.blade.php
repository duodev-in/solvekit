<x-calc.page
    title="Cv Calculator — Valve Flow Coefficient - SolveKit"
    description="Free valve Cv calculator: the Cv (and Kv) a valve needs for a flow and pressure drop."
    lede="Find the Cv a valve needs."
    about="Choose a control valve whose Cv suits the flow at a reasonable pressure drop: Cv = Q√(SG/ΔP)."
    :calc="['engine' => 'ph-fluid', 'tool' => 'cv_required', 'fields' => ['Q', 'dP', 'sg'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What Cv passes 20 gpm at 10 psi?', 'answer' => '6.3246.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q" label="Flow rate" value="20" min="0" placeholder="Flow rate">
            <label for="calc-Q-unit" class="sr-only">Flow rate unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gpm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dP" label="Allowed pressure drop" value="10" min="0" placeholder="Allowed pressure drop">
            <label for="calc-dP-unit" class="sr-only">Allowed pressure drop unit</label>
            <select id="calc-dP-unit" name="dP-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sg" label="Specific gravity" value="1" min="0" step="any" />
    </div>

    <x-calc.result label="Required valve Cv" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Q' => 20, 'Q-unit' => 'gpm', 'dP' => 10, 'dP-unit' => 'psi', 'sg' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kv' => ['label' => 'Metric Kv'],
            'pick' => ['label' => 'Choose a valve with'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
