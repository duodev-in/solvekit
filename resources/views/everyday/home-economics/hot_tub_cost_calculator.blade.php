<x-calc.page
    title="Hot Tub Cost Calculator - SolveKit"
    description="Free hot tub cost calculator: the monthly cost of running a hot tub from heater and pump use or kWh, plus chemicals."
    lede="Work out what a hot tub costs to run each month."
    about="Electricity = heater kW × heating hours a day × 30.4 days + pump watts × hours ÷ 1,000. The heater runs much more in cold weather and without a good cover. If your tub has an energy monitor, enter kWh a month instead. Chemicals typically add $15–30 a month."
    :calc="['engine' => 'ev-home', 'tool' => 'hot_tub', 'fields' => ['mode', 'heater', 'hours', 'pump', 'pump_hours', 'kwh_month', 'price', 'chemicals']]"
    :how-to="[
        ['name' => 'Enter the heater and pump', 'text' => 'Or kWh a month from a meter.'],
        ['name' => 'Enter prices', 'text' => 'Electricity and chemicals.'],
    ]"
    :faqs="[
        ['question' => 'How much does a hot tub cost a month?', 'answer' => 'Often $30–80 in electricity plus chemicals, depending on climate and cover.'],
        ['question' => 'What uses the most energy?', 'answer' => 'Heating the water.'],
        ['question' => 'Does a cover matter?', 'answer' => 'Yes, it is the biggest saving.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['heater' => 'Heater and pump', 'kwh' => 'kWh a month']" selected="heater" />

    <div data-show-when="mode:heater">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <x-calc.field name="heater" label="Heater" value="5.5" min="0" step="0.5" suffix="kW" />
            <x-calc.field name="hours" label="Heating hours a day" value="3" min="0" max="24" step="0.5" />
            <x-calc.field name="pump" label="Pump" value="800" min="0" suffix="W" />
            <x-calc.field name="pump_hours" label="Pump hours a day" value="4" min="0" max="24" step="0.5" />
        </div>
    </div>

    <div data-show-when="mode:kwh" hidden>
        <x-calc.field name="kwh_month" label="kWh a month" value="450" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Electricity price" value="0.17" min="0" step="0.01" suffix="$/kWh" />
        <x-calc.field name="chemicals" label="Chemicals a month" value="20" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cost a month" />

    <x-calc.options :decimals="false" :examples="[
        '5.5 kW, 3 h a day' => ['mode' => 'heater', 'heater' => 5.5, 'hours' => 3, 'pump' => 800, 'pump_hours' => 4, 'kwh_month' => '', 'price' => 0.17, 'chemicals' => 20],
        'From meter' => ['mode' => 'kwh', 'heater' => '', 'hours' => '', 'pump' => '', 'pump_hours' => '', 'kwh_month' => 450, 'price' => 0.2, 'chemicals' => 25],
        'Winter use' => ['mode' => 'heater', 'heater' => 5.5, 'hours' => 6, 'pump' => 800, 'pump_hours' => 6, 'kwh_month' => '', 'price' => 0.17, 'chemicals' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'year' => ['label' => 'Per year'],
            'day' => ['label' => 'Per day'],
            'note' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kWh a month = (heater kW × h + pump W × h ÷ 1,000) × 30.44</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
