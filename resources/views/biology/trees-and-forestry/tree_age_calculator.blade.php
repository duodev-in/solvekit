<x-calc.page
    title="Tree Age Calculator - SolveKit"
    description="Free tree age calculator: estimate a tree's age from its circumference and species growth factor."
    lede="Estimate a tree's age from its trunk size and species."
    about="Age ≈ trunk diameter (in inches) × a growth factor for the species. Factors are averages for trees in forests; open-grown and urban trees often grow faster, so they may be younger than estimated."
    :calc="['engine' => 'forestry', 'tool' => 'age', 'fields' => ['circumference', 'species'], 'unitFields' => ['circumference' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => config('biology_data.tree_growth_factors')]"
    :how-to="[
        ['name' => 'Measure the circumference', 'text' => 'At 4.5 ft above ground.'],
        ['name' => 'Pick the species', 'text' => 'Its growth factor fills in.'],
    ]"
    :faqs="[
        ['question' => 'How accurate is this?', 'answer' => 'It is an estimate; counting rings in a core sample is the only exact method.'],
        ['question' => 'Why do species differ?', 'answer' => 'Some trees, like cottonwood, grow fast; others, like hickory, slowly.'],
        ['question' => 'Does location matter?', 'answer' => 'Yes. Trees in the open usually grow faster than in a forest.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="circumference" label="Circumference at 4.5 ft" value="60" min="0" placeholder="Circumference at 4.5 ft">
            <label for="calc-circumference-unit" class="sr-only">Circumference at 4.5 ft unit</label>
            <select id="calc-circumference-unit" name="circumference-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="species" label="Species" :options="collect(config('biology_data.tree_growth_factors'))->map(fn ($item) => $item['name'])->all()" selected="white_oak" />
    </div>

    <x-calc.result label="Estimated age" />

    <x-calc.options :examples="[
        'White oak 100 in' => ['circumference' => 100, 'species' => 'white_oak'],
        'Silver maple 75 in' => ['circumference' => 75, 'species' => 'silver_maple'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'diameter' => ['label' => 'Diameter'],
            'factor' => ['label' => 'Growth factor'],
        ]" />
        <x-calc.quick-ref heading="Same trunk, other species" name="compare" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>age = (circumference ÷ π) × growth factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
