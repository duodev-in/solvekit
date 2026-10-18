<x-calc.page
    title="Wind Turbine Profit Calculator - SolveKit"
    description="Free wind turbine profit calculator: payback time, net present value and levelized cost of energy of a wind turbine from its cost, yearly energy and electricity price."
    lede="Work out whether a wind turbine pays for itself."
    about="Each year the turbine saves its energy × the electricity price (rising each year if you enter a price rise) less upkeep. Payback is when the savings add up to the cost. Net present value discounts future savings at your discount rate; the levelized cost of energy is the discounted cost per discounted kWh. Get the yearly energy from the Wind Turbine Calculator."
    :calc="['engine' => 'eco-energy', 'tool' => 'wind_profit', 'fields' => ['cost', 'incentive', 'energy', 'price', 'escalation', 'degradation', 'upkeep', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the cost and yearly energy', 'text' => 'From a quote and the turbine\'s output estimate.'],
        ['name' => 'Enter prices and rates', 'text' => 'Electricity price, price rise, upkeep and discount rate.'],
    ]"
    :faqs="[
        ['question' => 'How long does a wind turbine take to pay back?', 'answer' => 'It depends on wind and price; small turbines often take 10–25 years.'],
        ['question' => 'What is NPV?', 'answer' => 'The value today of all future savings minus the cost; positive means it pays.'],
        ['question' => 'What is LCOE?', 'answer' => 'The average cost of each kWh over the turbine\'s life.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cost" label="Installed cost" value="15000" min="0" suffix="$" />
        <x-calc.field name="incentive" label="Incentives (optional)" value="" min="0" suffix="$" placeholder="0" />
        <x-calc.field name="energy" label="Energy a year" value="9000" min="0" suffix="kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Electricity price" value="0.16" min="0" step="0.001" suffix="$/kWh" />
        <x-calc.field name="escalation" label="Price rise a year" value="2" step="0.1" suffix="%" />
        <x-calc.field name="degradation" label="Output loss a year" value="0.5" min="0" step="0.1" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="upkeep" label="Upkeep a year" value="150" min="0" suffix="$" />
        <x-calc.field name="rate" label="Discount rate" value="5" min="0" step="0.1" suffix="%" />
        <x-calc.field name="years" label="Lifetime" value="25" min="1" step="1" suffix="years" />
    </div>

    <x-calc.result label="Payback time" />

    <x-calc.options :examples="[
        'Small 10 kW turbine' => ['cost' => 50000, 'incentive' => 0, 'energy' => 15000, 'price' => 0.16, 'escalation' => 2, 'degradation' => 0.5, 'upkeep' => 500, 'rate' => 5, 'years' => 20],
        'Farm turbine with grant' => ['cost' => 120000, 'incentive' => 30000, 'energy' => 60000, 'price' => 0.14, 'escalation' => 2, 'degradation' => 0.3, 'upkeep' => 2000, 'rate' => 6, 'years' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Cumulative savings" name="cash" />
        <x-calc.rows heading="Details" :rows="[
            'npv' => ['label' => 'Net present value'],
            'lcoe' => ['label' => 'Levelized cost of energy'],
            'total' => ['label' => 'Lifetime savings'],
            'energy' => ['label' => 'Energy'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>saving in year n = E (1 − d)ⁿ⁻¹ × p (1 + e)ⁿ⁻¹ − upkeep</li>
            <li>NPV = −cost + Σ saving ÷ (1 + r)ⁿ</li>
            <li>LCOE = Σ costs ÷ (1 + r)ⁿ ÷ Σ E ÷ (1 + r)ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
