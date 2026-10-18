<x-calc.page
    title="Appliance Wattage Calculator - SolveKit"
    description="Free appliance wattage calculator: electricity used by your appliances in kWh a day, month and year, and what each costs to run."
    lede="Add up the electricity your appliances use."
    about="Energy (kWh) = watts × hours ÷ 1,000. Use the wattage on each appliance's label or a plug-in meter; the label is the maximum, so cycling appliances such as fridges run at full power only part of the time (about a third of the day). Days a week lets you enter appliances used only some days."
    :calc="['engine' => 'ev-home', 'tool' => 'appliance_wattage', 'fields' => ['appliances', 'price']]"
    :how-to="[
        ['name' => 'List your appliances', 'text' => 'Watts and hours a day.'],
        ['name' => 'Enter your price', 'text' => 'From your bill.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate appliance energy?', 'answer' => 'Watts × hours ÷ 1,000 = kWh.'],
        ['question' => 'How much does a 100 W TV cost for 4 hours a day?', 'answer' => 'About 12 kWh a month: $2.07 at 17¢.'],
        ['question' => 'Why is my fridge\'s real use lower than its label?', 'answer' => 'Its compressor cycles on and off.'],
    ]"
>
    <x-calc.rows-editor name="appliances" label="Appliances" :columns="['name' => 'Appliance', 'watts' => 'Watts', 'hours' => 'Hours/day', 'days' => 'Days/week']" :rows="[['Refrigerator', 150, 8, 7], ['TV', 100, 4, 7], ['Laptop', 60, 6, 5], ['Microwave', 1100, 0.25, 7], ['Washing machine', 500, 1, 3]]" add-label="Add appliance" :text="['name']" />

    <x-calc.field name="price" label="Electricity price" value="0.17" min="0" step="0.01" suffix="$/kWh" />

    <x-calc.result label="Electricity used" />

    <x-calc.options :examples="[
        'Typical home' => ['appliances' => 'Refrigerator	150	8	7
TV	100	4	7
Laptop	60	6	5
Microwave	1100	0.25	7
Washing machine	500	1	3', 'price' => 0.17],
        'Home office' => ['appliances' => 'Desktop PC	200	8	5
Monitor	30	8	5
Lamp (LED)	10	8	5
Space heater	1500	3	5', 'price' => 0.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'year' => ['label' => 'Per year'],
            'cost' => ['label' => 'Cost'],
        ]" />
        <x-calc.quick-ref heading="Each appliance" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kWh = W × h × days a week ÷ 7 ÷ 1,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
