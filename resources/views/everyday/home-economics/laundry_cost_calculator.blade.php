<x-calc.page
    title="Laundry Cost Calculator - SolveKit"
    description="Free laundry cost calculator: the cost of each load of laundry in water, washer and dryer electricity and detergent, and per year."
    lede="Work out what each load of laundry costs."
    about="Cost per load = water used × water price + washer energy × electricity price + dryer energy × electricity price + detergent. An ENERGY STAR standard dryer uses about 2.15 kWh a load. Washer energy and water vary by model; check the EnergyGuide label (front-loaders often use about 50–70 L)."
    :calc="['engine' => 'ev-home', 'tool' => 'laundry', 'fields' => ['loads', 'power_price', 'water', 'water_price', 'washer_kwh', 'detergent', 'dryer_kwh', 'dry']]"
    :how-to="[
        ['name' => 'Enter loads and prices', 'text' => 'Electricity and water.'],
        ['name' => 'Adjust per-load amounts', 'text' => 'From your machines.'],
    ]"
    :faqs="[
        ['question' => 'How much does a load of laundry cost?', 'answer' => 'About 91¢ with machine drying at these defaults, 54¢ line-dried.'],
        ['question' => 'What costs the most?', 'answer' => 'Usually drying.'],
        ['question' => 'Does washing cold save money?', 'answer' => 'Yes, heating water is most of a hot wash\'s energy.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="loads" label="Loads a week" value="5" min="0" step="1" />
        <x-calc.field name="power_price" label="Electricity price" value="0.17" min="0" step="0.01" suffix="$/kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="water" label="Water per load" value="60" min="0" suffix="L" />
        <x-calc.field name="water_price" label="Water price" value="4" min="0" step="0.01" suffix="$/m³" />
        <x-calc.field name="washer_kwh" label="Washer energy" value="0.3" min="0" step="0.05" suffix="kWh/load" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="detergent" label="Detergent per load" value="0.25" min="0" step="0.01" suffix="$" />
        <x-calc.field name="dryer_kwh" label="Dryer energy" value="2.15" min="0" step="0.05" suffix="kWh/load" />
    </div>

    <x-calc.checkbox name="dry" label="Machine-dry the load" :checked="true" />

    <x-calc.result label="Cost per load" />

    <x-calc.options :decimals="false" :examples="[
        '5 loads, machine dry' => ['loads' => 5, 'power_price' => 0.17, 'water' => 60, 'water_price' => 4, 'washer_kwh' => 0.3, 'detergent' => 0.25, 'dryer_kwh' => 2.15, 'dry' => true],
        'Line dry' => ['loads' => 5, 'power_price' => 0.17, 'water' => 60, 'water_price' => 4, 'washer_kwh' => 0.3, 'detergent' => 0.25, 'dryer_kwh' => 2.15, 'dry' => false],
        'Big family' => ['loads' => 12, 'power_price' => 0.2, 'water' => 80, 'water_price' => 5, 'washer_kwh' => 0.5, 'detergent' => 0.3, 'dryer_kwh' => 2.4, 'dry' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'year' => ['label' => 'Per year'],
            'month' => ['label' => 'Per month'],
            'water' => ['label' => 'Water a year'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>per load = water + washer + dryer + detergent</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
