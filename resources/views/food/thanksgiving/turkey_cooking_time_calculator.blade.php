<x-calc.page
    title="Turkey Cooking Time Calculator - SolveKit"
    description="Free turkey cooking time calculator: roasting time for a stuffed or unstuffed turkey at 325 °F from the USDA timetable, when to put it in the oven, and the safe temperature."
    lede="Find how long to roast your turkey."
    about="USDA FSIS roasting timetable for a fresh or thawed whole turkey at 325 °F: unstuffed 2¾–3 h for 8–12 lb up to 4½–5 h for 20–24 lb; a stuffed bird takes about 15–30 minutes longer. The turkey is done when a food thermometer reads 165 °F (74 °C) in the thickest part of the thigh, the wing joint and the breast (and the centre of any stuffing). Let it rest 20–30 minutes before carving. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-party', 'tool' => 'turkey_roast', 'fields' => ['weight', 'stuffed', 'meal_date', 'meal_time'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => ['turkey' => config('food_data.turkey')]]"
    :how-to="[
        ['name' => 'Enter the weight', 'text' => ''],
        ['name' => 'Tick if stuffed', 'text' => ''],
        ['name' => 'Enter the meal time', 'text' => 'To see when it goes in.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 14 lb turkey take?', 'answer' => '3 h – 3 h 45 min unstuffed at 325 °F.'],
        ['question' => 'And stuffed?', 'answer' => '3 h 30 min – 4 h.'],
        ['question' => 'A 20 lb turkey?', 'answer' => '4 h 15 min – 4 h 30 min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Turkey weight" value="14" min="0" placeholder="Turkey weight">
            <label for="calc-weight-unit" class="sr-only">Turkey weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.checkbox name="stuffed" label="Stuffed" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="meal_date" label="Meal date" value="2026-11-26" type="date" />
        <x-calc.field name="meal_time" label="Meal time" value="15:00" type="time" />
    </div>

    <x-calc.result label="Roasting time at 325 °F (163 °C)" />

    <x-calc.options :decimals="false" :examples="[
        '14 lb' => ['weight' => 14, 'weight-unit' => 'lb', 'stuffed' => false, 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
        '14 lb stuffed' => ['weight' => 14, 'weight-unit' => 'lb', 'stuffed' => true, 'meal_date' => '2026-11-26', 'meal_time' => '15:00'],
        '20 lb' => ['weight' => 20, 'weight-unit' => 'lb', 'stuffed' => false, 'meal_date' => '2026-11-26', 'meal_time' => '16:00'],
        '6 kg' => ['weight' => 6, 'weight-unit' => 'kg', 'stuffed' => false, 'meal_date' => '2026-12-25', 'meal_time' => '13:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'temp' => ['label' => 'Done at'],
            'rest' => ['label' => 'Resting'],
            'start' => ['label' => 'Into the oven'],
            'check' => ['label' => 'Check from'],
            'perLb' => ['label' => 'Per pound'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>USDA FSIS timetable at 325 °F</li>
            <li>done at 165 °F</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
