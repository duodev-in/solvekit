<x-calc.page
    title="Fuel Pump Calculator - SolveKit"
    description="Free fuel pump calculator: fuel pump flow in liters and gallons per hour needed for a horsepower target, from BSFC, fuel type and a safety margin."
    lede="Size a fuel pump for your power target."
    about="Fuel flow = horsepower × BSFC (lb/h), turned into volume with the fuel's density (about 0.745 kg/L for gasoline, 0.785 for E85, 0.835 for diesel). Add a margin of 20% or more, because pump output falls at higher pressure and lower voltage; check the pump's flow chart at your pressure."
    :calc="['engine' => 'ev-transport', 'tool' => 'fuel_pump', 'fields' => ['power', 'bsfc', 'fuel', 'margin'], 'unitFields' => ['power' => collect(config('units.power'))->only(['hp', 'kw', 'ps'])->all()], 'data' => collect(config('everyday_data'))->only(['fuel_density'])->all()]"
    :how-to="[
        ['name' => 'Enter the power and BSFC', 'text' => 'Higher BSFC for boosted and E85 engines.'],
        ['name' => 'Pick the fuel and margin', 'text' => '20% is common.'],
    ]"
    :faqs="[
        ['question' => 'What fuel pump for 500 hp?', 'answer' => 'About 219 L/h (58 US gal/h) of gasoline at BSFC 0.6 with a 20% margin.'],
        ['question' => 'Does E85 need a bigger pump?', 'answer' => 'Yes, about 25–40% more flow.'],
        ['question' => 'What is lph?', 'answer' => 'Liters per hour, how most pumps are rated.'],
    ]"
>
    <x-calc.field name="power" label="Target crank power" value="500" min="0" placeholder="Target crank power">
        <label for="calc-power-unit" class="sr-only">Target crank power unit</label>
        <select id="calc-power-unit" name="power-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.power'))->only(['hp', 'kw', 'ps']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bsfc" label="BSFC" value="0.6" min="0.3" max="1.2" step="0.01" suffix="lb/hp·h" />
        <x-calc.select name="fuel" label="Fuel" :options="['gasoline' => 'Gasoline', 'e85' => 'E85', 'methanol' => 'Methanol', 'diesel' => 'Diesel']" selected="gasoline" />
        <x-calc.field name="margin" label="Safety margin" value="20" min="0" max="100" step="5" suffix="%" />
    </div>

    <x-calc.result label="Pump flow needed" />

    <x-calc.options :examples="[
        '500 hp gasoline' => ['power' => 500, 'power-unit' => 'hp', 'bsfc' => 0.6, 'fuel' => 'gasoline', 'margin' => 20],
        '500 hp E85' => ['power' => 500, 'power-unit' => 'hp', 'bsfc' => 0.8, 'fuel' => 'e85', 'margin' => 20],
        '250 kW NA' => ['power' => 250, 'power-unit' => 'kw', 'bsfc' => 0.5, 'fuel' => 'gasoline', 'margin' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gph' => ['label' => 'In US gal/h'],
            'lb' => ['label' => 'In lb/h'],
            'note' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L/h = hp × BSFC × 0.4536 ÷ density × (1 + margin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
