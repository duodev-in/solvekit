<x-calc.page
    title="Kp Calculator - SolveKit"
    description="Free Kp calculator: convert between Kc and Kp with Kp = Kc(RT)^Δn, with Δn worked out from the equation."
    lede="Convert between Kc and Kp for a gas-phase equilibrium."
    about="Kp uses partial pressures and Kc uses concentrations; they are related by Kp = Kc (RT)^Δn, where Δn is moles of gaseous products minus gaseous reactants. Mark gases with (g) in the equation, or type Δn yourself."
    :calc="['engine' => 'chem-reactions', 'tool' => 'kp', 'fields' => ['direction', 'k', 'temperature', 'equation', 'delta_n', 'pressure_unit'], 'unitFields' => ['temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'Kc to Kp or back.'],
        ['name' => 'Enter K and temperature', 'text' => 'In any temperature unit.'],
        ['name' => 'Give the equation or Δn', 'text' => 'Gases marked (g).'],
    ]"
    :faqs="[
        ['question' => 'When is Kp equal to Kc?', 'answer' => 'When Δn = 0, the same number of gas moles on both sides.'],
        ['question' => 'Which R should I use?', 'answer' => '0.08206 L·atm/(mol·K) for atm or 0.08314 L·bar/(mol·K) for bar.'],
        ['question' => 'Do solids count in Δn?', 'answer' => 'No, only gases.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['kc_to_kp' => 'Kc → Kp', 'kp_to_kc' => 'Kp → Kc']" selected="kc_to_kp" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="k" label="K value" value="0.5" min="0" />
        <x-calc.field name="temperature" label="Temperature" value="400" placeholder="Temperature">
            <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
            <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="equation" label="Chemical equation" value="N2(g) + 3H2(g) = 2NH3(g)" type="text" help="Gases marked (g); leave empty to type Δn" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="delta_n" label="Or Δn (gas)" value="" step="1" placeholder="From the equation" />
        <x-calc.segmented name="pressure_unit" legend="Pressure unit" :options="['atm' => 'atm', 'bar' => 'bar']" selected="atm" />
    </div>

    <x-calc.result label="Converted constant" />

    <x-calc.options :examples="[
        'Ammonia at 400 °C' => ['direction' => 'kc_to_kp', 'k' => 0.5, 'temperature' => 400, 'temperature-unit' => 'c', 'equation' => 'N2(g) + 3H2(g) = 2NH3(g)', 'delta_n' => '', 'pressure_unit' => 'atm'],
        'N₂O₄ ⇌ 2NO₂' => ['direction' => 'kc_to_kp', 'k' => 0.0046, 'temperature' => 25, 'temperature-unit' => 'c', 'equation' => 'N2O4(g) = 2NO2(g)', 'delta_n' => '', 'pressure_unit' => 'bar'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'delta' => ['label' => 'Δn (gas)'],
            'rt' => ['label' => 'RT'],
            'kelvin' => ['label' => 'Temperature'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Kp = Kc (RT)^Δn</li>
            <li>Δn = gas moles of products − reactants</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
