<x-calc.page
    title="Welding Calculator - SolveKit"
    description="Free fillet weld calculator: allowable load of a fillet weld by AWS D1.1, required leg size for a load, and weld metal and electrode weight."
    lede="Work out a fillet weld's strength and the filler metal it needs."
    about="A fillet weld's effective throat is 0.707 × the leg. AWS D1.1 allows a shear stress of 0.30 × FEXX on the throat (allowable stress design), so 1 in of a ¼ in E70 fillet carries 0.30 × 70 × 0.177 = 3.71 kips. Weld metal = leg² ÷ 2 × length × 7,850 kg/m³; electrode needed = weld metal ÷ deposition efficiency (often about 60–70% for stick, 90%+ for solid wire)."
    :calc="['engine' => 'con-mech', 'tool' => 'welding', 'fields' => ['leg', 'length', 'fexx', 'load', 'efficiency'], 'unitFields' => ['leg' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'load' => collect(config('units.force'))->only(['lbf', 'n', 'kn', 'kip'])->all()]]"
    :how-to="[
        ['name' => 'Enter the fillet size and length', 'text' => 'And the electrode (E70 = 70 ksi).'],
        ['name' => 'Add a load', 'text' => 'To find the leg size it needs.'],
    ]"
    :faqs="[
        ['question' => 'How strong is a ¼ in E70 fillet weld?', 'answer' => '3.71 kips per inch (ASD).'],
        ['question' => 'What is the throat of a fillet weld?', 'answer' => '0.707 times the leg for an equal-leg weld.'],
        ['question' => 'Is this enough for a structural design?', 'answer' => 'It checks the weld metal only; base metal and the connection must also be checked by the designer.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="leg" label="Fillet leg size" value="0.25" min="0" placeholder="Fillet leg size">
            <label for="calc-leg-unit" class="sr-only">Fillet leg size unit</label>
            <select id="calc-leg-unit" name="leg-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Weld length" value="6" min="0" placeholder="Weld length">
            <label for="calc-length-unit" class="sr-only">Weld length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fexx" label="Electrode strength FEXX" value="70" min="1" suffix="ksi" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="load" label="Load to carry (optional)" value="" min="0" placeholder="Optional">
            <label for="calc-load-unit" class="sr-only">Load to carry (optional) unit</label>
            <select id="calc-load-unit" name="load-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['lbf', 'n', 'kn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kip')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="efficiency" label="Deposition efficiency" value="65" min="1" max="100" suffix="%" />
    </div>

    <x-calc.result label="Allowable weld load" />

    <x-calc.options :examples="[
        '¼ in E70, 6 in' => ['leg' => 0.25, 'leg-unit' => 'in', 'length' => 6, 'length-unit' => 'in', 'fexx' => 70, 'efficiency' => 65],
        'Size for 15 kips' => ['leg' => 0.25, 'leg-unit' => 'in', 'length' => 4, 'length-unit' => 'in', 'fexx' => 70, 'load' => 15, 'load-unit' => 'kip', 'efficiency' => 90],
        '6 mm E49 (≈ E70), 100 mm' => ['leg' => 6, 'leg-unit' => 'mm', 'length' => 100, 'length-unit' => 'mm', 'fexx' => 70, 'efficiency' => 65],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kn' => ['label' => 'Kilonewtons'],
            'per_inch' => ['label' => 'Per inch'],
            'required' => ['label' => 'Leg for the load'],
            'metal' => ['label' => 'Filler metal'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>throat = 0.707 × leg</li>
            <li>allowable = 0.30 × FEXX × throat × length</li>
            <li>weld metal = leg² ÷ 2 × length × 7850 kg/m³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
