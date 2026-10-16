<x-calc.page
    title="Entropy Calculator - SolveKit"
    description="Free entropy calculator: entropy change of a reaction from standard entropies, a phase change, heating or gas expansion."
    lede="Work out an entropy change for a reaction, phase change, heating or expansion."
    about="For reactions, ΔS° = Σ ν S°(products) − Σ ν S°(reactants) using standard molar entropies at 298.15 K (311 substances, NBS/CRC values). Phase changes use ΔS = ΔH ÷ T, heating uses ΔS = m c ln(T₂/T₁) and ideal-gas isothermal expansion uses ΔS = nR ln(V₂/V₁)."
    :calc="['engine' => 'chem-thermo', 'tool' => 'entropy', 'fields' => ['mode', 'equation', 'enthalpy', 'temperature', 'mass', 'heat_capacity', 't1', 't2', 'moles', 'v1', 'v2'], 'unitFields' => ['temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 't1' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 't2' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight']), 'thermo' => config('chemistry_data.thermo')]]"
    :how-to="[
        ['name' => 'Choose the process', 'text' => 'Reaction, phase change, heating or expansion.'],
        ['name' => 'Enter the values', 'text' => 'Reactions need phases on every species.'],
    ]"
    :faqs="[
        ['question' => 'What does a positive ΔS mean?', 'answer' => 'The system becomes more disordered, e.g. a solid melting or gas forming.'],
        ['question' => 'What is the entropy of vaporization of water?', 'answer' => 'About 109 J/(mol·K) at 100 °C.'],
        ['question' => 'Why are phases needed?', 'answer' => 'Entropy depends strongly on phase: water gas has far more than liquid.'],
    ]"
>
    <x-calc.segmented name="mode" legend="For" :options="['reaction' => 'Reaction', 'phase' => 'Phase change', 'heating' => 'Heating', 'expansion' => 'Gas expansion']" selected="reaction" />

    <div data-show-when="mode:reaction">
        <x-calc.field name="equation" label="Chemical equation" value="N2(g) + H2(g) = NH3(g)" type="text" help="Phases are required: (s), (l), (g) or (aq)" />
    </div>

    <div data-show-when="mode:phase" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="enthalpy" label="Enthalpy of the change" value="40.65" suffix="kJ/mol" />
            <x-calc.field name="temperature" label="At temperature" value="100" placeholder="At temperature">
                <label for="calc-temperature-unit" class="sr-only">At temperature unit</label>
                <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:heating" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="mass" label="Mass" value="100" min="0" suffix="g" />
            <x-calc.field name="heat_capacity" label="Specific heat" value="4.186" min="0" suffix="J/(g·K)" />
        </div>
    </div>

    <div data-show-when="mode:heating" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="t1" label="From" value="20" placeholder="From">
                <label for="calc-t1-unit" class="sr-only">From unit</label>
                <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="t2" label="To" value="80" placeholder="To">
                <label for="calc-t2-unit" class="sr-only">To unit</label>
                <select id="calc-t2-unit" name="t2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:expansion" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="moles" label="Moles" value="1" min="0" />
            <x-calc.field name="v1" label="Initial volume" value="10" min="0" suffix="L" />
            <x-calc.field name="v2" label="Final volume" value="20" min="0" suffix="L" />
        </div>
    </div>

    <x-calc.result label="Entropy change" />

    <x-calc.options :examples="[
        'Ammonia synthesis' => ['mode' => 'reaction', 'equation' => 'N2(g) + H2(g) = NH3(g)'],
        'Boiling water' => ['mode' => 'phase', 'enthalpy' => 40.65, 'temperature' => 100, 'temperature-unit' => 'c'],
        'Heating 100 g water' => ['mode' => 'heating', 'mass' => 100, 'heat_capacity' => 4.186, 't1' => 20, 't1-unit' => 'c', 't2' => 80, 't2-unit' => 'c'],
        'Doubling gas volume' => ['mode' => 'expansion', 'moles' => 1, 'v1' => 10, 'v2' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kj' => ['label' => 'In kJ'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.quick-ref heading="Terms" name="terms" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔS° = Σ ν S°(products) − Σ ν S°(reactants)</li>
            <li>ΔS = ΔH ÷ T; m c ln(T₂/T₁); nR ln(V₂/V₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
