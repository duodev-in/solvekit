<x-calc.page
    title="High-Altitude Baking Calculator - SolveKit"
    description="Free high-altitude baking calculator: adjust baking powder, sugar, liquid and oven temperature for your altitude, using the Colorado State University guidelines."
    lede="Adjust a recipe for baking at altitude."
    about="Above about 3,000 ft lower air pressure makes batters rise faster and lose moisture, and water boils lower. Colorado State University Extension's table: per teaspoon of baking powder cut ⅛ tsp at 3,000 ft, ⅛–¼ tsp at 5,000 ft and ¼ tsp at 7,000 ft; per cup of sugar cut 0–1, 0–2 and 1–3 tablespoons; per cup of liquid add 1–2, 2–4 and 3–4 tablespoons; and bake 15–25 °F hotter for a little less time. This uses the middle of each range; test and adjust."
    :calc="['engine' => 'fd-bake', 'tool' => 'altitude_bake', 'fields' => ['altitude', 'bp', 'sugar', 'liquid', 'oven'], 'unitFields' => ['altitude' => collect(config('units.length'))->only(['ft', 'm'])->all(), 'oven' => collect(config('units.temperature'))->only(['f', 'c'])->all()]]"
    :how-to="[
        ['name' => 'Enter your altitude', 'text' => ''],
        ['name' => 'Enter the recipe amounts and oven temperature', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How do I adjust a cake for Denver (5,280 ft)?', 'answer' => 'At 5,280 ft water boils at 202 °F (94.6 °C); 5,000 ft adjustments: baking powder 1⅝ tsp (cut ⅛ tsp–¼ tsp per tsp), sugar 0.94 cup (cut 0–2 tbsp per cup), liquid 1.19 cups (add 2–4 tbsp per cup).'],
        ['question' => 'Does 2,000 ft need changes?', 'answer' => 'Water boils at 97.9 °C (208 °F); most recipes need no adjustment.'],
    ]"
>
    <x-calc.field name="altitude" label="Altitude" value="5280" min="0" placeholder="Altitude">
        <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
        <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bp" label="Baking powder" value="2" min="0" step="any" suffix="tsp" />
        <x-calc.field name="sugar" label="Sugar" value="1" min="0" step="any" suffix="cups" />
        <x-calc.field name="liquid" label="Liquid" value="1" min="0" step="any" suffix="cups" />
    </div>

    <x-calc.field name="oven" label="Oven temperature" value="350" placeholder="Oven temperature">
        <label for="calc-oven-unit" class="sr-only">Oven temperature unit</label>
        <select id="calc-oven-unit" name="oven-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Adjusted oven temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Denver' => ['altitude' => 5280, 'altitude-unit' => 'ft', 'bp' => 2, 'sugar' => 1, 'liquid' => 1, 'oven' => 350, 'oven-unit' => 'f'],
        '2,000 ft' => ['altitude' => 2000, 'altitude-unit' => 'ft', 'bp' => 2, 'sugar' => 1, 'liquid' => 1, 'oven' => 350, 'oven-unit' => 'f'],
        '8,000 ft' => ['altitude' => 8000, 'altitude-unit' => 'ft', 'bp' => 1, 'sugar' => 1.5, 'liquid' => 1, 'oven' => 375, 'oven-unit' => 'f'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'boil' => ['label' => 'Water boils at'],
            'bp' => ['label' => 'Baking powder'],
            'sugar' => ['label' => 'Sugar'],
            'liquid' => ['label' => 'Liquid'],
            'oven' => ['label' => 'Oven'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>boiling point from the standard atmosphere (IAPWS)</li>
            <li>CSU per-tsp and per-cup adjustments</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
