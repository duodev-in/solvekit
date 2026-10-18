<x-calc.page
    title="Gas vs Electric Dryer Calculator - SolveKit"
    description="Free gas vs electric dryer calculator: the yearly running cost of a gas and an electric clothes dryer from loads a week and your energy prices."
    lede="Compare the running costs of gas and electric dryers."
    about="Defaults are ENERGY STAR medians for certified standard vented dryers: about 2.15 kWh a load for electric, and 2.43 kWh-equivalent for gas, split here as about 0.2 kWh of electricity for the drum and controls and 0.076 therms of gas (an assumption: check your model's EnergyGuide). Cost = loads × energy × price."
    :calc="['engine' => 'ev-home', 'tool' => 'dryer', 'fields' => ['loads', 'power_price', 'electric_kwh', 'gas_price', 'gas_therms', 'gas_kwh']]"
    :how-to="[
        ['name' => 'Enter loads a week', 'text' => 'And your prices.'],
        ['name' => 'Adjust the energy per load', 'text' => 'From your models if known.'],
    ]"
    :faqs="[
        ['question' => 'Is a gas dryer cheaper to run?', 'answer' => 'Usually, where gas is cheap per unit of energy; enter your prices to check.'],
        ['question' => 'How much electricity does a dryer use per load?', 'answer' => 'About 2.15 kWh for an ENERGY STAR electric dryer.'],
        ['question' => 'What about heat pump dryers?', 'answer' => 'They use far less: enter their kWh per load as the electric dryer.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="loads" label="Loads a week" value="5" min="0" step="1" />
        <x-calc.field name="power_price" label="Electricity price" value="0.17" min="0" step="0.01" suffix="$/kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="electric_kwh" label="Electric dryer energy" value="2.15" min="0" step="0.01" suffix="kWh/load" />
        <x-calc.field name="gas_price" label="Gas price" value="1.5" min="0" step="0.01" suffix="$/therm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gas_therms" label="Gas dryer gas" value="0.076" min="0" step="0.001" suffix="therms/load" />
        <x-calc.field name="gas_kwh" label="Gas dryer electricity" value="0.2" min="0" step="0.01" suffix="kWh/load" />
    </div>

    <x-calc.result label="Saving" />

    <x-calc.options :examples="[
        '5 loads a week' => ['loads' => 5, 'power_price' => 0.17, 'electric_kwh' => 2.15, 'gas_price' => 1.5, 'gas_therms' => 0.076, 'gas_kwh' => 0.2],
        'Expensive gas' => ['loads' => 8, 'power_price' => 0.14, 'electric_kwh' => 2.15, 'gas_price' => 2.6, 'gas_therms' => 0.076, 'gas_kwh' => 0.2],
        'Heat pump vs gas' => ['loads' => 6, 'power_price' => 0.2, 'electric_kwh' => 1.2, 'gas_price' => 1.4, 'gas_therms' => 0.076, 'gas_kwh' => 0.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'electric' => ['label' => 'Electric dryer'],
            'gas' => ['label' => 'Gas dryer'],
            'load' => ['label' => 'Per load'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = loads × kWh × price (+ therms × gas price)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
