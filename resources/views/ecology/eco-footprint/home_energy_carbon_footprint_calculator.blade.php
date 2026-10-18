<x-calc.page
    title="Home Energy Carbon Footprint Calculator - SolveKit"
    description="Free home energy carbon footprint calculator: tonnes of CO₂e a year from your electricity, natural gas, heating oil and propane, with your country's grid."
    lede="Work out the carbon footprint of the energy you use at home."
    about="Electricity uses your country's average grid carbon intensity (Ember, via Our World in Data). Fuels use the US EPA factors for therms and gallons and the UK DESNZ factors for kWh, liters and cubic meters. Enter electricity and gas per month from a bill and oil and propane per year."
    :calc="['engine' => 'eco-footprint', 'tool' => 'home_energy', 'fields' => ['electricity', 'grid', 'grid_custom', 'gas', 'gas_unit', 'oil', 'oil_unit', 'propane', 'propane_unit', 'people'], 'data' => collect(config('ecology_data'))->only(['grid', 'fuels'])->all()]"
    :how-to="[
        ['name' => 'Enter your energy use', 'text' => 'From your bills.'],
        ['name' => 'Choose your country\'s grid', 'text' => 'Or enter your supplier\'s figure.'],
    ]"
    :faqs="[
        ['question' => 'How much CO₂ does 1 kWh of electricity make?', 'answer' => 'It depends on the grid: the world average is about 460 g, France under 50 g, India about 670 g (Ember).'],
        ['question' => 'How much CO₂ is a therm of gas?', 'answer' => '5.3 kg (EPA).'],
        ['question' => 'Does green power count?', 'answer' => 'Use your supplier\'s figure as a custom grid value.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="electricity" label="Electricity per month" value="600" min="0" suffix="kWh" />
        <x-calc.select name="grid" label="Electricity grid" :options="['OWID_WRL' => 'World average'] + collect(config('ecology_data.grid'))->except('OWID_WRL')->sortBy('name')->map(fn ($g) => $g['name'])->all() + ['custom' => 'My own value (g/kWh)']" selected="OWID_WRL" />
    </div>

    <div data-show-when="grid:custom" hidden>
        <x-calc.field name="grid_custom" label="Grid intensity" value="400" min="0" suffix="g CO₂e/kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gas" label="Natural gas per month" value="50" min="0" />
        <x-calc.select name="gas_unit" label="Gas unit" :options="['therm' => 'therms', 'ccf' => 'ccf (100 ft³)', 'm3' => 'm³', 'kwh' => 'kWh']" selected="therm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="oil" label="Heating oil per year (optional)" value="" min="0" placeholder="0" />
        <x-calc.select name="oil_unit" label="Oil unit" :options="['gal' => 'US gallons', 'l' => 'liters']" selected="gal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="propane" label="Propane or LPG per year (optional)" value="" min="0" placeholder="0" />
        <x-calc.select name="propane_unit" label="Propane unit" :options="['gal' => 'US gallons', 'l' => 'liters']" selected="gal" />
    </div>

    <x-calc.field name="people" label="People in the home" value="3" min="1" step="1" />

    <x-calc.result label="Home energy footprint" />

    <x-calc.options :examples="[
        'US home' => ['electricity' => 880, 'grid' => 'USA', 'gas' => 50, 'gas_unit' => 'therm', 'oil' => '', 'propane' => '', 'people' => 3],
        'UK home' => ['electricity' => 230, 'grid' => 'GBR', 'gas' => 950, 'gas_unit' => 'kwh', 'oil' => '', 'propane' => '', 'people' => 2],
        'Indian home' => ['electricity' => 250, 'grid' => 'IND', 'gas' => 0, 'gas_unit' => 'm3', 'oil' => '', 'propane' => 170, 'propane_unit' => 'l', 'people' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'per_person' => ['label' => 'Per person'],
            'month' => ['label' => 'Per month'],
            'grid' => ['label' => 'Grid'],
        ]" />
        <x-calc.quick-ref heading="By source" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>electricity = kWh × grid kg/kWh</li>
            <li>gas = therms × 5.306 kg (EPA) or kWh × 0.183 kg (DESNZ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
