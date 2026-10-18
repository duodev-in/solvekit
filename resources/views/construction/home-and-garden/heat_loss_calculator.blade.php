<x-calc.page
    title="Heat Loss Calculator - SolveKit"
    description="Free heat loss calculator: design heat loss of a house or room in Btu/h and kW from wall, window, roof and floor areas and R-values, plus air leakage."
    lede="Work out a building's design heat loss."
    about="Steady-state heat loss is Σ A ÷ R × ΔT through each part, plus air leakage 0.018 × volume × ACH × ΔT (0.018 Btu/(ft³·°F) is the heat capacity of air). Use the winter design temperature for your location (ASHRAE 99% value) and real R-values, including framing; for windows, R ≈ 1 ÷ U-factor. This is the envelope method behind room-by-room load calculations; a full ACCA Manual J adds more detail."
    :calc="['engine' => 'con-hvac', 'tool' => 'heat_loss', 'fields' => ['parts', 'parts_unit', 'r_units', 'inside', 'outside', 'floor', 'ceiling', 'ach'], 'unitFields' => ['inside' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'outside' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'floor' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'ceiling' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'rowUnits' => ['parts' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'List each part', 'text' => 'Area and R-value of walls, windows, doors, roof and floor.'],
        ['name' => 'Enter the design temperatures', 'text' => 'Indoor and the local winter design temperature.'],
        ['name' => 'Enter the air leakage', 'text' => 'Floor area, ceiling height and ACH.'],
    ]"
    :faqs="[
        ['question' => 'What is a design temperature?', 'answer' => 'An outdoor temperature colder than all but about 1% of winter hours (the ASHRAE 99% value).'],
        ['question' => 'What R-value is a window?', 'answer' => 'About 1 ÷ U-factor: a U-0.30 window is about R-3.3.'],
        ['question' => 'How many Btu/h per square foot?', 'answer' => 'It varies widely (often 20–50 Btu/h per ft²), which is why this calculator works from the envelope instead.'],
    ]"
>
    <x-calc.rows-editor name="parts" label="Walls, windows, roof and floor" :columns="['area' => 'Area', 'r' => 'R-value']" :rows="[[1200, 13], [180, 2], [40, 2], [1500, 38], [1500, 19]]" :units="collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()" unit="ft2" unit-label="Area unit" add-label="Add part" help="Window R ≈ 1 ÷ U-factor" />

    <x-calc.select name="r_units" label="R-values in" :options="['ip' => 'ft²·°F·h/Btu (US R)', 'si' => 'm²·K/W (RSI)']" selected="ip" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="inside" label="Indoor temperature" value="70" placeholder="Indoor temperature">
            <label for="calc-inside-unit" class="sr-only">Indoor temperature unit</label>
            <select id="calc-inside-unit" name="inside-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="outside" label="Outdoor design temperature" value="10" placeholder="Outdoor design temperature">
            <label for="calc-outside-unit" class="sr-only">Outdoor design temperature unit</label>
            <select id="calc-outside-unit" name="outside-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="floor" label="Floor area" value="1500" min="0" placeholder="Floor area">
            <label for="calc-floor-unit" class="sr-only">Floor area unit</label>
            <select id="calc-floor-unit" name="floor-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ceiling" label="Ceiling height" value="8" min="0" placeholder="Ceiling height">
            <label for="calc-ceiling-unit" class="sr-only">Ceiling height unit</label>
            <select id="calc-ceiling-unit" name="ceiling-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ach" label="Air leakage (ACH)" value="0.5" min="0" step="0.05" help="Natural air changes per hour" />
    </div>

    <x-calc.result label="Design heat loss" />

    <x-calc.options :examples="[
        '1,500 ft² house at 10 °F' => ['parts' => '1200 13
180 2
40 2
1500 38
1500 19', 'parts_unit' => 'ft2', 'r_units' => 'ip', 'floor' => 1500, 'floor-unit' => 'ft2', 'ceiling' => 8, 'ceiling-unit' => 'ft', 'inside' => 70, 'inside-unit' => 'f', 'outside' => 10, 'outside-unit' => 'f', 'ach' => 0.5],
        'Cold climate, −10 °F' => ['parts' => '1200 13
180 2
40 2
1500 38
1500 19', 'parts_unit' => 'ft2', 'r_units' => 'ip', 'floor' => 1500, 'floor-unit' => 'ft2', 'ceiling' => 8, 'ceiling-unit' => 'ft', 'inside' => 70, 'inside-unit' => 'f', 'outside' => -10, 'outside-unit' => 'f', 'ach' => 0.35],
        'Metric room, RSI' => ['parts' => '30 2.3
4 0.35
16 6.7', 'parts_unit' => 'm2', 'r_units' => 'si', 'inside' => 21, 'inside-unit' => 'c', 'outside' => -10, 'outside-unit' => 'c', 'floor' => 16, 'floor-unit' => 'm2', 'ceiling' => 2.5, 'ceiling-unit' => 'm', 'ach' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'envelope' => ['label' => 'Through the envelope'],
            'air' => ['label' => 'Air leakage'],
            'kw' => ['label' => 'Kilowatts'],
            'per_ft2' => ['label' => 'Per ft² of floor'],
        ]" />
        <x-calc.quick-ref heading="Each part" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = Σ (A ÷ R) × ΔT + 0.018 × V × ACH × ΔT</li>
            <li>ΔT in °F, A in ft², V in ft³, Q in Btu/h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
