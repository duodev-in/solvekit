<x-calc.page
    title="Water Demand Calculator - SolveKit"
    description="Free water demand calculator: average day, maximum day and peak hour water demand of a community from its population and use per person."
    lede="Work out a community's water demand."
    about="Average day demand = population × use per person. US domestic use averaged 82 gallons per person per day in 2015 (USGS); total public supply per person is higher because it includes businesses and losses. Maximum-day and peak-hour factors are typical design multiples (often 1.5–2.5 and 2–4 × average); use your utility's or design standard's values."
    :calc="['engine' => 'eco-living', 'tool' => 'water_demand', 'fields' => ['population', 'per_person', 'per_unit', 'max_day', 'peak_hour']]"
    :how-to="[
        ['name' => 'Enter the population', 'text' => 'And use per person.'],
        ['name' => 'Set the peaking factors', 'text' => 'From your design standard.'],
    ]"
    :faqs="[
        ['question' => 'How much water does a person use?', 'answer' => 'About 82 gallons a day at home in the US (USGS 2015).'],
        ['question' => 'What is maximum day demand?', 'answer' => 'The highest single day in a year, often 1.5–2.5 × the average day.'],
        ['question' => 'Does this include fire flow?', 'answer' => 'No; fire flow is added separately in system design.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="population" label="Population" value="25000" min="1" step="1" />
        <x-calc.field name="per_person" label="Use per person per day" value="82" min="0" />
    </div>

    <x-calc.select name="per_unit" label="Per person unit" :options="['gal' => 'US gallons', 'l' => 'liters']" selected="gal" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="max_day" label="Maximum day factor" value="1.8" min="1" step="0.1" />
        <x-calc.field name="peak_hour" label="Peak hour factor" value="3" min="1" step="0.1" />
    </div>

    <x-calc.result label="Average day demand" />

    <x-calc.options :examples="[
        'Town of 25,000 (US)' => ['population' => 25000, 'per_person' => 82, 'per_unit' => 'gal', 'max_day' => 1.8, 'peak_hour' => 3],
        'City of 500,000, 150 L' => ['population' => 500000, 'per_person' => 150, 'per_unit' => 'l', 'max_day' => 1.5, 'peak_hour' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'metric' => ['label' => 'Metric'],
            'max_day' => ['label' => 'Maximum day'],
            'peak_hour' => ['label' => 'Peak hour'],
            'year' => ['label' => 'Per year'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>average day = population × use per person</li>
            <li>max day = average × factor; peak hour = average ÷ 24 × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
