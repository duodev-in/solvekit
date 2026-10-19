<x-calc.page
    title="Height Calculator - SolveKit"
    description="Free child height calculator: predicted adult height from the parents' heights (mid-parental height), with the usual range."
    lede="Predict a child's adult height."
    about="Mid-parental height (Tanner 1970) averages the parents' heights and adds 6.5 cm (2.5 in) for boys or subtracts 6.5 cm for girls; about 95% of children end within ± 8.5 cm of it. Nutrition, health and timing of puberty move children within that range. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'adult_height', 'fields' => ['father', 'mother', 'sex'], 'unitFields' => ['father' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'mother' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter both parents\' heights', 'text' => ''],
        ['name' => 'Choose the child\'s sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How tall will a boy be with parents of 178 and 165 cm?', 'answer' => '178.0 cm (70.1 in).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="father" label="Father's height" value="178" min="0" placeholder="Father's height">
            <label for="calc-father-unit" class="sr-only">Father's height unit</label>
            <select id="calc-father-unit" name="father-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mother" label="Mother's height" value="165" min="0" placeholder="Mother's height">
            <label for="calc-mother-unit" class="sr-only">Mother's height unit</label>
            <select id="calc-mother-unit" name="mother-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Predicted adult height" />

    <x-calc.options :decimals="false" :examples="[
        'Boy' => ['father' => 178, 'father-unit' => 'cm', 'mother' => 165, 'mother-unit' => 'cm', 'sex' => 'male'],
        'Girl in feet' => ['father' => 6, 'father-unit' => 'ft', 'mother' => 5.33, 'mother-unit' => 'ft', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'method' => ['label' => 'Method'],
            'range' => ['label' => '95% range'],
            'feet' => ['label' => 'In feet and inches'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(father + mother ± 13 cm) ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
