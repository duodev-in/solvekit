<x-calc.page
    title="Total Body Water Calculator - SolveKit"
    description="Free total body water calculator: total body water from height, weight, age and sex by the Watson and Hume–Weyers equations."
    lede="Estimate total body water."
    about="Watson et al. (1980): men TBW = 2.447 − 0.09516 × age + 0.1074 × height (cm) + 0.3362 × weight (kg); women −2.097 + 0.1069 × height + 0.2466 × weight. Total body water is about 50–60% of body weight, lower with more body fat and in older age. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'tbw', 'fields' => ['height', 'weight', 'age', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => ''],
        ['name' => 'Enter age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the TBW of a 50-year-old man, 170 cm, 70 kg?', 'answer' => '39.5 L (56% of body weight).'],
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
        <x-calc.field name="age" label="Age" value="50" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Total body water" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 170, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'age' => 50, 'sex' => 'male'],
        'Woman' => ['height' => 160, 'height-unit' => 'cm', 'weight' => 60, 'weight-unit' => 'kg', 'age' => 40, 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hume' => ['label' => 'Hume–Weyers'],
            'simple' => ['label' => 'Simple fraction'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Watson TBW equations</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
