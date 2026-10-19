<x-calc.page
    title="LV Calculator - SolveKit"
    description="Free LV mass calculator: left ventricular mass and mass index from echo dimensions (LVIDd, IVSd, PWd) by the ASE cube formula, with relative wall thickness and geometry."
    lede="Calculate left ventricular mass."
    about="The ASE/EACVI linear (Devereux) formula: LV mass = 0.8 × 1.04 × [(IVSd + LVIDd + PWd)³ − LVIDd³] + 0.6 g, with dimensions in cm at end-diastole. Indexed to body surface area, over 95 g/m² in women or 115 g/m² in men is hypertrophy. Relative wall thickness (2 × PWd ÷ LVIDd) above 0.42 means concentric geometry. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'lv_mass', 'fields' => ['lvid', 'ivs', 'pw', 'sex', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter the three dimensions in cm', 'text' => 'Measured at end-diastole.'],
        ['name' => 'Enter sex, height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the LV mass with LVIDd 4.8, IVSd 1.0 and PWd 1.0 cm?', 'answer' => '170 g (87 g/m² (normal ≤ 115 for men); Normal geometry).'],
        ['question' => 'And IVSd and PWd 1.4 cm?', 'answer' => '257 g: Concentric hypertrophy.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="lvid" label="LVIDd" value="4.8" min="0" step="any" suffix="cm" />
        <x-calc.field name="ivs" label="IVSd" value="1.0" min="0" step="any" suffix="cm" />
        <x-calc.field name="pw" label="PWd" value="1.0" min="0" step="any" suffix="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
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

    <x-calc.result label="Left ventricular mass" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lvid' => 4.8, 'ivs' => 1.0, 'pw' => 1.0, 'sex' => 'male', 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
        'Thick' => ['lvid' => 4.6, 'ivs' => 1.4, 'pw' => 1.4, 'sex' => 'male', 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'index' => ['label' => 'Mass index'],
            'rwt' => ['label' => 'Relative wall thickness'],
            'geometry' => ['label' => 'Geometry'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LVM = 0.8 × 1.04 × ((IVS + LVID + PW)³ − LVID³) + 0.6</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
