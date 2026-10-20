<x-calc.page
    title="Water Density Calculator - SolveKit"
    description="Free water density calculator: density of pure water at any temperature from 0 to 150 °C."
    lede="Find water density."
    about="Water is densest at 3.98 °C and lighter both colder and warmer. Kell’s equation gives density to about 0.01 kg/m³."
    :calc="['engine' => 'ph-fluid', 'tool' => 'water_density', 'fields' => ['T', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the density of water at 20 °C?', 'answer' => '998.204 kg/m³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Water temperature" value="20" placeholder="Water temperature">
            <label for="calc-T-unit" class="sr-only">Water temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
    </div>

    <x-calc.result label="Density of pure water" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kgm3', 'T' => 20, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sv' => ['label' => 'Specific volume'],
            'vs4' => ['label' => 'Compared with 4 °C'],
            'sea' => ['label' => 'Typical sea water (35 ‰)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
