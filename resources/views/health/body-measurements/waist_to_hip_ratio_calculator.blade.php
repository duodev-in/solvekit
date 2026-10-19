<x-calc.page
    title="Waist to Hip Ratio Calculator - SolveKit"
    description="Free waist to hip ratio calculator: WHR and whether it means increased health risk, using the WHO cut-offs."
    lede="Work out your waist-to-hip ratio."
    about="Waist-to-hip ratio = waist ÷ hip. WHO (2008) treats 0.90 or more in men and 0.85 or more in women as substantially increased risk of metabolic complications. Measure the waist midway between the lowest rib and the hip bone, and the hips at the widest point. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'whr', 'fields' => ['waist', 'hip', 'sex'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'hip' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure waist and hips', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the WHR of an 86 cm waist and 100 cm hips (man)?', 'answer' => '0.86 (Below 0.9: not increased (WHO 2008)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waist" label="Waist" value="86" min="0" placeholder="Waist">
            <label for="calc-waist-unit" class="sr-only">Waist unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hip" label="Hip" value="100" min="0" placeholder="Hip">
            <label for="calc-hip-unit" class="sr-only">Hip unit</label>
            <select id="calc-hip-unit" name="hip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Waist-to-hip ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['waist' => 86, 'waist-unit' => 'cm', 'hip' => 100, 'hip-unit' => 'cm', 'sex' => 'male'],
        'Woman' => ['waist' => 82, 'waist-unit' => 'cm', 'hip' => 94, 'hip-unit' => 'cm', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cutoff' => ['label' => 'Cut-off'],
            'shape' => ['label' => 'Shape'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>WHR = waist ÷ hip</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
