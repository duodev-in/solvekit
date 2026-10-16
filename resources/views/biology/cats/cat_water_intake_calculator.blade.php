<x-calc.page
    title="Cat Water Intake Calculator - SolveKit"
    description="Free cat water intake calculator: daily water need and how much comes from wet food versus drinking."
    lede="Work out how much water your cat needs and how much it should drink."
    about="Cats need about 50 mL of water per kg a day in total. Wet food is about 75 to 80% water, so cats on wet food drink much less. Cats evolved from desert animals and often drink too little, which is linked to urinary problems."
    :calc="['engine' => 'pets', 'tool' => 'cat_water', 'fields' => ['weight', 'wet', 'moisture'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the weight', 'text' => 'In lb or kg.'],
        ['name' => 'Add wet food', 'text' => 'Grams a day and moisture from the label.'],
    ]"
    :faqs="[
        ['question' => 'How much water should a cat drink?', 'answer' => 'About 50 mL per kg a day in total, including water in food.'],
        ['question' => 'Why does my cat on wet food barely drink?', 'answer' => 'Wet food provides most of the water it needs.'],
        ['question' => 'When is drinking a concern?', 'answer' => 'A sudden increase can signal kidney disease, diabetes or hyperthyroidism.'],
    ]"
>
    <x-calc.field name="weight" label="Weight" value="10" min="0" placeholder="Weight">
        <label for="calc-weight-unit" class="sr-only">Weight unit</label>
        <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wet" label="Wet food a day" value="156" min="0" suffix="g" help="A 5.5 oz can is about 156 g" />
        <x-calc.field name="moisture" label="Wet food moisture" value="78" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Total water per day" />

    <x-calc.options :examples="[
        '10 lb, one can' => ['weight' => 10, 'weight-unit' => 'lb', 'wet' => 156, 'moisture' => 78],
        '5 kg, dry food only' => ['weight' => 5, 'weight-unit' => 'kg', 'wet' => 0, 'moisture' => 78],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'food' => ['label' => 'From food'],
            'drink' => ['label' => 'To drink'],
            'tip' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total ≈ 50 mL × kg</li>
            <li>from food = wet grams × moisture</li>
            <li>to drink = total − from food</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
