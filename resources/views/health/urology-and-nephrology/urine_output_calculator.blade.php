<x-calc.page
    title="Urine Output Calculator - SolveKit"
    description="Free urine output calculator: urine output in mL/kg/h from volume, hours and weight, with the KDIGO acute kidney injury urine criteria."
    lede="Calculate urine output per kg per hour."
    about="Urine output = volume (mL) ÷ (weight (kg) × hours). KDIGO (2012) acute kidney injury: under 0.5 mL/kg/h for 6–12 hours is stage 1, for 12 hours or more stage 2, and under 0.3 mL/kg/h for 24 hours (or no urine for 12 hours) stage 3. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'urine_output', 'fields' => ['volume', 'hours', 'weight'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter the volume collected', 'text' => ''],
        ['name' => 'Enter the hours and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the output for 300 mL in 8 hours at 75 kg?', 'answer' => '0.50 mL/kg/h: Not oliguric (0.5 mL/kg/h or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="volume" label="Urine volume" value="300" min="0" step="any" suffix="mL" />
        <x-calc.field name="hours" label="Over" value="8" min="0" step="any" suffix="h" />
        <x-calc.field name="weight" label="Weight" value="75" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Urine output" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['volume' => 300, 'hours' => 8, 'weight' => 75, 'weight-unit' => 'kg'],
        'Normal' => ['volume' => 1200, 'hours' => 12, 'weight' => 70, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hourly' => ['label' => 'Per hour'],
            'daily' => ['label' => 'Per day'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>UO = mL ÷ (kg × h)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
