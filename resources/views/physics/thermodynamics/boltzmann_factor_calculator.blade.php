<x-calc.page
    title="Boltzmann Factor Calculator - SolveKit"
    description="Free Boltzmann factor calculator: e^(−ΔE/kT) and the population ratio of two energy levels."
    lede="Find the Boltzmann factor."
    about="In thermal equilibrium a state ΔE higher is less populated by e^(−ΔE/kT). At room temperature kT is about 26 meV."
    :calc="['engine' => 'ph-thermo', 'tool' => 'boltzmann_factor', 'fields' => ['dE', 'T', 'g1', 'g2'], 'unitFields' => ['dE' => collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_energy', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the factor for 0.1 eV at 300 K?', 'answer' => '0.0208965.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dE" label="Energy difference" value="0.1" min="0" placeholder="Energy difference">
            <label for="calc-dE-unit" class="sr-only">Energy difference unit</label>
            <select id="calc-dE-unit" name="dE-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ev')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="300" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="g1" label="Degeneracy of the lower state" value="1" min="0" step="any" />
        <x-calc.field name="g2" label="Degeneracy of the upper state" value="1" min="0" step="any" />
    </div>

    <x-calc.result label="Boltzmann factor e^(−ΔE/kT)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dE' => 0.1, 'dE-unit' => 'ev', 'T' => 300, 'T-unit' => 'k', 'g1' => 1, 'g2' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Population ratio upper ÷ lower'],
            'kT' => ['label' => 'Thermal energy kT'],
            'fraction' => ['label' => 'Share in the upper state (two levels)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
