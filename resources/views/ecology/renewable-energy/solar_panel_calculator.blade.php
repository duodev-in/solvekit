<x-calc.page
    title="Solar Panel Calculator - SolveKit"
    description="Free solar panel calculator: system size and number of panels to cover your electricity use, with monthly output for 260 cities from PVGIS solar data."
    lede="Work out how many solar panels you need."
    about="Solar output per kW of panels comes from PVGIS (European Commission Joint Research Centre) for panels at the best fixed tilt facing the equator with 14% system losses, downloaded once for 260 major cities. Size = yearly use × share to cover ÷ yearly output per kWp. For other places, enter your peak sun hours."
    :calc="['engine' => 'eco-energy', 'tool' => 'solar', 'fields' => ['use', 'use_unit', 'site', 'sun_hours', 'losses', 'panel', 'panel_area', 'share'], 'data' => ['solar_cities' => config('ecology_data.solar_cities')]]"
    :how-to="[
        ['name' => 'Enter your electricity use', 'text' => 'From a year of bills.'],
        ['name' => 'Choose your city', 'text' => 'Or enter sun hours.'],
        ['name' => 'Enter the panel rating', 'text' => 'And how much of your use to cover.'],
    ]"
    :faqs="[
        ['question' => 'How many panels for 10,500 kWh a year in New York?', 'answer' => 'About 19 panels of 400 W (7.6 kWp), with PVGIS giving about 1,400 kWh per kWp a year there.'],
        ['question' => 'What is a kWp?', 'answer' => 'Kilowatt peak: panel power under standard test conditions.'],
        ['question' => 'Why do months differ?', 'answer' => 'Day length and sun angle change through the year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="use" label="Electricity use" value="10500" min="0" suffix="kWh" />
        <x-calc.segmented name="use_unit" legend="Per" :options="['year' => 'Year', 'month' => 'Month']" selected="year" />
    </div>

    <x-calc.select name="site" label="Location" :options="collect(config('ecology_data.solar_cities'))->sortBy('name')->mapWithKeys(fn ($c, $k) => [$k => $c['name'].' ('.$c['cc'].')'])->all() + ['custom' => 'My own sun hours']" selected="new_york_city_us" />

    <div data-show-when="site:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="sun_hours" label="Peak sun hours a day" value="4.5" min="0" step="0.1" />
            <x-calc.field name="losses" label="System losses" value="14" min="0" max="60" suffix="%" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="panel" label="Panel rating" value="400" min="1" suffix="W" />
        <x-calc.field name="panel_area" label="Panel area" value="1.9" min="0" step="0.01" suffix="m²" />
        <x-calc.field name="share" label="Share of use to cover" value="100" min="1" max="200" suffix="%" />
    </div>

    <x-calc.result label="Solar system size" />

    <x-calc.options :examples="[
        'New York home' => ['use' => 10500, 'use_unit' => 'year', 'site' => 'new_york_city_us', 'panel' => 400, 'panel_area' => 1.9, 'share' => 100],
        'Mumbai, 300 kWh a month' => ['use' => 300, 'use_unit' => 'month', 'site' => 'mumbai_in', 'panel' => 540, 'panel_area' => 2.6, 'share' => 100],
        'London, half of use' => ['use' => 2700, 'use_unit' => 'year', 'site' => 'london_gb', 'panel' => 430, 'panel_area' => 1.95, 'share' => 50],
        'My own sun hours' => ['use' => 6000, 'use_unit' => 'year', 'site' => 'custom', 'sun_hours' => 5, 'losses' => 14, 'panel' => 400, 'panel_area' => 1.9, 'share' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Monthly output" name="monthly" />
        <x-calc.rows heading="Details" :rows="[
            'panels' => ['label' => 'Panels'],
            'area' => ['label' => 'Roof area'],
            'yield' => ['label' => 'Solar data'],
            'best' => ['label' => 'Seasons'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kWp = use × share ÷ kWh per kWp a year</li>
            <li>panels = ⌈kWp × 1000 ÷ panel W⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
