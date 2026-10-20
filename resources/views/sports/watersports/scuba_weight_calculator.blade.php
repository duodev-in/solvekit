<x-calc.page
    title="Scuba Weight Calculator - SolveKit"
    description="Free scuba weight calculator: a starting weight from body weight, suit, cylinder and water."
    lede="Estimate scuba weighting."
    about="Wetsuits float, so thicker suits need more lead. Always finish with a buoyancy check at the surface."
    :calc="['engine' => 'sp-misc', 'tool' => 'scuba_weight', 'fields' => ['w', 'suit', 'tank', 'water', 'out'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What weight to start with in a 5 mm suit?', 'answer' => 'About 8 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Body weight" value="75" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="suit" label="Exposure suit" :options="['0' => 'Swimsuit or skin', '0.05' => '3 mm wetsuit', '0.08' => '5 mm wetsuit', '0.1' => '7 mm wetsuit', '0.12' => 'Drysuit (plus 2–4 kg for undergarments)']" selected="0.08" />
        <x-calc.select name="tank" label="Cylinder" :options="['0' => 'Steel 12 L', '2' => 'Aluminium 80 (floats when nearly empty)', '-2' => 'Steel 15 L (heavy)']" selected="2" />
        <x-calc.select name="water" label="Water" :options="['salt' => 'Salt water', 'fresh' => 'Fresh water']" selected="salt" />
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
    </div>

    <x-calc.result label="Starting weight to carry" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kg', 'w' => 75, 'w-unit' => 'kg', 'suit' => '0.08', 'tank' => '2', 'water' => 'salt'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'check' => ['label' => 'Check it'],
            'fresh' => ['label' => 'Fresh water'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
