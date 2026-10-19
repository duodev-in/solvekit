<x-calc.page
    title="Ham Cooking Time Calculator - SolveKit"
    description="Free ham cooking time calculator: oven times at 325 °F for fully cooked, cook-before-eating and fresh hams by cut and weight, from the USDA FSIS chart, with the safe temperature."
    lede="Find how long to cook or reheat a ham."
    about="USDA FSIS ham chart at 325 °F: fully cooked hams are reheated to 140 °F (165 °F if not packaged in a USDA-inspected plant), at 10–30 minutes per pound depending on the cut; cook-before-eating and fresh hams must reach 145 °F and rest 3 minutes. Check the temperature in the thickest part, away from the bone. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-party', 'tool' => 'ham_cook', 'fields' => ['cut', 'weight'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => ['ham' => config('food_data.ham')]]"
    :how-to="[
        ['name' => 'Choose the ham and cut', 'text' => ''],
        ['name' => 'Enter the weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long to heat an 8 lb spiral ham?', 'answer' => '1 h 20 min – 2 h 24 min at 325 °F.'],
        ['question' => 'A 12 lb bone-in fresh ham?', 'answer' => '4 h 24 min – 5 h 12 min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="cut" label="Ham" :options="collect(config('food_data.ham'))->groupBy(fn ($h) => ['fully_cooked' => 'Fully cooked (reheat)', 'cook_before' => 'Cook before eating (smoked)', 'fresh' => 'Fresh (uncooked)'][$h['type']])->map(fn ($rows) => $rows->mapWithKeys(fn ($h) => [$h['type'].'|'.$h['cut'] => ucfirst($h['cut']).' ('.$h['min_lb'].'–'.$h['max_lb'].' lb)'])->all())->all()" selected="fully_cooked|slices, half, or spiral cut" />
        <x-calc.field name="weight" label="Weight" value="8" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Cooking time" />

    <x-calc.options :decimals="false" :examples="[
        'Spiral 8 lb' => ['cut' => 'fully_cooked|slices, half, or spiral cut', 'weight' => 8, 'weight-unit' => 'lb'],
        'Fresh 12 lb' => ['cut' => 'fresh|whole leg, bone-in', 'weight' => 12, 'weight-unit' => 'lb'],
        'Half ham, 3 kg' => ['cut' => 'cook_before|bone-in, half', 'weight' => 3, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'target' => ['label' => 'Done at'],
            'perLb' => ['label' => 'Per pound'],
            'range' => ['label' => 'Chart weights'],
            'tip' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = weight × minutes per lb (USDA FSIS)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
