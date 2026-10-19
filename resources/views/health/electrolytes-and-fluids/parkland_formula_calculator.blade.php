<x-calc.page
    title="Parkland Formula Calculator - SolveKit"
    description="Free Parkland formula calculator: burn resuscitation fluid for the first 24 hours (4 mL × kg × % TBSA), split into the first 8 and next 16 hours."
    lede="Calculate Parkland burn fluids."
    about="The Parkland (Baxter) formula estimates crystalloid for adults with burns over 20% of body surface: 4 mL × weight (kg) × % TBSA in 24 hours, half in the first 8 hours from the time of the burn and half over the next 16. The American Burn Association suggests starting at 2–4 mL and adjusting to urine output. Fluid orders belong to the treating team. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'parkland', 'fields' => ['weight', 'tbsa', 'hours_since'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and % TBSA', 'text' => 'Partial and full thickness only.'],
        ['name' => 'Enter the time since the burn', 'text' => 'The 8 hours start at the burn, not arrival.'],
    ]"
    :faqs="[
        ['question' => 'What is the Parkland volume for 80 kg and 30% TBSA?', 'answer' => '9,600 mL (4,800 mL (600 mL/h) in the first 8 hours).'],
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
        <x-calc.field name="tbsa" label="% total body surface burned" value="30" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="hours_since" label="Hours since the burn" value="1" min="0" step="any" suffix="h" />
    </div>

    <x-calc.result label="Fluid in 24 hours" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 80, 'weight-unit' => 'kg', 'tbsa' => 30, 'hours_since' => 1],
        'Larger burn' => ['weight' => 70, 'weight-unit' => 'kg', 'tbsa' => 45, 'hours_since' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'first' => ['label' => 'First 8 hours'],
            'next' => ['label' => 'Next 16 hours'],
            'range' => ['label' => 'ABA range'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = 4 × kg × %TBSA</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
