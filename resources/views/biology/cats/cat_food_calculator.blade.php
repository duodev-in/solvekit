<x-calc.page
    title="Cat Food Calculator - SolveKit"
    description="Free cat food calculator: cans of wet food and cups of dry food per day for your cat's calorie needs."
    lede="Work out how much wet and dry food to feed your cat."
    about="Daily calories (RER × life-stage factor) are split between wet and dry food by the share you choose, then divided by the calories in a can and in a cup from the labels."
    :calc="['engine' => 'pets', 'tool' => 'cat_food', 'fields' => ['weight', 'stage', 'wet_share', 'kcal_can', 'kcal_cup', 'meals'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and stage', 'text' => 'Ideal weight for weight loss.'],
        ['name' => 'Set the split', 'text' => 'Share of calories from wet food.'],
        ['name' => 'Copy the labels', 'text' => 'kcal per can and per cup.'],
    ]"
    :faqs="[
        ['question' => 'How much should I feed my cat?', 'answer' => 'About 200 to 250 kcal a day for a 10 lb neutered adult, adjusted for body condition.'],
        ['question' => 'Is wet or dry food better?', 'answer' => 'Both can be complete; wet food adds water.'],
        ['question' => 'How many meals a day?', 'answer' => 'Two or more small meals suit most cats.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="10" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="stage" label="Life stage" :options="['neutered' => 'Neutered adult (× 1.2)', 'intact' => 'Intact adult (× 1.4)', 'inactive' => 'Inactive or prone to weight gain (× 1.0)', 'loss' => 'Weight loss, at ideal weight (× 0.8)', 'senior' => 'Senior (× 1.1)', 'kitten' => 'Kitten (× 2.5)']" selected="neutered" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="wet_share" label="From wet food" value="50" min="0" max="100" suffix="%" />
        <x-calc.field name="kcal_can" label="Per can" value="160" min="0" suffix="kcal" />
        <x-calc.field name="kcal_cup" label="Per cup dry" value="450" min="0" suffix="kcal" />
    </div>

    <x-calc.field name="meals" label="Meals per day" value="2" min="1" step="1" />

    <x-calc.result label="Food per day" />

    <x-calc.options :examples="[
        'Half and half' => ['weight' => 10, 'weight-unit' => 'lb', 'stage' => 'neutered', 'wet_share' => 50, 'kcal_can' => 160, 'kcal_cup' => 450, 'meals' => 2],
        'Wet only' => ['weight' => 4, 'weight-unit' => 'kg', 'stage' => 'neutered', 'wet_share' => 100, 'kcal_can' => 90, 'kcal_cup' => 450, 'meals' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'wet' => ['label' => 'Calories from wet'],
            'dry' => ['label' => 'Calories from dry'],
            'meal' => ['label' => 'Per meal'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal/day = 70 × kg^0.75 × factor</li>
            <li>cans = kcal × wet share ÷ kcal per can</li>
            <li>cups = kcal × dry share ÷ kcal per cup</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
