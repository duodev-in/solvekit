<x-calc.page
    title="Latent Heat Calculator - SolveKit"
    description="Free latent heat calculator: heat to melt or boil water, metals and other substances."
    lede="Find the heat for a phase change."
    about="Melting or boiling needs heat without any temperature change: Q = mL. Boiling 1 kg of water takes 2.26 MJ."
    :calc="['engine' => 'ph-thermo', 'tool' => 'latent_heat', 'fields' => ['sub', 'L', 'change', 'm', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['latent'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much heat boils 1 kg of water?', 'answer' => '2,256.4 kJ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sub" label="Substance" :options="['water' => 'Water', 'ethanol' => 'Ethanol', 'ammonia' => 'Ammonia', 'nitrogen' => 'Nitrogen', 'mercury' => 'Mercury', 'lead' => 'Lead', 'aluminium' => 'Aluminium', 'copper' => 'Copper', 'iron' => 'Iron', 'paraffin' => 'Paraffin wax', 'custom' => 'Other (enter the value)']" selected="water" />
        <div data-show-when="sub:custom">
            <x-calc.field name="L" label="Latent heat (kJ/kg)" value="334" min="0" step="any" />
        </div>
        <x-calc.select name="change" label="Change" :options="['fusion' => 'Melting or freezing (fusion)', 'vaporisation' => 'Boiling or condensing (vaporisation)']" selected="vaporisation" />
        <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
            <label for="calc-m-unit" class="sr-only">Mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="kj" />
    </div>

    <x-calc.result label="Heat needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kj', 'sub' => 'water', 'L' => 334, 'change' => 'vaporisation', 'm' => 1, 'm-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'L' => ['label' => 'Latent heat used'],
            'at' => ['label' => 'Transition temperature'],
            'kwh' => ['label' => 'In kWh'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
