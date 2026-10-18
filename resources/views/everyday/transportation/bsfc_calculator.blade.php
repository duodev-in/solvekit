<x-calc.page
    title="BSFC Calculator - SolveKit"
    description="Free BSFC calculator: brake specific fuel consumption of an engine in lb/hp·h and g/kWh from fuel flow and power, with brake thermal efficiency."
    lede="Work out an engine's brake specific fuel consumption."
    about="Brake specific fuel consumption (BSFC) = fuel mass flow ÷ power at the crankshaft: how much fuel the engine burns for each unit of work. 1 lb/hp·h = 608.28 g/kWh. Brake thermal efficiency = 3.6 MJ ÷ (BSFC in kg/kWh × the fuel's lower heating value): about 42.7 MJ/kg for gasoline, 42.6 for diesel, 29.2 for E85 and 19.9 for methanol (typical values)."
    :calc="['engine' => 'ev-transport', 'tool' => 'bsfc', 'fields' => ['flow', 'flow_unit', 'power', 'fuel'], 'unitFields' => ['power' => collect(config('units.power'))->only(['hp', 'kw', 'ps'])->all()], 'data' => collect(config('everyday_data'))->only(['fuel_lhv'])->all()]"
    :how-to="[
        ['name' => 'Enter fuel flow and power', 'text' => 'Measured together, for example on a dyno.'],
        ['name' => 'Pick the fuel', 'text' => 'For the efficiency.'],
    ]"
    :faqs="[
        ['question' => 'What is a good BSFC?', 'answer' => 'About 0.45–0.50 lb/hp·h for a gasoline engine, under 0.38 for a diesel.'],
        ['question' => 'What is 0.5 lb/hp·h in g/kWh?', 'answer' => '304 g/kWh.'],
        ['question' => 'How is BSFC used?', 'answer' => 'To size injectors and fuel pumps: fuel needed = power × BSFC.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="flow" label="Fuel flow" value="75" min="0" />
        <x-calc.select name="flow_unit" label="Flow unit" :options="['lb_h' => 'lb/h', 'kg_h' => 'kg/h']" selected="lb_h" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="power" label="Power at that moment" value="150" min="0" placeholder="Power at that moment">
            <label for="calc-power-unit" class="sr-only">Power at that moment unit</label>
            <select id="calc-power-unit" name="power-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['hp', 'kw', 'ps']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="fuel" label="Fuel" :options="['gasoline' => 'Gasoline', 'diesel' => 'Diesel', 'e85' => 'E85', 'methanol' => 'Methanol']" selected="gasoline" />
    </div>

    <x-calc.result label="Brake specific fuel consumption" />

    <x-calc.options :examples="[
        'Gasoline, 75 lb/h at 150 hp' => ['flow' => 75, 'flow_unit' => 'lb_h', 'power' => 150, 'power-unit' => 'hp', 'fuel' => 'gasoline'],
        'Diesel, 40 kg/h at 200 kW' => ['flow' => 40, 'flow_unit' => 'kg_h', 'power' => 200, 'power-unit' => 'kw', 'fuel' => 'diesel'],
        'E85 race engine' => ['flow' => 420, 'flow_unit' => 'lb_h', 'power' => 600, 'power-unit' => 'hp', 'fuel' => 'e85'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'metric' => ['label' => 'Metric'],
            'efficiency' => ['label' => 'Thermal efficiency'],
            'typical' => ['label' => 'Typical values'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BSFC = fuel flow ÷ power</li>
            <li>η = 3.6 ÷ (BSFC kg/kWh × LHV MJ/kg)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
