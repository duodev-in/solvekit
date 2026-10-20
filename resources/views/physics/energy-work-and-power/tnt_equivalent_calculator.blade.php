<x-calc.page
    title="TNT Equivalent Calculator - SolveKit"
    description="Free TNT equivalent calculator: convert energy to tonnes, kilograms and kilotons of TNT."
    lede="Express energy as TNT."
    about="One tonne of TNT is defined as 4.184 GJ. The scale is used for explosions, impacts and earthquakes."
    :calc="['engine' => 'ph-mech', 'tool' => 'tnt', 'fields' => ['E'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much TNT is 4.184 GJ?', 'answer' => '1 t TNT.'],
    ]"
>
    <x-calc.field name="E" label="Energy" value="4.184" placeholder="Energy">
        <label for="calc-E-unit" class="sr-only">Energy unit</label>
        <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'gj')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="TNT equivalent" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['E' => 4.184, 'E-unit' => 'gj'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kg' => ['label' => 'In kilograms of TNT'],
            'kt' => ['label' => 'In kilotons'],
            'compare' => ['label' => 'Compared with'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
