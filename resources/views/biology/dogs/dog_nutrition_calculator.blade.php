<x-calc.page
    title="Dog Nutrition Calculator - SolveKit"
    description="Free dog calorie calculator: resting and daily energy needs in kcal from weight and life stage, with AAFCO protein and fat minimums."
    lede="Work out how many calories your dog needs each day."
    about="Resting energy is RER = 70 × weight(kg)^0.75. Daily need is RER times a factor for life stage and activity (WSAVA): about 1.6 for a neutered adult, 1.8 intact, 2 to 3 for growing puppies and more for working dogs. Every dog differs, so adjust by body condition."
    :calc="['engine' => 'pets', 'tool' => 'dog_nutrition', 'fields' => ['weight', 'stage'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the weight', 'text' => 'Ideal weight if your dog needs to lose.'],
        ['name' => 'Pick the life stage', 'text' => 'Neutered adult is the most common.'],
    ]"
    :faqs="[
        ['question' => 'How many calories does a 30 lb dog need?', 'answer' => 'About 750 kcal a day as a neutered adult.'],
        ['question' => 'Do treats count?', 'answer' => 'Yes, keep treats under 10% of daily calories.'],
        ['question' => 'Why does neutering lower the need?', 'answer' => 'It reduces metabolic rate, so neutered dogs gain weight more easily.'],
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

    <x-calc.result label="Daily energy need" />

    <x-calc.options :examples="[
        '30 lb neutered' => ['weight' => 30, 'weight-unit' => 'lb', 'stage' => 'neutered'],
        '10 kg puppy' => ['weight' => 10, 'weight-unit' => 'kg', 'stage' => 'puppy'],
        '25 kg working dog' => ['weight' => 25, 'weight-unit' => 'kg', 'stage' => 'moderate_work'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rer' => ['label' => 'Resting energy (RER)'],
            'factor' => ['label' => 'Life-stage factor'],
            'protein' => ['label' => 'Protein'],
            'fat' => ['label' => 'Fat'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RER = 70 × kg^0.75</li>
            <li>daily kcal = RER × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
