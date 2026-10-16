<x-calc.page
    title="Cat Calorie Calculator - SolveKit"
    description="Free cat calorie calculator: resting and daily energy needs in kcal from weight and life stage."
    lede="Work out how many calories your cat needs each day."
    about="Resting energy is RER = 70 × weight(kg)^0.75. Daily need is RER times a life-stage factor (WSAVA): about 1.2 for neutered adults, 1.4 intact and 2.5 for kittens. For weight loss use 0.8 × RER at the ideal weight."
    :calc="['engine' => 'pets', 'tool' => 'cat_calories', 'fields' => ['weight', 'stage'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the weight', 'text' => 'Ideal weight for weight loss.'],
        ['name' => 'Pick the life stage', 'text' => 'Neutered adult is the most common.'],
    ]"
    :faqs="[
        ['question' => 'How many calories does a cat need?', 'answer' => 'About 200 to 250 kcal a day for a 10 lb neutered adult.'],
        ['question' => 'How fast should a cat lose weight?', 'answer' => 'About 0.5 to 2% of body weight a week; fast loss is dangerous for cats.'],
        ['question' => 'Do treats count?', 'answer' => 'Yes, keep them under 10% of calories.'],
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

    <x-calc.result label="Daily energy need" />

    <x-calc.options :examples="[
        '10 lb neutered' => ['weight' => 10, 'weight-unit' => 'lb', 'stage' => 'neutered'],
        '2 kg kitten' => ['weight' => 2, 'weight-unit' => 'kg', 'stage' => 'kitten'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rer' => ['label' => 'Resting energy (RER)'],
            'factor' => ['label' => 'Life-stage factor'],
            'treats' => ['label' => 'Treat limit'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RER = 70 × kg^0.75</li>
            <li>daily kcal = RER × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
