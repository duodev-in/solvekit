<x-calc.page
    title="EER Calculator — Estimated Energy Requirement - SolveKit"
    description="Free EER calculator: Estimated Energy Requirement from the Institute of Medicine equations for children (3+) and adults, with pregnancy and lactation additions."
    lede="Calculate your Estimated Energy Requirement."
    about="The IOM (2005) EER equations predict the energy to keep weight stable from age, sex, height, weight and a physical activity coefficient (for example men 662 − 9.53 × age + PA × (15.91 × kg + 539.6 × m)). Pregnancy adds 340 kcal (2nd trimester) or 452 kcal (3rd), breastfeeding 330 or 400 kcal. NASEM updated the equations in 2023 with similar results. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'eer', 'fields' => ['height', 'weight', 'age', 'sex', 'pa', 'state'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Choose activity and life stage', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the EER of a low-active 35-year-old man, 175 cm, 80 kg?', 'answer' => '2,789 kcal/day kcal a day.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="pa" label="Physical activity level" :options="['sedentary' => 'Sedentary', 'low' => 'Low active', 'active' => 'Active', 'very' => 'Very active']" selected="low" />
        <x-calc.select name="state" label="Pregnancy or lactation" :options="['none' => 'Neither', 'preg2' => 'Pregnant, 2nd trimester', 'preg3' => 'Pregnant, 3rd trimester', 'lact1' => 'Breastfeeding, 0–6 months', 'lact2' => 'Breastfeeding, 7–12 months']" selected="none" />
    </div>

    <x-calc.result label="Estimated Energy Requirement" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'pa' => 'low', 'state' => 'none'],
        'Pregnant' => ['height' => 163, 'height-unit' => 'cm', 'weight' => 65, 'weight-unit' => 'kg', 'age' => 30, 'sex' => 'female', 'pa' => 'low', 'state' => 'preg2'],
        'Child 10' => ['height' => 140, 'height-unit' => 'cm', 'weight' => 33, 'weight-unit' => 'kg', 'age' => 10, 'sex' => 'female', 'pa' => 'active', 'state' => 'none'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'base' => ['label' => 'Base EER'],
            'extra' => ['label' => 'Pregnancy or lactation'],
            'levels' => ['label' => 'All activity levels'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EER = a − b × age + PA × (c × kg + d × m)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
