<x-calc.page
    title="Protein Calculator - SolveKit"
    description="Free protein calculator: grams of protein a day for your weight and goal, from the RDA (0.8 g/kg) to ISSN ranges for training and older adults."
    lede="Find how much protein you need."
    about="The RDA is 0.8 g per kg for healthy adults (1.1 g/kg in later pregnancy). Active people often need 1.2–1.6 g/kg and those building muscle 1.6–2.2 g/kg (International Society of Sports Nutrition), and adults over 65 benefit from 1.0–1.2 g/kg (PROT-AGE study group). Spreading it over meals helps. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'protein', 'fields' => ['weight', 'goal'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and situation', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much protein does an 80 kg person who exercises need?', 'answer' => '96–128 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="goal" label="Situation" :options="['rda' => 'Healthy adult, little exercise', 'active' => 'Regular exercise', 'strength' => 'Building muscle', 'older' => 'Over 65', 'pregnant' => 'Pregnant (2nd–3rd trimester)']" selected="active" />
    </div>

    <x-calc.result label="Protein a day" />

    <x-calc.options :decimals="false" :examples="[
        'Active' => ['weight' => 80, 'weight-unit' => 'kg', 'goal' => 'active'],
        'Older adult' => ['weight' => 150, 'weight-unit' => 'lb', 'goal' => 'older'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'perMeal' => ['label' => 'Per meal'],
            'rda' => ['label' => 'RDA'],
            'kidney' => ['label' => 'Kidney disease'],
        ]" />
        <x-calc.grid heading="Situations" name="goals" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>g = kg × g/kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
