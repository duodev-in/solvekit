<x-calc.page
    title="Doppler Echo Cardiac Output Calculator - SolveKit"
    description="Free Doppler echo cardiac output calculator: stroke volume and cardiac output from the LVOT diameter, LVOT velocity-time integral and heart rate."
    lede="Calculate cardiac output from echo."
    about="On echocardiography, stroke volume = LVOT cross-sectional area × LVOT VTI, where area = π × (diameter ÷ 2)² measured in mid-systole. Cardiac output = stroke volume × heart rate. Small errors in the diameter are squared, so measure carefully. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'doppler_co', 'fields' => ['lvot', 'vti', 'hr', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter the LVOT diameter and VTI', 'text' => ''],
        ['name' => 'Enter the heart rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the output for a 2.0 cm LVOT, 20 cm VTI and 75 bpm?', 'answer' => '4.71 L/min (Stroke volume 63 mL × 75 bpm).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="lvot" label="LVOT diameter" value="2.0" min="0" step="any" suffix="cm" />
        <x-calc.field name="vti" label="LVOT VTI" value="20" min="0" step="any" suffix="cm" />
        <x-calc.field name="hr" label="Heart rate" value="75" min="0" max="300" step="1" suffix="bpm" />
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

    <x-calc.result label="Cardiac output (Doppler)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lvot' => 2, 'vti' => 20, 'hr' => 75, 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
        'Low flow' => ['lvot' => 2.1, 'vti' => 12, 'hr' => 95, 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sv' => ['label' => 'Stroke volume'],
            'area' => ['label' => 'LVOT area'],
            'index' => ['label' => 'Cardiac index'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SV = π (d/2)² × VTI</li>
            <li>CO = SV × HR</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
