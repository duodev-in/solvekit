<x-calc.page
    title="Sensible Heat Calculator - SolveKit"
    description="Free sensible heat calculator: heat added to or removed from an air stream by a temperature change."
    lede="Find sensible heat in air."
    about="Sensible heat changes temperature without changing moisture: Q = ρc_pV̇ΔT, or 1.08 × CFM × ΔT°F in imperial units."
    :calc="['engine' => 'ph-thermo', 'tool' => 'sensible_heat', 'fields' => ['Q', 'dT', 'out'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'power', 'speed', 'temperature_difference'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 1,000 CFM cooled by 20 °F?', 'answer' => '21,672.2 BTU/h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q" label="Air flow" value="1000" min="0" placeholder="Air flow">
            <label for="calc-Q-unit" class="sr-only">Air flow unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cfm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dT" label="Temperature difference" value="20" placeholder="Temperature difference">
            <label for="calc-dT-unit" class="sr-only">Temperature difference unit</label>
            <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="btuh" />
    </div>

    <x-calc.result label="Sensible heat" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'btuh', 'Q' => 1000, 'Q-unit' => 'cfm', 'dT' => 20, 'dT-unit' => 'f'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kw' => ['label' => 'In kW'],
            'rule' => ['label' => 'Imperial rule 1.08 × CFM × ΔT'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
