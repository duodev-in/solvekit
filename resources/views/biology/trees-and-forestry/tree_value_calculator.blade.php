<x-calc.page
    title="Tree Value Calculator - SolveKit"
    description="Free tree value calculator: estimate a landscape tree's appraised value with the trunk formula method."
    lede="Estimate a landscape tree's value with the trunk formula method."
    about="The trunk formula multiplies the trunk's cross-section (square inches) by a unit price, then by species, condition and location ratings. Unit prices are set regionally; a certified arborist gives a formal appraisal."
    :calc="['engine' => 'forestry', 'tool' => 'value', 'fields' => ['dbh', 'price', 'species', 'condition', 'location'], 'unitFields' => ['dbh' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the diameter and unit price', 'text' => 'Unit prices come from regional plant appraisal guides.'],
        ['name' => 'Rate the tree', 'text' => 'Species, condition and location, 0 to 100%.'],
    ]"
    :faqs="[
        ['question' => 'Who uses the trunk formula?', 'answer' => 'Arborists and insurers, for trees too large to replace with nursery stock.'],
        ['question' => 'What does condition cover?', 'answer' => 'Health and structure: decay, dieback, defects.'],
        ['question' => 'Is this a legal appraisal?', 'answer' => 'No. It is an estimate; hire a certified arborist for a formal value.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dbh" label="Trunk diameter" value="18" min="0" placeholder="Trunk diameter">
            <label for="calc-dbh-unit" class="sr-only">Trunk diameter unit</label>
            <select id="calc-dbh-unit" name="dbh-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Unit price per in²" value="40" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="species" label="Species rating" value="80" min="0" max="100" suffix="%" />
        <x-calc.field name="condition" label="Condition" value="70" min="0" max="100" suffix="%" />
        <x-calc.field name="location" label="Location" value="80" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Appraised value (estimate)" />

    <x-calc.options :examples="[
        'Healthy oak 24 in' => ['dbh' => 24, 'price' => 40, 'species' => 90, 'condition' => 85, 'location' => 80],
        'Declining maple 16 in' => ['dbh' => 16, 'price' => 40, 'species' => 70, 'condition' => 40, 'location' => 70],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Trunk area'],
            'basic' => ['label' => 'Basic value'],
            'factors' => ['label' => 'Ratings'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = π ÷ 4 × DBH² × unit price × species × condition × location</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
