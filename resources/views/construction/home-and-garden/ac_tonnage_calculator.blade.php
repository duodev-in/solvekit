<x-calc.page
    title="AC Tonnage Calculator - SolveKit"
    description="Free AC tonnage calculator: air conditioner tons from a cooling load, with the size range ACCA Manual S allows."
    lede="Work out how many tons of air conditioning a cooling load needs."
    about="One ton of cooling is 12,000 Btu/h. ACCA Manual S sizes cooling equipment between 95% and 115% of the total cooling load (up to 125% for heat pumps in heating-dominated climates). Find the load with the Air Conditioner BTU Calculator."
    :calc="['engine' => 'con-hvac', 'tool' => 'ac_tonnage', 'fields' => ['load', 'equipment']]"
    :how-to="[
        ['name' => 'Enter the cooling load', 'text' => 'From a load calculation.'],
        ['name' => 'Choose AC or heat pump', 'text' => 'Heat pumps may be a little larger.'],
    ]"
    :faqs="[
        ['question' => 'How many tons is 30,000 Btu/h?', 'answer' => '2.5 tons.'],
        ['question' => 'Is bigger better?', 'answer' => 'No: an oversized unit cycles on and off and removes less humidity.'],
        ['question' => 'What size AC for 1,500 ft²?', 'answer' => 'It depends on the load; many homes that size need 1.5–3 tons.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="load" label="Cooling load" value="30000" min="0" suffix="Btu/h" />
        <x-calc.select name="equipment" label="Equipment" :options="['ac' => 'Air conditioner', 'heat_pump' => 'Heat pump']" selected="ac" />
    </div>

    <x-calc.result label="Cooling capacity" />

    <x-calc.options :examples="[
        '30,000 Btu/h' => ['load' => 30000, 'equipment' => 'ac'],
        '42,000 Btu/h heat pump' => ['load' => 42000, 'equipment' => 'heat_pump'],
        '18,500 Btu/h' => ['load' => 18500, 'equipment' => 'ac'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'range' => ['label' => 'Allowed range'],
            'sizes' => ['label' => 'Standard sizes'],
            'kw' => ['label' => 'Kilowatts'],
            'btu' => ['label' => 'Load'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tons = Btu/h ÷ 12,000</li>
            <li>range = 95–115% of the load (heat pump 125%)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
