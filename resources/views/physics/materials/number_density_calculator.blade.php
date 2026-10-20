<x-calc.page
    title="Number Density Calculator - SolveKit"
    description="Free number density calculator: particles per cubic metre of a gas from P and T, or of a solid from density and molar mass."
    lede="Find particles per unit volume."
    about="Number density counts particles per volume. For an ideal gas n = P/kT; for a solid or liquid n = ρNₐ/M. Air at 0 °C and 1 atm holds the Loschmidt number, 2.687 × 10²⁵ m⁻³."
    :calc="['engine' => 'ph-mat', 'tool' => 'number_density', 'fields' => ['mode', 'rho', 'M', 'P', 'T'], 'unitFields' => ['rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many molecules per m³ in a gas at 0 °C and 1 atm?', 'answer' => '2.68678 × 10²⁵ m⁻³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Substance" :options="['solid' => 'Solid or liquid (density and molar mass)', 'gas' => 'Ideal gas (pressure and temperature)']" selected="gas" />
        <div data-show-when="mode:solid">
            <x-calc.field name="rho" label="Density" value="8.96" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:solid">
            <x-calc.field name="M" label="Molar mass (g/mol)" value="63.546" min="0" step="any" />
        </div>
        <div data-show-when="mode:gas">
            <x-calc.field name="P" label="Pressure" value="1" min="0" placeholder="Pressure">
                <label for="calc-P-unit" class="sr-only">Pressure unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'atm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:gas">
            <x-calc.field name="T" label="Temperature" value="0" placeholder="Temperature">
                <label for="calc-T-unit" class="sr-only">Temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Number density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'gas', 'rho' => 8.96, 'rho-unit' => 'gcm3', 'M' => 63.546, 'P' => 1, 'P-unit' => 'atm', 'T' => 0, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cm3' => ['label' => 'Per cubic centimetre'],
            'spacing' => ['label' => 'Mean spacing between particles'],
            'mol' => ['label' => 'Amount per cubic metre'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
