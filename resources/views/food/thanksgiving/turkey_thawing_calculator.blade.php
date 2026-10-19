<x-calc.page
    title="Turkey Thawing Calculator - SolveKit"
    description="Free turkey thawing calculator: cold-water and refrigerator thawing times for any size turkey from USDA guidance, and the latest time to start before your meal."
    lede="Work out when to start thawing your turkey."
    about="USDA FSIS gives three safe ways to thaw a turkey. In the refrigerator (40 °F or below) allow about 24 hours for every 4 to 5 lb; once thawed it keeps 1–2 more days. In cold water allow 30 minutes per pound, keep the bird in a leak-proof bag, change the water every 30 minutes and cook it straight away. In the microwave follow the maker's instructions and cook at once. Never thaw on the counter. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-party', 'tool' => 'turkey_thaw', 'fields' => ['weight', 'method', 'meal_date', 'meal_time'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => ['turkey' => config('food_data.turkey')]]"
    :how-to="[
        ['name' => 'Enter the weight', 'text' => ''],
        ['name' => 'Choose cold water or refrigerator', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long to thaw a 12 lb turkey in cold water?', 'answer' => '6 h.'],
        ['question' => 'And in the refrigerator?', 'answer' => '3 days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Turkey weight" value="16" min="0" placeholder="Turkey weight">
            <label for="calc-weight-unit" class="sr-only">Turkey weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="method" label="Method" :options="['fridge' => 'Refrigerator', 'water' => 'Cold water', 'microwave' => 'Microwave']" selected="water" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="meal_date" label="Meal date" value="2026-11-26" type="date" />
        <x-calc.field name="meal_time" label="Meal time" value="15:00" type="time" />
    </div>

    <x-calc.result label="Cold-water thawing" />

    <x-calc.options :decimals="false" :examples="[
        '12 lb cold water' => ['weight' => 12, 'weight-unit' => 'lb', 'method' => 'water', 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
        '12 lb fridge' => ['weight' => 12, 'weight-unit' => 'lb', 'method' => 'fridge', 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
        '18 lb cold water' => ['weight' => 18, 'weight-unit' => 'lb', 'method' => 'water', 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fridge' => ['label' => 'In the refrigerator'],
            'water' => ['label' => 'In cold water'],
            'start' => ['label' => 'Start thawing'],
            'safety' => ['label' => 'Safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cold water: 30 min per lb</li>
            <li>fridge: 24 h per 4–5 lb</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
