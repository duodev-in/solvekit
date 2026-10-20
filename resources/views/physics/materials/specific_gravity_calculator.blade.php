<x-calc.page
    title="Specific Gravity Calculator - SolveKit"
    description="Free specific gravity calculator: SG from density against water at 4 °C, 15.6 °C or 20 °C, with API gravity."
    lede="Find specific gravity."
    about="Specific gravity is density relative to water. Below 1 it floats. The petroleum industry uses API gravity, 141.5/SG − 131.5 at 60 °F."
    :calc="['engine' => 'ph-mat', 'tool' => 'specific_gravity', 'fields' => ['rho', 'ref'], 'unitFields' => ['rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the SG of 850 kg/m³?', 'answer' => '0.85002.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rho" label="Density" value="850" min="0" placeholder="Density">
            <label for="calc-rho-unit" class="sr-only">Density unit</label>
            <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="ref" label="Reference water" :options="['t4' => 'Water at 4 °C (999.972 kg/m³)', 't60' => 'Water at 60 °F / 15.6 °C (999.016 kg/m³)', 't20' => 'Water at 20 °C (998.207 kg/m³)']" selected="t4" />
    </div>

    <x-calc.result label="Specific gravity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rho' => 850, 'rho-unit' => 'kgm3', 'ref' => 't4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'api' => ['label' => 'API gravity (petroleum, 60 °F reference)'],
            'floats' => ['label' => 'In water'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
