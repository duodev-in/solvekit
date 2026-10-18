<x-calc.page
    title="Air Conditioner BTU Calculator - SolveKit"
    description="Free air conditioner BTU calculator: cooling load in Btu/h and tons from walls, roof, windows and sun, air leakage, people and appliances."
    lede="Work out the cooling load of a room or house in Btu/h."
    about="The cooling load adds heat conducted through the envelope (A ÷ R × ΔT), sun through windows (area × solar heat gain coefficient × sun on the glass), air leakage, people (230 Btu/h sensible and 200 latent each, the Manual J allowances) and appliances (3.412 Btu/h per watt). This is a simplified heat-gain model; a full ACCA Manual J also accounts for orientation by hour, shading and duct gains. Peak sun on west glass in summer is roughly 150–250 Btu/(h·ft²)."
    :calc="['engine' => 'con-hvac', 'tool' => 'cooling', 'fields' => ['parts', 'parts_unit', 'r_units', 'inside', 'outside', 'glass', 'glass_u', 'shgc', 'sun', 'people', 'equipment', 'floor', 'ceiling', 'ach'], 'unitFields' => ['inside' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'outside' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'glass' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'floor' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'ceiling' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'rowUnits' => ['parts' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'List the walls, roof and floor', 'text' => 'Area and R-value.'],
        ['name' => 'Enter the windows', 'text' => 'Area, U-factor, SHGC and sun.'],
        ['name' => 'Add people and appliances', 'text' => 'And the air leakage.'],
    ]"
    :faqs="[
        ['question' => 'How many Btu for a 500 ft² room?', 'answer' => 'It depends on windows, insulation and sun; this calculator works it out from those.'],
        ['question' => 'What is SHGC?', 'answer' => 'The share of sunlight a window lets through as heat; low-e glass is often 0.25–0.4.'],
        ['question' => 'What is latent load?', 'answer' => 'Moisture the air conditioner removes, mostly from people and outdoor air.'],
    ]"
>
    <x-calc.rows-editor name="parts" label="Walls, roof and floor (not windows)" :columns="['area' => 'Area', 'r' => 'R-value']" :rows="[[1200, 13], [1500, 38]]" :units="collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()" unit="ft2" unit-label="Area unit" add-label="Add part" />

    <x-calc.select name="r_units" label="R-values in" :options="['ip' => 'ft²·°F·h/Btu (US R)', 'si' => 'm²·K/W (RSI)']" selected="ip" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="inside" label="Indoor temperature" value="75" placeholder="Indoor temperature">
            <label for="calc-inside-unit" class="sr-only">Indoor temperature unit</label>
            <select id="calc-inside-unit" name="inside-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="outside" label="Outdoor design temperature" value="95" placeholder="Outdoor design temperature">
            <label for="calc-outside-unit" class="sr-only">Outdoor design temperature unit</label>
            <select id="calc-outside-unit" name="outside-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="glass" label="Window area" value="180" min="0" placeholder="Window area">
            <label for="calc-glass-unit" class="sr-only">Window area unit</label>
            <select id="calc-glass-unit" name="glass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="glass_u" label="Window U-factor" value="0.3" min="0" step="0.01" />
        <x-calc.field name="shgc" label="Window SHGC" value="0.25" min="0" max="1" step="0.01" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sun" label="Peak sun on the glass" value="200" min="0" suffix="Btu/h·ft²" />
        <x-calc.field name="people" label="People" value="4" min="0" step="1" />
        <x-calc.field name="equipment" label="Lights and appliances" value="1000" min="0" suffix="W" />
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

    <x-calc.result label="Cooling load" />

    <x-calc.options :examples="[
        '1,500 ft² house' => ['parts' => '1200 13
1500 38', 'parts_unit' => 'ft2', 'r_units' => 'ip', 'inside' => 75, 'inside-unit' => 'f', 'outside' => 95, 'outside-unit' => 'f', 'glass' => 180, 'glass-unit' => 'ft2', 'glass_u' => 0.3, 'shgc' => 0.25, 'sun' => 200, 'people' => 4, 'equipment' => 1000, 'floor' => 1500, 'floor-unit' => 'ft2', 'ceiling' => 8, 'ceiling-unit' => 'ft', 'ach' => 0.5],
        'Sunny room 300 ft²' => ['parts' => '320 11
300 30', 'parts_unit' => 'ft2', 'r_units' => 'ip', 'inside' => 75, 'inside-unit' => 'f', 'outside' => 100, 'outside-unit' => 'f', 'glass' => 60, 'glass-unit' => 'ft2', 'glass_u' => 0.5, 'shgc' => 0.6, 'sun' => 230, 'people' => 2, 'equipment' => 400, 'floor' => 300, 'floor-unit' => 'ft2', 'ceiling' => 8, 'ceiling-unit' => 'ft', 'ach' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tons' => ['label' => 'Tons'],
            'sensible' => ['label' => 'Sensible'],
            'latent' => ['label' => 'Latent'],
            'kw' => ['label' => 'Kilowatts'],
        ]" />
        <x-calc.quick-ref heading="Heat gains" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = Σ A ÷ R × ΔT + A_glass (U ΔT + SHGC × sun) + 0.018 V ACH ΔT + people + 3.412 × W</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
