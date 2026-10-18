<x-calc.page
    title="EV Charging Time Calculator - SolveKit"
    description="Free EV charging time calculator: how long it takes to charge an electric car from one percentage to another on a home or public charger, and the cost."
    lede="Work out how long an EV takes to charge, and what it costs."
    about="Energy into the battery = capacity × (target % − starting %). The charger supplies it at its power, minus losses (about 10% on AC charging): time = energy ÷ (power × efficiency). The car may accept less than the charger offers, and DC fast charging slows down above about 80%, so this is a best case for those last percent."
    :calc="['engine' => 'ev-transport', 'tool' => 'ev_charge', 'fields' => ['battery', 'start', 'target', 'power', 'efficiency', 'price']]"
    :how-to="[
        ['name' => 'Enter the battery and charge levels', 'text' => 'From the car\'s screen.'],
        ['name' => 'Pick the charger', 'text' => 'And your electricity price.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 75 kWh EV take to charge on Level 2?', 'answer' => 'From 20% to 80% on 7.2 kW, about 6 h 57 min.'],
        ['question' => 'How long on a regular outlet?', 'answer' => 'Level 1 (1.4 kW) adds only about 4–5 miles of range an hour.'],
        ['question' => 'Why charge to 80%?', 'answer' => 'Fast charging slows above 80%, and many makers suggest it for daily use.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="battery" label="Battery capacity" value="75" min="1" suffix="kWh" />
        <x-calc.field name="start" label="Starting charge" value="20" min="0" max="100" step="1" suffix="%" />
        <x-calc.field name="target" label="Target charge" value="80" min="1" max="100" step="1" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="power" label="Charger" :options="['1.4' => 'Level 1, 120 V 12 A (1.4 kW)', '7.2' => 'Level 2, 240 V 30 A (7.2 kW)', '11' => 'Level 2, 48 A (11 kW)', '50' => 'DC fast, 50 kW', '150' => 'DC fast, 150 kW', '250' => 'DC fast, 250 kW']" selected="7.2" />
        <x-calc.field name="efficiency" label="Charging efficiency" value="90" min="50" max="100" step="1" suffix="%" />
        <x-calc.field name="price" label="Price per kWh" value="0.17" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Charging time" />

    <x-calc.options :examples="[
        '75 kWh, Level 2' => ['battery' => 75, 'start' => 20, 'target' => 80, 'power' => '7.2', 'efficiency' => 90, 'price' => 0.17],
        'DC fast 10–80%' => ['battery' => 82, 'start' => 10, 'target' => 80, 'power' => '150', 'efficiency' => 95, 'price' => 0.48],
        'Level 1 overnight' => ['battery' => 60, 'start' => 50, 'target' => 90, 'power' => '1.4', 'efficiency' => 85, 'price' => 0.15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'energy' => ['label' => 'Energy from the grid'],
            'cost' => ['label' => 'Cost'],
            'taper' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = capacity × Δ% ÷ (power × efficiency)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
