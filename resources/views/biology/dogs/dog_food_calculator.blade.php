<x-calc.page
    title="Dog Food Calculator - SolveKit"
    description="Free dog food calculator: grams and cups of food per day and per meal from your dog's energy needs and the food's calories."
    lede="Work out how much food to give your dog each day."
    about="Daily calories (RER × life-stage factor) are divided by the food's energy density, printed on the bag as kcal per kg and kcal per cup. Bag guides are often generous, so this usually gives a more accurate starting point; adjust by body condition."
    :calc="['engine' => 'pets', 'tool' => 'dog_food', 'fields' => ['weight', 'stage', 'kcal_kg', 'kcal_cup', 'meals', 'bag'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'bag' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and stage', 'text' => 'Use ideal weight for weight loss.'],
        ['name' => 'Copy the label', 'text' => 'kcal/kg and kcal/cup from the bag.'],
        ['name' => 'Add a bag size', 'text' => 'To see how long it lasts.'],
    ]"
    :faqs="[
        ['question' => 'How much should I feed my dog?', 'answer' => 'Enough calories for an ideal body condition; this gives a starting amount.'],
        ['question' => 'What is a cup?', 'answer' => 'An 8 fl oz measuring cup, not a mug; weighing food is more accurate.'],
        ['question' => 'Should I feed what the bag says?', 'answer' => 'Use it as a guide; many dogs need 10 to 20% less.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="30" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="stage" label="Life stage" :options="['neutered' => 'Neutered adult (× 1.6)', 'intact' => 'Intact adult (× 1.8)', 'inactive' => 'Inactive or prone to weight gain (× 1.2)', 'loss' => 'Weight loss, at ideal weight (× 1.0)', 'senior' => 'Senior (× 1.4)', 'puppy_young' => 'Puppy under 4 months (× 3.0)', 'puppy' => 'Puppy 4 months to adult (× 2.0)', 'light_work' => 'Light work (× 2.0)', 'moderate_work' => 'Moderate work (× 3.0)', 'heavy_work' => 'Heavy work (× 4.0)']" selected="neutered" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="kcal_kg" label="Food energy" value="3600" min="0" suffix="kcal/kg" />
        <x-calc.field name="kcal_cup" label="Per cup (optional)" value="380" min="0" suffix="kcal/cup" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="meals" label="Meals per day" value="2" min="1" step="1" />
        <x-calc.field name="bag" label="Bag size (optional)" value="30" min="0" placeholder="Bag size (optional)">
            <label for="calc-bag-unit" class="sr-only">Bag size (optional) unit</label>
            <select id="calc-bag-unit" name="bag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Food per day" />

    <x-calc.options :examples="[
        '30 lb dog, kibble' => ['weight' => 30, 'weight-unit' => 'lb', 'stage' => 'neutered', 'kcal_kg' => 3600, 'kcal_cup' => 380, 'meals' => 2],
        '12 kg puppy' => ['weight' => 12, 'weight-unit' => 'kg', 'stage' => 'puppy', 'kcal_kg' => 4000, 'kcal_cup' => 420, 'meals' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cups' => ['label' => 'Cups'],
            'meal' => ['label' => 'Per meal'],
            'week' => ['label' => 'Per week'],
            'bag' => ['label' => 'Bag lasts'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal/day = 70 × kg^0.75 × factor</li>
            <li>grams = kcal/day ÷ kcal per kg × 1000</li>
            <li>cups = kcal/day ÷ kcal per cup</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
