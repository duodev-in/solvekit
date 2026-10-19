<x-calc.page
    title="Breastfeeding Calorie Calculator - SolveKit"
    description="Free breastfeeding calorie calculator: the calories you need while breastfeeding, from the IOM energy equations plus the lactation allowance."
    lede="Work out your calories while breastfeeding."
    about="The Institute of Medicine (2005) adds 330 kcal a day in the first 6 months of exclusive breastfeeding (500 kcal for milk minus 170 kcal from gradual weight loss) and 400 kcal from 7 to 12 months, on top of the usual Estimated Energy Requirement. Partial breastfeeding is taken as half. Hunger is a good guide; a slow, steady weight loss is normal. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'breastfeeding', 'fields' => ['height', 'weight', 'age', 'pa', 'stage', 'feeding'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Choose the baby\'s age and feeding', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories does a low-active 30-year-old, 165 cm, 65 kg, need while exclusively breastfeeding a 3-month-old?', 'answer' => '2,500 kcal/day (2,170 kcal + 330 kcal for exclusive breastfeeding (0–6 months)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="height" label="Height" value="165" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="65" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="30" min="0" step="1" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="pa" label="Physical activity" :options="['sedentary' => 'Sedentary', 'low' => 'Low active', 'active' => 'Active', 'very' => 'Very active']" selected="low" />
        <x-calc.select name="stage" label="Baby's age" :options="['early' => '0–6 months', 'late' => '7–12 months']" selected="early" />
        <x-calc.segmented name="feeding" legend="Breastfeeding" :options="['exclusive' => 'Exclusive', 'partial' => 'Partial']" selected="exclusive" />
    </div>

    <x-calc.result label="Energy while breastfeeding" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 65, 'weight-unit' => 'kg', 'age' => 30, 'pa' => 'low', 'stage' => 'early', 'feeding' => 'exclusive'],
        'Partial, older baby' => ['height' => 160, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'age' => 34, 'pa' => 'active', 'stage' => 'late', 'feeding' => 'partial'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'base' => ['label' => 'Without breastfeeding'],
            'extra' => ['label' => 'Lactation'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal = EER + 330 (0–6 mo) or 400</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
