<x-calc.page
    title="Iron Deficiency Calculator - SolveKit"
    description="Free iron deficiency calculator: total body iron deficit by the Ganzoni formula from weight, current and target haemoglobin and iron stores."
    lede="Estimate the total iron deficit (Ganzoni)."
    about="Ganzoni (1970): total iron deficit (mg) = weight (kg) × (target Hb − actual Hb) (g/dL) × 2.4 + iron stores, with stores 500 mg for 35 kg or more (15 mg/kg below) and target Hb 15 g/dL (13 under 35 kg). It describes the body's shortfall; the iron product and amount are prescribed by a clinician. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'iron_deficit', 'fields' => ['weight', 'hb', 'hb_unit', 'target'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and haemoglobin', 'text' => ''],
        ['name' => 'Adjust the target', 'text' => 'Default 15 g/dL.'],
    ]"
    :faqs="[
        ['question' => 'What is the iron deficit for 70 kg with Hb 9?', 'answer' => '1,508 mg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hb" label="Haemoglobin" value="9" min="0" step="any" />
            <x-calc.select name="hb_unit" label="Haemoglobin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L', 'mmol/L' => 'mmol/L']" selected="g/dL" />
        </div>
    </div>

    <x-calc.field name="target" label="Target haemoglobin" value="15" min="0" step="any" suffix="g/dL" />

    <x-calc.result label="Total iron deficit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 70, 'weight-unit' => 'kg', 'hb' => 9, 'hb_unit' => 'g/dL', 'target' => 15],
        'SI' => ['weight' => 60, 'weight-unit' => 'kg', 'hb' => 95, 'hb_unit' => 'g/L', 'target' => 13],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'stores' => ['label' => 'Iron stores'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deficit = kg × (target − Hb) × 2.4 + stores</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
