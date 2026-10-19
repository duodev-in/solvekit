<x-calc.page
    title="Cardiac Output Calculator - SolveKit"
    description="Free cardiac output calculator: from heart rate and stroke volume, or by the Fick principle from oxygen consumption and arterial and mixed venous saturations, with cardiac index."
    lede="Calculate cardiac output."
    about="Cardiac output is the blood the heart pumps each minute: CO = heart rate × stroke volume, normally 4–8 L/min at rest. The Fick principle gives CO = VO₂ ÷ (CaO₂ − CvO₂), with oxygen content = 1.34 × Hb × saturation. Dividing by body surface area gives the cardiac index. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'cardiac_output', 'fields' => ['mode', 'hr', 'sv', 'vo2', 'sao2', 'svo2', 'hb', 'hb_unit', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter the measurements', 'text' => ''],
        ['name' => 'Add height and weight', 'text' => 'For the cardiac index.'],
    ]"
    :faqs="[
        ['question' => 'What is the cardiac output at 75 bpm and 70 mL stroke volume?', 'answer' => '5.25 L/min.'],
        ['question' => 'And by Fick with VO₂ 250, Hb 14, SaO₂ 98% and SvO₂ 70%?', 'answer' => '4.76 L/min.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['hrsv' => 'Heart rate × stroke volume', 'fick' => 'Fick principle']" selected="hrsv" />

    <div data-show-when="mode:hrsv">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hr" label="Heart rate" value="75" min="0" max="300" step="1" suffix="bpm" />
            <x-calc.field name="sv" label="Stroke volume" value="70" min="0" step="any" suffix="mL" />
        </div>
    </div>

    <div data-show-when="mode:fick" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="vo2" label="Oxygen consumption (VO₂)" value="250" min="0" step="any" suffix="mL/min" />
            <x-calc.field name="sao2" label="Arterial saturation (SaO₂)" value="98" min="0" max="100" step="any" suffix="%" />
            <x-calc.field name="svo2" label="Mixed venous saturation (SvO₂)" value="70" min="0" max="100" step="any" suffix="%" />
        </div>
    </div>

    <div data-show-when="mode:fick" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hb" label="Hemoglobin" value="14" min="0" step="any" />
            <x-calc.select name="hb_unit" label="Hemoglobin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L', 'mmol/L' => 'mmol/L']" selected="g/dL" />
        </div>
    </div>

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

    <x-calc.result label="Cardiac output" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'hrsv', 'hr' => 75, 'sv' => 70, 'vo2' => 250, 'sao2' => 98, 'svo2' => 70, 'hb' => 14, 'hb_unit' => 'g/dL', 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
        'Fick' => ['mode' => 'fick', 'hr' => 75, 'sv' => 70, 'vo2' => 250, 'sao2' => 98, 'svo2' => 70, 'hb' => 14, 'hb_unit' => 'g/dL', 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'index' => ['label' => 'Cardiac index'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CO = HR × SV</li>
            <li>CO = VO₂ ÷ (CaO₂ − CvO₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
