<x-calc.page
    title="Turbo Size Calculator - SolveKit"
    description="Free turbo size calculator: compressor airflow in lb/min and pressure ratio for a horsepower target, to plot on a compressor map (Garrett method)."
    lede="Work out the airflow and pressure ratio a turbo must supply."
    about="Airflow (lb/min) = horsepower × air-fuel ratio × BSFC ÷ 60. Manifold pressure needed = airflow × 639.6 × (intake temperature °F + 460) ÷ (volumetric efficiency × rpm ÷ 2 × displacement in in³). Pressure ratio = (manifold pressure + losses after the compressor) ÷ (atmospheric pressure − filter losses). Plot airflow and pressure ratio on compressor maps (Garrett Turbo Tech 103). Typical: AFR 11.5–12.5 for boosted gasoline, BSFC 0.50–0.60."
    :calc="['engine' => 'ev-transport', 'tool' => 'turbo', 'fields' => ['power', 'afr', 'bsfc', 'displacement', 'rpm', 've', 'iat', 'altitude', 'loss_after', 'loss_before'], 'unitFields' => ['power' => collect(config('units.power'))->only(['hp', 'kw', 'ps'])->all(), 'iat' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'altitude' => collect(config('units.length'))->only(['ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the target and engine', 'text' => 'Power, displacement and rpm.'],
        ['name' => 'Enter AFR, BSFC, VE and temperature', 'text' => 'Typical values are filled in.'],
    ]"
    :faqs="[
        ['question' => 'How much airflow for 400 hp?', 'answer' => 'About 44 lb/min at AFR 12 and BSFC 0.55.'],
        ['question' => 'What is a pressure ratio?', 'answer' => 'Absolute compressor outlet pressure ÷ inlet pressure.'],
        ['question' => 'Why does intake temperature matter?', 'answer' => 'Hotter air is less dense, so more boost is needed for the same airflow.'],
    ]"
>
    <x-calc.field name="power" label="Target crank power" value="400" min="0" placeholder="Target crank power">
        <label for="calc-power-unit" class="sr-only">Target crank power unit</label>
        <select id="calc-power-unit" name="power-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.power'))->only(['hp', 'kw', 'ps']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="afr" label="Air-fuel ratio" value="12" min="8" max="20" step="0.1" />
        <x-calc.field name="bsfc" label="BSFC" value="0.55" min="0.3" max="1" step="0.01" suffix="lb/hp·h" />
        <x-calc.field name="displacement" label="Displacement" value="2" min="0.1" step="0.1" suffix="L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rpm" label="At rpm" value="6000" min="500" step="100" />
        <x-calc.field name="ve" label="Volumetric efficiency" value="95" min="30" max="130" step="1" suffix="%" />
        <x-calc.field name="iat" label="Intake manifold temp" value="130" min="0" placeholder="Intake manifold temp">
            <label for="calc-iat-unit" class="sr-only">Intake manifold temp unit</label>
            <select id="calc-iat-unit" name="iat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="altitude" label="Altitude" value="0" min="0" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="loss_after" label="Loss after compressor" value="2" min="0" step="0.5" suffix="psi" />
        <x-calc.field name="loss_before" label="Filter loss" value="1" min="0" step="0.5" suffix="psi" />
    </div>

    <x-calc.result label="Airflow needed" />

    <x-calc.options :examples="[
        '2.0 L, 400 hp' => ['power' => 400, 'power-unit' => 'hp', 'afr' => 12, 'bsfc' => 0.55, 'displacement' => 2, 'rpm' => 6000, 've' => 95, 'iat' => 130, 'iat-unit' => 'f', 'altitude' => 0, 'altitude-unit' => 'ft', 'loss_after' => 2, 'loss_before' => 1],
        '5.0 L V8, 700 hp' => ['power' => 700, 'power-unit' => 'hp', 'afr' => 11.5, 'bsfc' => 0.6, 'displacement' => 5, 'rpm' => 6500, 've' => 90, 'iat' => 120, 'iat-unit' => 'f', 'altitude' => 0, 'altitude-unit' => 'ft', 'loss_after' => 2, 'loss_before' => 1],
        '3.0 L at altitude' => ['power' => 450, 'power-unit' => 'hp', 'afr' => 12, 'bsfc' => 0.55, 'displacement' => 3, 'rpm' => 6000, 've' => 95, 'iat' => 50, 'iat-unit' => 'c', 'altitude' => 1600, 'altitude-unit' => 'm', 'loss_after' => 2, 'loss_before' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Pressure ratio'],
            'map' => ['label' => 'Manifold pressure'],
            'cfm' => ['label' => 'In cfm'],
            'kg' => ['label' => 'In kg/h'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Wa = hp × AFR × BSFC ÷ 60</li>
            <li>MAP = Wa × 639.6 × (T + 460) ÷ (VE × rpm/2 × Vd)</li>
            <li>PR = (MAP + ΔP) ÷ (p atm − ΔP in)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
