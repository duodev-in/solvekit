<x-calc.page
    title="Pediatric GFR Calculator - Glomerular Filtration Rate - SolveKit"
    description="Free pediatric GFR calculator: estimated GFR for children and teenagers from height and creatinine by the bedside Schwartz equation."
    lede="Estimate a child's kidney function."
    about="The bedside Schwartz equation (Schwartz et al. 2009) estimates GFR in children aged 1–18: eGFR = 0.413 × height (cm) ÷ serum creatinine (mg/dL), for creatinine measured by an enzymatic (IDMS-traceable) method. Normal children have an eGFR of about 90–120 mL/min/1.73 m² after age 2. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'ped_gfr', 'fields' => ['height', 'cr', 'cr_unit'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter height', 'text' => ''],
        ['name' => 'Enter creatinine', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the eGFR for a 130 cm child with creatinine 0.5 mg/dL?', 'answer' => '107 mL/min/1.73 m².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="130" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="cr" label="Creatinine" value="0.5" min="0" step="any" />
            <x-calc.select name="cr_unit" label="Creatinine unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
        </div>
    </div>

    <x-calc.result label="eGFR (bedside Schwartz)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 130, 'height-unit' => 'cm', 'cr' => 0.5, 'cr_unit' => 'mg/dL'],
        'Teen' => ['height' => 165, 'height-unit' => 'cm', 'cr' => 80, 'cr_unit' => 'µmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>eGFR = 0.413 × height ÷ creatinine</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
