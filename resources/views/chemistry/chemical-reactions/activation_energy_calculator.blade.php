<x-calc.page
    title="Activation Energy Calculator - SolveKit"
    description="Free activation energy calculator: Ea from rate constants at two temperatures, with the pre-exponential factor."
    lede="Work out the activation energy from rates at two temperatures."
    about="From two rate constants at two temperatures, the two-point Arrhenius equation gives Ea = −R ln(k₂/k₁) ÷ (1/T₂ − 1/T₁). The pre-exponential factor and the rate at a third temperature follow."
    :calc="['engine' => 'chem-reactions', 'tool' => 'activation_energy', 'fields' => ['k1', 't1', 'k2', 't2', 't3'], 'unitFields' => ['t1' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 't2' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 't3' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Enter two rates', 'text' => 'Rate constants or rates at the same concentrations.'],
        ['name' => 'Enter their temperatures', 'text' => 'Any unit.'],
    ]"
    :faqs="[
        ['question' => 'What is activation energy?', 'answer' => 'The minimum energy colliding molecules need to react.'],
        ['question' => 'Can I use rates instead of rate constants?', 'answer' => 'Yes, if the concentrations are the same in both runs.'],
        ['question' => 'What Ea doubles the rate per 10 °C?', 'answer' => 'About 53 kJ/mol near room temperature.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="k1" label="Rate constant k₁" value="1" min="0" />
        <x-calc.field name="t1" label="Temperature T₁" value="25" placeholder="Temperature T₁">
            <label for="calc-t1-unit" class="sr-only">Temperature T₁ unit</label>
            <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="k2" label="Rate constant k₂" value="2" min="0" />
        <x-calc.field name="t2" label="Temperature T₂" value="35" placeholder="Temperature T₂">
            <label for="calc-t2-unit" class="sr-only">Temperature T₂ unit</label>
            <select id="calc-t2-unit" name="t2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="t3" label="Third temperature (optional)" value="50" placeholder="Third temperature (optional)">
        <label for="calc-t3-unit" class="sr-only">Third temperature (optional) unit</label>
        <select id="calc-t3-unit" name="t3-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Activation energy" />

    <x-calc.options :examples="[
        'Rate doubles 25 → 35 °C' => ['k1' => 1, 't1' => 25, 't1-unit' => 'c', 'k2' => 2, 't2' => 35, 't2-unit' => 'c', 't3' => 50, 't3-unit' => 'c'],
        'Two kinetics runs' => ['k1' => 0.0012, 't1' => 300, 't1-unit' => 'k', 'k2' => 0.0185, 't2' => 330, 't2-unit' => 'k', 't3' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'a' => ['label' => 'Pre-exponential factor'],
            'k3' => ['label' => 'Rate at third temperature'],
            'ratio' => ['label' => 'Rate increase'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Ea = −R ln(k₂/k₁) ÷ (1/T₂ − 1/T₁)</li>
            <li>A = k₁ ÷ e^(−Ea/RT₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
