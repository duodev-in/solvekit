<x-calc.page
    title="Intrinsic Carrier Concentration Calculator - SolveKit"
    description="Free intrinsic carrier concentration calculator: nᵢ of silicon, germanium and GaAs at any temperature."
    lede="Find nᵢ of a semiconductor."
    about="In a pure semiconductor heat lifts electrons across the band gap, making equal numbers of electrons and holes. nᵢ = √(N_cN_v) e^(−E_g/2kT) rises steeply with temperature; the band gap shrinks slightly as it warms (Varshni)."
    :calc="['engine' => 'ph-mat', 'tool' => 'intrinsic_carrier', 'fields' => ['sc', 'T', 'eg', 'nc', 'nv'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['semiconductors'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is nᵢ of silicon at 300 K?', 'answer' => '9,887,000,000 cm⁻³ with this model.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sc" label="Semiconductor" :options="['si' => 'Silicon', 'ge' => 'Germanium', 'gaas' => 'Gallium arsenide', 'custom' => 'Other (enter the value)']" selected="si" />
        <x-calc.field name="T" label="Temperature" value="300" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="sc:custom">
            <x-calc.field name="eg" label="Band gap at this temperature (eV)" value="1.12" min="0" step="any" />
        </div>
        <div data-show-when="sc:custom">
            <x-calc.field name="nc" label="N_c at 300 K (cm⁻³)" value="28000000000000000000" min="0" step="any" />
        </div>
        <div data-show-when="sc:custom">
            <x-calc.field name="nv" label="N_v at 300 K (cm⁻³)" value="10400000000000000000" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Intrinsic carrier concentration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sc' => 'si', 'T' => 300, 'T-unit' => 'k', 'eg' => 1.12, 'nc' => 28000000000000000000, 'nv' => 10400000000000000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'eg' => ['label' => 'Band gap used'],
            'nc' => ['label' => 'Effective densities of states'],
            'resist' => ['label' => 'Intrinsic resistivity (silicon mobilities)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
