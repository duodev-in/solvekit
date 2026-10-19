<x-calc.page
    title="Lean Body Mass Calculator - SolveKit"
    description="Free lean body mass calculator: lean mass by the Boer, James and Hume formulas, and the body fat they imply."
    lede="Estimate your lean body mass."
    about="Lean body mass is everything except fat: muscle, bone, organs and water. The Boer (1984), James (1976) and Hume (1966) equations estimate it from height, weight and sex; they are population averages, so a body-fat measurement is more accurate for one person. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'lean_mass', 'fields' => ['height', 'weight', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, weight and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the lean mass of a 175 cm, 80 kg man?', 'answer' => '60.1 kg (132.5 lb).'],
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

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Lean body mass (Boer)" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'sex' => 'male'],
        'Woman' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="Formulas" name="formulas" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Boer (men) = 0.407 W + 0.267 H − 19.2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
