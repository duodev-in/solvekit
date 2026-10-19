<x-calc.page
    title="Aortic Valve Area Calculator - SolveKit"
    description="Free aortic valve area calculator: AVA by the continuity equation from LVOT diameter and the LVOT and aortic valve VTIs (or peak velocities), with the stenosis grade."
    lede="Calculate aortic valve area."
    about="Continuity equation: AVA = LVOT area × VTI(LVOT) ÷ VTI(AV), where LVOT area = π × (d ÷ 2)². Peak velocities can stand in for VTIs. ASE/EACVI 2017: over 1.5 cm² mild, 1.0–1.5 moderate and under 1.0 cm² severe aortic stenosis (indexed under 0.6 cm²/m²). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'ava', 'fields' => ['lvot', 'vti_lvot', 'vti_av', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter the LVOT diameter', 'text' => ''],
        ['name' => 'Enter both VTIs or both velocities', 'text' => 'In the same units.'],
    ]"
    :faqs="[
        ['question' => 'What is the AVA for a 2.0 cm LVOT, LVOT VTI 20 cm and AV VTI 80 cm?', 'answer' => '0.79 cm²: Severe aortic stenosis (under 1.0 cm²).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="lvot" label="LVOT diameter" value="2.0" min="0" step="any" suffix="cm" />
        <x-calc.field name="vti_lvot" label="LVOT VTI (or peak velocity)" value="20" min="0" step="any" suffix="cm" />
        <x-calc.field name="vti_av" label="Aortic valve VTI (or peak velocity)" value="80" min="0" step="any" suffix="cm" />
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

    <x-calc.result label="Aortic valve area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lvot' => 2, 'vti_lvot' => 20, 'vti_av' => 80, 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
        'Moderate' => ['lvot' => 2.1, 'vti_lvot' => 22, 'vti_av' => 55, 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'indexed' => ['label' => 'Indexed AVA'],
            'ratio' => ['label' => 'Velocity ratio'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AVA = π (d/2)² × VTI₁ ÷ VTI₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
