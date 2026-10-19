<x-calc.page
    title="Metabolic Syndrome Calculator - SolveKit"
    description="Free metabolic syndrome calculator: check the five harmonised criteria (waist, triglycerides, HDL, blood pressure, fasting glucose); three or more means metabolic syndrome."
    lede="Check the criteria for metabolic syndrome."
    about="The harmonised definition (Alberti et al., Circulation 2009) counts five criteria: large waist (population-specific cut-offs), triglycerides 150 mg/dL or more, HDL under 40 (men) or 50 (women), blood pressure 130/85 or more, and fasting glucose 100 or more; treatment for any of these counts too. Three or more means metabolic syndrome. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'metsyn', 'fields' => ['sex', 'population', 'waist', 'tg', 'tg_unit', 'hdl', 'hdl_unit', 'sbp', 'dbp', 'glucose', 'glucose_unit', 'tg_treat', 'hdl_treat', 'bp_treat', 'glucose_treat'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Enter the five measures', 'text' => ''],
        ['name' => 'Tick any treatment', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Does a man with a 104 cm waist, TG 180, HDL 38, BP 128/82 and glucose 105 have metabolic syndrome?', 'answer' => '4 of 5: Meets the definition of metabolic syndrome (3 or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.select name="population" label="Waist cut-offs" :options="['us' => 'US and Canada (102 / 88 cm)', 'europid' => 'Europe and others (94 / 80 cm)', 'asian' => 'Asian (90 / 80 cm)']" selected="us" />
    </div>

    <x-calc.field name="waist" label="Waist" value="104" min="0" placeholder="Waist">
        <label for="calc-waist-unit" class="sr-only">Waist unit</label>
        <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tg" label="Triglycerides" value="180" min="0" step="any" />
        <x-calc.select name="tg_unit" label="Triglycerides unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hdl" label="HDL" value="38" min="0" step="any" />
        <x-calc.select name="hdl_unit" label="HDL unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sbp" label="Systolic BP" value="128" min="60" step="1" suffix="mmHg" />
        <x-calc.field name="dbp" label="Diastolic BP" value="82" min="30" step="1" suffix="mmHg" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="glucose" label="Fasting glucose" value="105" min="0" step="any" />
        <x-calc.select name="glucose_unit" label="Fasting glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.checkbox name="tg_treat" label="Treated for high TG" :checked="false" />
        <x-calc.checkbox name="hdl_treat" label="Treated for low HDL" :checked="false" />
        <x-calc.checkbox name="bp_treat" label="On blood-pressure medicine" :checked="false" />
        <x-calc.checkbox name="glucose_treat" label="On glucose-lowering medicine" :checked="false" />
    </div>

    <x-calc.result label="Criteria met" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sex' => 'male', 'population' => 'us', 'waist' => 104, 'waist-unit' => 'cm', 'tg' => 180, 'tg_unit' => 'mg/dL', 'hdl' => 38, 'hdl_unit' => 'mg/dL', 'sbp' => 128, 'dbp' => 82, 'glucose' => 105, 'glucose_unit' => 'mg/dL', 'tg_treat' => false, 'hdl_treat' => false, 'bp_treat' => false, 'glucose_treat' => false],
        'Woman' => ['sex' => 'female', 'population' => 'asian', 'waist' => 78, 'waist-unit' => 'cm', 'tg' => 1.2, 'tg_unit' => 'mmol/L', 'hdl' => 1.4, 'hdl_unit' => 'mmol/L', 'sbp' => 118, 'dbp' => 76, 'glucose' => 5.2, 'glucose_unit' => 'mmol/L', 'tg_treat' => false, 'hdl_treat' => false, 'bp_treat' => false, 'glucose_treat' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'result' => ['label' => 'Result'],
            'source' => ['label' => 'Definition'],
        ]" />
        <x-calc.grid heading="Criteria" name="criteria" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>3 or more of 5 criteria</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
