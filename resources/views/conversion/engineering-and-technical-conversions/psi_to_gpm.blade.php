@php
    $pressureUnits = collect(config('units.pressure'))->only(['psi', 'bar', 'kpa'])->all();
    $lengthUnits = collect(config('units.length'))->only(['in', 'mm', 'cm'])->all();
    $gallon = config('units.volume.gal_us.factor') / 1000;
    $flowUnits = [
        'gpm' => ['name' => 'US gallons per minute', 'symbol' => 'gpm', 'factor' => $gallon / 60],
        'lpm' => ['name' => 'Liters per minute', 'symbol' => 'L/min', 'factor' => 1 / 60000],
        'gph' => ['name' => 'US gallons per hour', 'symbol' => 'gph', 'factor' => $gallon / 3600],
        'lps' => ['name' => 'Liters per second', 'symbol' => 'L/s', 'factor' => 0.001],
        'm3h' => ['name' => 'Cubic meters per hour', 'symbol' => 'm³/h', 'factor' => 1 / 3600],
        'cfs' => ['name' => 'Cubic feet per second', 'symbol' => 'ft³/s', 'factor' => 0.028316846592],
    ];
    $rows = collect($flowUnits)->except('gpm')->mapWithKeys(fn ($unit, $key) => [$key => ['label' => $unit['name'], 'unit' => $unit['symbol']]])->all();
    $unitSelect = 'h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40';
@endphp

<x-calc.page
    title="PSI to GPM Calculator - SolveKit"
    description="Professional PSI to GPM flow rate calculator for engineering applications. Calculate flow rates from pressure and pipe dimensions with precision."
    lede="Estimate water flow in gallons per minute from pressure and opening size."
    about="Water leaving an opening reaches a speed of √(2 × pressure ÷ density). Flow is that speed times the opening area times a discharge coefficient, which accounts for the jet narrowing as it leaves. 0.61 suits a sharp-edged hole; a smooth nozzle is closer to 0.97. Water is taken at 20 °C."
    :calc="['engine' => 'psi-to-gpm', 'pressureUnits' => $pressureUnits, 'lengthUnits' => $lengthUnits, 'flowUnits' => $flowUnits, 'rows' => array_keys($rows)]"
    :how-to="[
        ['name' => 'Enter the pressure', 'text' => 'Use the pressure drop across the opening, e.g. the gauge pressure at a hose or hydrant.'],
        ['name' => 'Enter the opening diameter', 'text' => 'The inside diameter of the hole or nozzle.'],
        ['name' => 'Set the discharge coefficient', 'text' => '0.61 for a sharp-edged hole, up to about 0.97 for a smooth nozzle.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert psi to gpm?', 'answer' => 'You need the opening size too. For water, gpm ≈ 29.84 × Cd × d² × √psi, with d in inches.'],
        ['question' => 'What discharge coefficient should I use?', 'answer' => 'About 0.61 for a sharp-edged orifice, 0.8 for a short pipe outlet and 0.95 to 0.98 for a well-rounded nozzle.'],
        ['question' => 'Does this work for liquids other than water?', 'answer' => 'Only approximately. Flow scales with 1 ÷ √density, so denser liquids flow a little slower at the same pressure.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pressure" label="Pressure" value="60" min="0" placeholder="Pressure">
            <label for="calc-pressure-unit" class="sr-only">Pressure unit</label>
            <select id="calc-pressure-unit" name="pressure-unit" class="{{ $unitSelect }}">
                @foreach($pressureUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="diameter" label="Opening diameter" value="0.5" min="0" placeholder="Diameter">
            <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="{{ $unitSelect }}">
                @foreach($lengthUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="coefficient" label="Discharge coefficient" value="0.61" min="0" max="1" step="0.01" placeholder="0.61" />
    </div>

    <x-calc.result label="US gallons per minute" />

    <x-calc.options :examples="[
        'Garden hose ⅝″ at 50 psi' => ['pressure' => 50, 'pressure-unit' => 'psi', 'diameter' => 0.625, 'diameter-unit' => 'in'],
        'Nozzle 10 mm at 3 bar' => ['pressure' => 3, 'pressure-unit' => 'bar', 'diameter' => 10, 'diameter-unit' => 'mm', 'coefficient' => 0.97],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same flow in" :rows="$rows" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = Cd × A × √(2 × ΔP ÷ ρ)</li>
            <li>A = π × d² ÷ 4 · ρ = 998.2 kg/m³</li>
            <li>US shortcut: gpm ≈ 29.84 × Cd × d(in)² × √psi</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
