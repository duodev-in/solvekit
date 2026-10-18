<x-calc.page
    title="Shower Water and Energy Calculator - SolveKit"
    description="Free shower water and energy calculator: water, energy, cost and CO₂ per shower and per year, and the saving from a 2.0 gpm shower head."
    lede="Work out the water, energy and cost of your showers."
    about="Water = flow × minutes. Heating energy = water mass × 4.186 kJ/(kg·°C) × temperature rise ÷ heater efficiency. CO₂ uses your grid for electric heaters and the DESNZ natural gas factor for gas. WaterSense shower heads use at most 2.0 gpm (7.6 L/min)."
    :calc="['engine' => 'eco-living', 'tool' => 'shower', 'fields' => ['minutes', 'flow', 'flow_unit', 'cold', 'hot', 'heater', 'efficiency', 'energy_price', 'water_price', 'per_week', 'people', 'grid', 'grid_custom'], 'unitFields' => ['cold' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'hot' => collect(config('units.temperature'))->only(['f', 'c'])->all()], 'data' => collect(config('ecology_data'))->only(['grid', 'fuels'])->all()]"
    :how-to="[
        ['name' => 'Enter time and flow', 'text' => 'Time a shower; flow is on the head or measure with a bucket.'],
        ['name' => 'Enter the heater and prices', 'text' => 'Gas or electric.'],
    ]"
    :faqs="[
        ['question' => 'How much water does a shower use?', 'answer' => 'An 8-minute shower at 2.5 gpm uses 20 gallons (76 L).'],
        ['question' => 'How much energy to heat it?', 'answer' => 'About 2.4 kWh of heat for 20 gallons warmed by 50 °F, before heater losses.'],
        ['question' => 'What is WaterSense?', 'answer' => 'A US EPA label for shower heads using 2.0 gpm or less.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="minutes" label="Minutes per shower" value="8" min="0" step="0.5" />
        <x-calc.field name="flow" label="Flow rate" value="2.5" min="0" step="0.1" />
        <x-calc.select name="flow_unit" label="Flow unit" :options="['gpm' => 'US gal/min', 'lmin' => 'L/min']" selected="gpm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cold" label="Cold water temperature" value="55" placeholder="Cold water temperature">
            <label for="calc-cold-unit" class="sr-only">Cold water temperature unit</label>
            <select id="calc-cold-unit" name="cold-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hot" label="Shower temperature" value="105" placeholder="Shower temperature">
            <label for="calc-hot-unit" class="sr-only">Shower temperature unit</label>
            <select id="calc-hot-unit" name="hot-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="heater" label="Water heater" :options="['gas' => 'Gas', 'electric' => 'Electric']" selected="gas" />
        <x-calc.field name="efficiency" label="Heater efficiency" value="80" min="1" max="400" suffix="%" help="Heat pumps exceed 100%" />
        <x-calc.field name="energy_price" label="Energy price" value="0.05" min="0" step="0.001" suffix="$/kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="water_price" label="Water price" value="4" min="0" step="0.01" suffix="$/m³" />
        <x-calc.field name="per_week" label="Showers a week" value="7" min="0" step="1" />
        <x-calc.field name="people" label="People" value="2" min="1" step="1" />
    </div>

    <x-calc.select name="grid" label="Electricity grid" :options="['OWID_WRL' => 'World average'] + collect(config('ecology_data.grid'))->except('OWID_WRL')->sortBy('name')->map(fn ($g) => $g['name'])->all() + ['custom' => 'My own value (g/kWh)']" selected="USA" />

    <div data-show-when="grid:custom" hidden>
        <x-calc.field name="grid_custom" label="Grid intensity" value="400" min="0" suffix="g CO₂e/kWh" />
    </div>

    <x-calc.result label="Water per shower" />

    <x-calc.options :examples="[
        '8 min at 2.5 gpm, gas' => ['minutes' => 8, 'flow' => 2.5, 'flow_unit' => 'gpm', 'cold' => 55, 'cold-unit' => 'f', 'hot' => 105, 'hot-unit' => 'f', 'heater' => 'gas', 'efficiency' => 80, 'energy_price' => 0.05, 'water_price' => 4, 'per_week' => 7, 'people' => 2, 'grid' => 'USA'],
        '10 min, electric, UK' => ['minutes' => 10, 'flow' => 9, 'flow_unit' => 'lmin', 'cold' => 10, 'cold-unit' => 'c', 'hot' => 40, 'hot-unit' => 'c', 'heater' => 'electric', 'efficiency' => 100, 'energy_price' => 0.25, 'water_price' => 4, 'per_week' => 7, 'people' => 1, 'grid' => 'GBR'],
        'Heat pump heater' => ['minutes' => 8, 'flow' => 2, 'flow_unit' => 'gpm', 'cold' => 55, 'cold-unit' => 'f', 'hot' => 105, 'hot-unit' => 'f', 'heater' => 'electric', 'efficiency' => 350, 'energy_price' => 0.16, 'water_price' => 4, 'per_week' => 7, 'people' => 4, 'grid' => 'USA'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'energy' => ['label' => 'Energy'],
            'co2' => ['label' => 'CO₂'],
            'cost' => ['label' => 'Cost'],
            'low_flow' => ['label' => '2.0 gpm head'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>water = flow × minutes</li>
            <li>kWh = L × 0.998 × 4.186 × ΔT ÷ 3600 ÷ efficiency</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
