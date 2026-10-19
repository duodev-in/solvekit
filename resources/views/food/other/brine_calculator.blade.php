<x-calc.page
    title="Brine Calculator - SolveKit"
    description="Free brine calculator: salt and sugar for a brine by percentage or an equilibrium brine, with the amount in tablespoons for table salt and Morton or Diamond Crystal kosher salt."
    lede="Mix a brine for meat, poultry or pickles."
    about="Brine strength is salt as a percentage of the water by weight (5–6% for poultry, 3–5% for pork; 2–3% for many ferments). An equilibrium brine uses a percentage of the meat plus water, so the food can never get saltier than that. Salt brands differ a lot by volume: a teaspoon of table salt weighs about 6 g, Morton kosher 4.8 g and Diamond Crystal kosher 2.8 g (from their nutrition labels), so weigh salt when you can."
    :calc="['engine' => 'fd-other', 'tool' => 'brine', 'fields' => ['mode', 'water', 'meat', 'water_eq', 'percent', 'sugar', 'salt'], 'unitFields' => ['water' => collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk'])->all()], 'data' => ['salt' => config('food_data.salt')]]"
    :how-to="[
        ['name' => 'Choose a percentage or an equilibrium brine', 'text' => ''],
        ['name' => 'Enter the water (and meat)', 'text' => ''],
        ['name' => 'Set salt %, sugar % and salt type', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much kosher salt for a gallon of 5% brine?', 'answer' => '189 g (13⅛ tbsp (13.1), or 0.82 cup) of Morton kosher salt.'],
        ['question' => 'How about Diamond Crystal?', 'answer' => 'Table salt (Morton): 10½ tbsp (10.5); Diamond Crystal kosher salt: 22.5 tbsp; Fine sea salt: 10½ tbsp (10.5).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Type" :options="['brine' => 'Percentage brine', 'equilibrium' => 'Equilibrium brine']" selected="brine" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:brine">
            <x-calc.field name="water" label="Water" value="1" min="0" placeholder="Water">
                <label for="calc-water-unit" class="sr-only">Water unit</label>
                <select id="calc-water-unit" name="water-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:equilibrium" hidden>
            <x-calc.field name="meat" label="Meat weight" value="1500" min="0" step="any" suffix="g" />
        </div>
    </div>

    <div data-show-when="mode:equilibrium" hidden>
        <x-calc.field name="water_eq" label="Water weight" value="1500" min="0" step="any" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="percent" label="Salt" value="5" min="0" step="any" suffix="%" />
        <x-calc.field name="sugar" label="Sugar" value="2.5" min="0" step="any" suffix="%" />
        <x-calc.select name="salt" label="Salt type" :options="collect(config('food_data.salt'))->map(fn ($s) => $s['name'])->all()" selected="morton_kosher" />
    </div>

    <x-calc.result label="Salt" />

    <x-calc.options :decimals="false" :examples="[
        'Turkey brine' => ['mode' => 'brine', 'water' => 1, 'water-unit' => 'gal_us', 'meat' => 1500, 'water_eq' => 1500, 'percent' => 5, 'sugar' => 2.5, 'salt' => 'morton_kosher'],
        'Equilibrium pork' => ['mode' => 'equilibrium', 'water' => 1, 'water-unit' => 'gal_us', 'meat' => 1500, 'water_eq' => 1500, 'percent' => 1.5, 'sugar' => 1, 'salt' => 'diamond_kosher'],
        'Pickle brine' => ['mode' => 'brine', 'water' => 1, 'water-unit' => 'l', 'meat' => 1500, 'water_eq' => 1500, 'percent' => 3.5, 'sugar' => 0, 'salt' => 'table'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'volume' => ['label' => 'By volume'],
            'others' => ['label' => 'Other salts'],
            'sugar' => ['label' => 'Sugar'],
            'time' => ['label' => 'Brining time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>brine: salt = water g × %</li>
            <li>equilibrium: salt = (meat + water) × %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
