<x-calc.page
    title="Passive House Savings Calculator - SolveKit"
    description="Free Passive House savings calculator: heating energy, money and CO₂ saved by building or retrofitting to the Passive House limit of 15 kWh per m² a year."
    lede="Work out what building to the Passive House standard saves on heating."
    about="The Passive House Institute limits space heating demand to 15 kWh per m² of treated floor area a year. Savings = (your heating demand − 15) × floor area. Divide by the heating system's efficiency for the fuel saved. Typical older homes need 100–250 kWh/m² a year."
    :calc="['engine' => 'eco-science', 'tool' => 'passive_house', 'fields' => ['area', 'input', 'demand', 'heating_kwh', 'fuel', 'efficiency', 'price', 'grid', 'grid_custom'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => collect(config('ecology_data'))->only(['grid', 'fuels', 'constants'])->all()]"
    :how-to="[
        ['name' => 'Enter the floor area', 'text' => 'And your heating demand or fuel use.'],
        ['name' => 'Choose the fuel', 'text' => 'And enter its price.'],
    ]"
    :faqs="[
        ['question' => 'What is the Passive House standard?', 'answer' => 'Space heating of at most 15 kWh per m² a year, plus airtightness and primary energy limits.'],
        ['question' => 'How much can it save?', 'answer' => 'Often 75–90% of heating compared with typical existing homes.'],
        ['question' => 'Does it need special heating?', 'answer' => 'The heating load is so small that a small heat pump or ventilation heater can do.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Heated floor area" value="150" min="0" placeholder="Heated floor area">
            <label for="calc-area-unit" class="sr-only">Heated floor area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.segmented name="input" legend="Know" :options="['demand' => 'Heating demand', 'bills' => 'Yearly heating fuel']" selected="demand" />
    </div>

    <div data-show-when="input:demand">
        <x-calc.field name="demand" label="Heating demand" value="120" min="0" suffix="kWh/m² a year" />
    </div>

    <div data-show-when="input:bills" hidden>
        <x-calc.field name="heating_kwh" label="Heating fuel a year" value="18000" min="0" suffix="kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="fuel" label="Heating fuel" :options="['gas' => 'Natural gas', 'oil' => 'Heating oil', 'electricity' => 'Electricity']" selected="gas" />
        <x-calc.field name="efficiency" label="System efficiency" value="90" min="1" max="500" suffix="%" />
        <x-calc.field name="price" label="Energy price" value="0.08" min="0" step="0.001" suffix="$/kWh" />
    </div>

    <x-calc.select name="grid" label="Electricity grid" :options="['OWID_WRL' => 'World average'] + collect(config('ecology_data.grid'))->except('OWID_WRL')->sortBy('name')->map(fn ($g) => $g['name'])->all() + ['custom' => 'My own value (g/kWh)']" selected="OWID_WRL" />

    <div data-show-when="grid:custom" hidden>
        <x-calc.field name="grid_custom" label="Grid intensity" value="400" min="0" suffix="g CO₂e/kWh" />
    </div>

    <x-calc.result label="Heat saved at the Passive House standard" />

    <x-calc.options :examples="[
        '150 m² home at 120 kWh/m²' => ['area' => 150, 'area-unit' => 'm2', 'input' => 'demand', 'demand' => 120, 'fuel' => 'gas', 'efficiency' => 90, 'price' => 0.08, 'grid' => 'OWID_WRL'],
        'From gas bills' => ['area' => 1600, 'area-unit' => 'ft2', 'input' => 'bills', 'heating_kwh' => 25000, 'fuel' => 'gas', 'efficiency' => 85, 'price' => 0.05, 'grid' => 'USA'],
        'Electric heat, UK' => ['area' => 90, 'area-unit' => 'm2', 'input' => 'demand', 'demand' => 140, 'fuel' => 'electricity', 'efficiency' => 100, 'price' => 0.25, 'grid' => 'GBR'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fuel' => ['label' => 'Fuel saved'],
            'money' => ['label' => 'Money saved'],
            'co2' => ['label' => 'CO₂ saved'],
            'share' => ['label' => 'Reduction'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>saved = (demand − 15) × area</li>
            <li>fuel = saved ÷ efficiency</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
