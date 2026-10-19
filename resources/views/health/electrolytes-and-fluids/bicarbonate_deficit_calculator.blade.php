<x-calc.page
    title="Bicarbonate Deficit Calculator - SolveKit"
    description="Free bicarbonate deficit calculator: the estimated bicarbonate deficit in metabolic acidosis from weight and the current and target HCO₃."
    lede="Estimate the bicarbonate deficit."
    about="Bicarbonate deficit (mEq) = distribution factor × weight (kg) × (target HCO₃ − current HCO₃). The factor is usually 0.4–0.5 L/kg and rises in severe acidosis. This shows the size of the deficit for teaching; it is not a replacement order, and bicarbonate therapy is a clinical decision. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'bicarb_deficit', 'fields' => ['weight', 'hco3', 'target', 'factor'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight', 'text' => ''],
        ['name' => 'Enter current and target HCO₃', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the deficit for 70 kg, HCO₃ 10 to 15?', 'answer' => '175 mEq.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hco3" label="Current HCO₃" value="10" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="target" label="Target HCO₃" value="15" min="0" step="any" suffix="mmol/L" />
    </div>

    <x-calc.field name="factor" label="Distribution factor" value="0.5" min="0" step="0.05" suffix="L/kg" />

    <x-calc.result label="Bicarbonate deficit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 70, 'weight-unit' => 'kg', 'hco3' => 10, 'target' => 15, 'factor' => 0.5],
        'Severe' => ['weight' => 80, 'weight-unit' => 'kg', 'hco3' => 6, 'target' => 12, 'factor' => 0.6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Factor'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deficit = 0.5 × kg × (target − HCO₃)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
