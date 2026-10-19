<x-calc.page
    title="Baby's Milk Intake Calculator - SolveKit"
    description="Free baby's milk intake calculator: how much breast milk or formula a baby takes a day and per feed by weight and age."
    lede="Estimate your baby's milk intake."
    about="In the early months babies take roughly 150 mL of milk per kg a day; exclusively breastfed babies average about 750–800 mL a day between 1 and 6 months, with a wide normal range (Kent et al. 2006). From about 6 months solid foods gradually replace some milk. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'milk', 'fields' => ['weight', 'age', 'feeds'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and age', 'text' => ''],
        ['name' => 'Enter feeds a day', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much milk does a 5 kg baby take a day?', 'answer' => '750 mL (25.4 oz) (About 94 mL (3.2 oz) per feed over 8 feeds).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="5" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="age" label="Age" :options="['newborn' => 'Under 1 month', 'young' => '1–6 months', 'older' => 'Over 6 months']" selected="young" />
        <x-calc.field name="feeds" label="Feeds a day" value="8" min="1" max="14" step="1" />
    </div>

    <x-calc.result label="Milk a day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 5, 'weight-unit' => 'kg', 'age' => 'young', 'feeds' => 8],
        'Older baby' => ['weight' => 8, 'weight-unit' => 'kg', 'age' => 'older', 'feeds' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rule' => ['label' => 'Rule'],
            'typical' => ['label' => 'Typical intake'],
            'note' => ['label' => 'Signs of enough'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mL/day ≈ 150 × kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
