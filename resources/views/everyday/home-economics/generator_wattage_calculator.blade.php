<x-calc.page
    title="Generator Wattage Calculator - SolveKit"
    description="Free generator wattage calculator: the running and starting watts a portable or standby generator needs for your appliances."
    lede="Size a generator for the appliances you need to run."
    about="A generator must supply the running watts of everything on at once, plus the extra surge to start the largest motor (motors briefly draw 2–3 times their running power). Size = Σ running watts + the largest (starting − running) watts. Use each appliance's label; the example values are typical figures from generator makers' charts."
    :calc="['engine' => 'ev-home', 'tool' => 'generator', 'fields' => ['appliances', 'margin']]"
    :how-to="[
        ['name' => 'List what runs at once', 'text' => 'Running and starting watts.'],
        ['name' => 'Add a margin', 'text' => '10–20% is common.'],
    ]"
    :faqs="[
        ['question' => 'What size generator for a fridge and sump pump?', 'answer' => 'About 4,000–4,500 starting watts with lights and a furnace fan.'],
        ['question' => 'What are starting watts?', 'answer' => 'The brief surge a motor needs to start.'],
        ['question' => 'Should motors start together?', 'answer' => 'No, start them one at a time.'],
    ]"
>
    <x-calc.rows-editor name="appliances" label="Appliances running together" :columns="['name' => 'Appliance', 'running' => 'Running W', 'starting' => 'Starting W', 'qty' => 'Qty']" :rows="[['Refrigerator', 700, 2200, 1], ['Sump pump (½ hp)', 1050, 2150, 1], ['Lights (LED)', 100, 100, 1], ['Furnace fan (½ hp)', 875, 2350, 1], ['Phone and laptop charging', 100, 100, 1]]" add-label="Add appliance" :text="['name']" />

    <x-calc.field name="margin" label="Safety margin" value="10" min="0" max="50" step="5" suffix="%" />

    <x-calc.result label="Starting (surge) watts needed" />

    <x-calc.options :decimals="false" :examples="[
        'Outage essentials' => ['appliances' => 'Refrigerator	700	2200	1
Sump pump (½ hp)	1050	2150	1
Lights (LED)	100	100	1
Furnace fan (½ hp)	875	2350	1
Phone and laptop charging	100	100	1', 'margin' => 10],
        'RV' => ['appliances' => 'RV air conditioner (13,500 BTU)	1300	2800	1
Microwave	1000	1000	1
Lights	100	100	1', 'margin' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'running' => ['label' => 'Running watts'],
            'surge' => ['label' => 'Peak'],
            'note' => ['label' => 'Tip'],
        ]" />
        <x-calc.quick-ref heading="Each appliance" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size = Σ running + max(starting − running)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
