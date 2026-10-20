<x-calc.page
    title="DIY Sports Drink Calculator - SolveKit"
    description="Free DIY sports drink calculator: sugar and salt for a homemade drink at the right strength."
    lede="Mix your own sports drink."
    about="A sports drink of 6–8% carbohydrate with some sodium is absorbed quickly and replaces salt lost in sweat."
    :calc="['engine' => 'sp-run', 'tool' => 'sports_drink', 'fields' => ['V', 'carb', 'na', 'out'], 'unitFields' => ['V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much sugar and salt in 750 ml?', 'answer' => '45 g sugar and 1.31 g salt per 750 ml.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="V" label="Bottle size" value="750" min="0" placeholder="Bottle size">
            <label for="calc-V-unit" class="sr-only">Bottle size unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="carb" label="Carbohydrate concentration (%)" value="6" min="0" step="any" />
        <x-calc.field name="na" label="Sodium (mmol per litre)" value="30" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="g" />
    </div>

    <x-calc.result label="Sugar to add" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'g', 'V' => 750, 'V-unit' => 'ml', 'carb' => 6, 'na' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'salt' => ['label' => 'Table salt to add'],
            'kcal' => ['label' => 'Energy'],
            'sodium' => ['label' => 'Sodium'],
            'note' => ['label' => 'Guidance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
