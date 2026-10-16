<x-calc.page
    title="Gibbs Free Energy Calculator - SolveKit"
    description="Free Gibbs free energy calculator: ΔG from ΔH and ΔS, from K, from a cell potential, or for a reaction from standard data."
    lede="Work out ΔG and whether a reaction is spontaneous."
    about="ΔG = ΔH − TΔS; ΔG° = −RT ln K = −nFE°cell. For a reaction at 25 °C the standard Gibbs energies of formation are used directly; at other temperatures ΔH° − TΔS° is used, assuming ΔH and ΔS do not change much with temperature. The crossover temperature is where ΔG changes sign."
    :calc="['engine' => 'chem-thermo', 'tool' => 'gibbs', 'fields' => ['mode', 'enthalpy', 'entropy', 'equation', 'k', 'potential', 'electrons', 'temperature'], 'unitFields' => ['temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight']), 'thermo' => config('chemistry_data.thermo')]]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'ΔH and ΔS, reaction data, K or E°.'],
        ['name' => 'Set the temperature', 'text' => 'In any unit.'],
    ]"
    :faqs="[
        ['question' => 'What does a negative ΔG mean?', 'answer' => 'The reaction is spontaneous in the forward direction at that temperature.'],
        ['question' => 'How are ΔG and K related?', 'answer' => 'ΔG° = −RT ln K, so a negative ΔG° means K > 1.'],
        ['question' => 'What is the crossover temperature?', 'answer' => 'T = ΔH ÷ ΔS, where the sign of ΔG flips.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['hs' => 'ΔH and ΔS', 'reaction' => 'Reaction data', 'k' => 'K', 'cell' => 'Cell potential']" selected="hs" />

    <div data-show-when="mode:hs">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="enthalpy" label="ΔH" value="-92.2" suffix="kJ/mol" />
            <x-calc.field name="entropy" label="ΔS" value="-198.7" suffix="J/(mol·K)" />
        </div>
    </div>

    <div data-show-when="mode:reaction" hidden>
        <x-calc.field name="equation" label="Chemical equation" value="N2(g) + H2(g) = NH3(g)" type="text" help="Phases are required" />
    </div>

    <div data-show-when="mode:k" hidden>
        <x-calc.field name="k" label="Equilibrium constant K" value="100000.0" min="0" />
    </div>

    <div data-show-when="mode:cell" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="potential" label="E°cell" value="1.1" suffix="V" />
            <x-calc.field name="electrons" label="Electrons transferred n" value="2" min="1" step="1" />
        </div>
    </div>

    <x-calc.field name="temperature" label="Temperature" value="25" placeholder="Temperature">
        <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
        <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Gibbs free energy" />

    <x-calc.options :examples="[
        'Ammonia synthesis' => ['mode' => 'hs', 'enthalpy' => -92.2, 'entropy' => -198.7, 'temperature' => 25, 'temperature-unit' => 'c'],
        'From reaction data' => ['mode' => 'reaction', 'equation' => 'N2(g) + H2(g) = NH3(g)', 'temperature' => 25, 'temperature-unit' => 'c'],
        'Daniell cell' => ['mode' => 'cell', 'potential' => 1.1, 'electrons' => 2, 'temperature' => 25, 'temperature-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'k' => ['label' => 'Equilibrium constant K'],
            'kelvin' => ['label' => 'Temperature'],
            'crossover' => ['label' => 'Crossover temperature'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔG = ΔH − TΔS</li>
            <li>ΔG° = −RT ln K</li>
            <li>ΔG° = −nFE°</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
