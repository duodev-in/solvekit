<x-calc.page
    title="Tidal Volume Calculator - SolveKit"
    description="Free tidal volume calculator: lung-protective tidal volume from predicted body weight (ARDSnet) at 4–8 mL/kg."
    lede="Calculate a lung-protective tidal volume."
    about="Lung-protective ventilation (ARDS Network 2000) uses predicted body weight, not actual weight: PBW = 50 kg (men) or 45.5 kg (women) + 0.91 × (height cm − 152.4). Tidal volume is usually set at 6 mL/kg PBW (range 4–8) with plateau pressure 30 cmH₂O or less. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'tidal', 'fields' => ['height', 'sex', 'ml_kg'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and sex', 'text' => ''],
        ['name' => 'Choose mL/kg', 'text' => '6 is the usual target.'],
    ]"
    :faqs="[
        ['question' => 'What tidal volume for a 175 cm man at 6 mL/kg?', 'answer' => '423 mL (Predicted body weight 70.6 kg (ARDSnet)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.field name="ml_kg" label="mL per kg" value="6" min="4" max="10" step="0.5" suffix="mL/kg" />
    </div>

    <x-calc.result label="Tidal volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'sex' => 'male', 'ml_kg' => 6],
        'Woman' => ['height' => 160, 'height-unit' => 'cm', 'sex' => 'female', 'ml_kg' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pbw' => ['label' => 'Predicted body weight'],
            'range' => ['label' => '4–8 mL/kg range'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PBW = 50 + 0.91 (H − 152.4)</li>
            <li>VT = 6 × PBW</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
