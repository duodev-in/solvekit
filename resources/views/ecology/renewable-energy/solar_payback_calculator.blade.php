<x-calc.page
    title="Solar Payback Calculator - SolveKit"
    description="Free solar payback calculator: payback time, net present value, lifetime savings and levelized cost of a solar panel system."
    lede="Work out how long solar panels take to pay for themselves."
    about="Savings each year = energy × electricity price (rising each year) less upkeep, with output falling slowly as panels age (often about 0.5% a year). Payback is when savings add up to the cost after incentives. Get the yearly energy from the Solar Panel Calculator."
    :calc="['engine' => 'eco-energy', 'tool' => 'solar_payback', 'fields' => ['cost', 'incentive', 'energy', 'price', 'escalation', 'degradation', 'upkeep', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the cost and incentives', 'text' => 'From your quote.'],
        ['name' => 'Enter the yearly energy and price', 'text' => 'And rates.'],
    ]"
    :faqs="[
        ['question' => 'How long do solar panels take to pay back?', 'answer' => 'Often 6–12 years, depending on sun, price and incentives.'],
        ['question' => 'Do panels lose output?', 'answer' => 'Typically about 0.5% a year.'],
        ['question' => 'What discount rate should I use?', 'answer' => 'Your loan rate or the return you could earn elsewhere.'],
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
        '6 kW home system' => ['cost' => 15000, 'incentive' => 4500, 'energy' => 8000, 'price' => 0.16, 'escalation' => 2, 'degradation' => 0.5, 'upkeep' => 150, 'rate' => 5, 'years' => 25],
        'Low price, no incentive' => ['cost' => 12000, 'incentive' => 0, 'energy' => 7000, 'price' => 0.08, 'escalation' => 1, 'degradation' => 0.5, 'upkeep' => 100, 'rate' => 5, 'years' => 25],
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
            <li>payback when Σ savings ≥ cost − incentives</li>
            <li>NPV = −net cost + Σ saving ÷ (1 + r)ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
