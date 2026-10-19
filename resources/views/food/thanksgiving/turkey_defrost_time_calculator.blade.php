<x-calc.page
    title="Turkey Defrost Time Calculator - SolveKit"
    description="Free turkey defrost time calculator: how long to thaw a turkey in the refrigerator, in cold water or in the microwave (USDA), and when to start for your meal."
    lede="Find how long your turkey takes to defrost."
    about="USDA FSIS gives three safe ways to thaw a turkey. In the refrigerator (40 °F or below) allow about 24 hours for every 4 to 5 lb; once thawed it keeps 1–2 more days. In cold water allow 30 minutes per pound, keep the bird in a leak-proof bag, change the water every 30 minutes and cook it straight away. In the microwave follow the maker's instructions and cook at once. Never thaw on the counter. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-party', 'tool' => 'turkey_thaw', 'fields' => ['weight', 'method', 'meal_date', 'meal_time'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => ['turkey' => config('food_data.turkey')]]"
    :how-to="[
        ['name' => 'Enter the turkey weight', 'text' => ''],
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter the meal date and time', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long does a 16 lb turkey take to thaw in the fridge?', 'answer' => '4 days (24 hours per 4–5 lb).'],
        ['question' => 'When should I start for Thanksgiving dinner?', 'answer' => 'Sat, Nov 21, 2026, 3:00 PM (with a day to spare).'],
        ['question' => 'How long in cold water?', 'answer' => '8 h.'],
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
        <x-calc.select name="method" label="Method" :options="['fridge' => 'Refrigerator', 'water' => 'Cold water', 'microwave' => 'Microwave']" selected="fridge" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="meal_date" label="Meal date" value="2026-11-26" type="date" />
        <x-calc.field name="meal_time" label="Meal time" value="15:00" type="time" />
    </div>

    <x-calc.result label="Refrigerator thawing" />

    <x-calc.options :decimals="false" :examples="[
        '16 lb fridge' => ['weight' => 16, 'weight-unit' => 'lb', 'method' => 'fridge', 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
        '16 lb cold water' => ['weight' => 16, 'weight-unit' => 'lb', 'method' => 'water', 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
        '22 lb fridge' => ['weight' => 22, 'weight-unit' => 'lb', 'method' => 'fridge', 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
        '7 kg fridge' => ['weight' => 7, 'weight-unit' => 'kg', 'method' => 'fridge', 'meal_date' => '2026-12-25', 'meal_time' => '13:00'],
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
            <li>fridge days = weight ÷ 4 to 5 lb</li>
            <li>cold water hours = weight × 30 min</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
