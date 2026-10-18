<x-calc.page
    title="Hydroelectric Power Calculator - SolveKit"
    description="Free hydroelectric power calculator: electrical power and yearly energy from water flow, head and efficiency, P = η ρ g Q H."
    lede="Work out the power and energy of a hydro plant or micro-hydro system."
    about="Hydropower P = η × ρ × g × Q × H: efficiency × water density (998 kg/m³) × gravity × flow rate × head (the height the water falls). Turbine and generator efficiency together is often 70–90%. Yearly energy = power × 8,760 hours × the capacity factor."
    :calc="['engine' => 'eco-energy', 'tool' => 'hydro', 'fields' => ['flow', 'flow_unit', 'head', 'efficiency', 'capacity', 'home_kwh'], 'unitFields' => ['head' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the flow and head', 'text' => 'Head is the vertical drop.'],
        ['name' => 'Set the efficiency', 'text' => 'And how much of the year it runs at full power.'],
    ]"
    :faqs="[
        ['question' => 'How much power from 1 m³/s falling 10 m?', 'answer' => 'About 83 kW at 85% efficiency.'],
        ['question' => 'What is head?', 'answer' => 'The vertical height the water falls through the turbine.'],
        ['question' => 'What is a capacity factor?', 'answer' => 'Actual yearly energy ÷ running at full power all year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="flow" label="Flow rate" value="2" min="0" />
        <x-calc.select name="flow_unit" label="Flow unit" :options="['m3s' => 'm³/s', 'ls' => 'L/s', 'ft3s' => 'ft³/s', 'gpm' => 'US gal/min', 'm3h' => 'm³/h']" selected="m3s" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="head" label="Head (fall)" value="20" min="0" placeholder="Head (fall)">
            <label for="calc-head-unit" class="sr-only">Head (fall) unit</label>
            <select id="calc-head-unit" name="head-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="efficiency" label="Overall efficiency" value="85" min="1" max="100" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="capacity" label="Capacity factor" value="50" min="1" max="100" suffix="%" />
        <x-calc.field name="home_kwh" label="One home's use a year (optional)" value="10500" min="0" suffix="kWh" />
    </div>

    <x-calc.result label="Electrical power" />

    <x-calc.options :examples="[
        'River 2 m³/s, 20 m' => ['flow' => 2, 'flow_unit' => 'm3s', 'head' => 20, 'head-unit' => 'm', 'efficiency' => 85, 'capacity' => 50, 'home_kwh' => 10500],
        'Micro-hydro 50 L/s, 30 m' => ['flow' => 50, 'flow_unit' => 'ls', 'head' => 30, 'head-unit' => 'm', 'efficiency' => 70, 'capacity' => 80, 'home_kwh' => 10500],
        'Stream 200 gpm, 100 ft' => ['flow' => 200, 'flow_unit' => 'gpm', 'head' => 100, 'head-unit' => 'ft', 'efficiency' => 65, 'capacity' => 70, 'home_kwh' => 10500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hp' => ['label' => 'Horsepower'],
            'year' => ['label' => 'Yearly energy'],
            'homes' => ['label' => 'Homes supplied'],
            'hydraulic' => ['label' => 'Water power'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = η ρ g Q H</li>
            <li>E = P × 8760 × capacity factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
