<x-calc.page
    title="Conductivity to Resistivity Calculator - SolveKit"
    description="Free conductivity to resistivity calculator: convert between S/m and Ω·m, with % IACS and common metals."
    lede="Convert conductivity and resistivity."
    about="Conductivity is the reciprocal of resistivity. Annealed copper (1.7241 × 10⁻⁸ Ω·m) defines 100% IACS."
    :calc="['engine' => 'ph-em', 'tool' => 'conductivity', 'fields' => ['mode', 'rho', 'sigma', 'mat'], 'unitFields' => ['rho' => collect(config('units.resistivity'))->only(['ohmm', 'ohmcm', 'uohmcm', 'nohmm', 'ohmmm2m'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'resistivity', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['conductors'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the conductivity of copper?', 'answer' => '58,001,300 S/m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Convert" :options="['rho' => 'Resistivity to conductivity', 'sigma' => 'Conductivity to resistivity', 'material' => 'Look up a material']" selected="rho" />
        <div data-show-when="mode:rho">
            <x-calc.field name="rho" label="Resistivity" value="1.7241e-08" min="0" placeholder="Resistivity">
                <label for="calc-rho-unit" class="sr-only">Resistivity unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistivity'))->only(['ohmm', 'ohmcm', 'uohmcm', 'nohmm', 'ohmmm2m']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohmm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:sigma">
            <x-calc.field name="sigma" label="Conductivity (S/m)" value="58000000" min="0" step="any" />
        </div>
        <div data-show-when="mode:material">
            <x-calc.select name="mat" label="Material" :options="['copper' => 'Copper (annealed)', 'aluminium' => 'Aluminium (EC grade)', 'silver' => 'Silver', 'gold' => 'Gold', 'tungsten' => 'Tungsten', 'brass' => 'Brass', 'iron' => 'Iron (pure)', 'steel' => 'Carbon steel', 'stainless' => 'Stainless steel 304', 'constantan' => 'Constantan', 'nichrome' => 'Nichrome (80/20)']" selected="copper" />
        </div>
    </div>

    <x-calc.result label="Conductivity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'rho', 'rho' => 1.7241e-08, 'rho-unit' => 'ohmm', 'sigma' => 58000000, 'mat' => 'copper'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rho' => ['label' => 'Resistivity'],
            'iacs' => ['label' => 'Compared with annealed copper (% IACS)'],
            'ms' => ['label' => 'In MS/m'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
