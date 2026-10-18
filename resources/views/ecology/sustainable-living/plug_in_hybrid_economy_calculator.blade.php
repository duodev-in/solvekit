<x-calc.page
    title="Plug-in Hybrid Economy Calculator - SolveKit"
    description="Free plug-in hybrid economy calculator: share of driving on electricity, yearly running cost and CO₂ of a PHEV from your daily distance and electric range."
    lede="Work out how much of your driving a plug-in hybrid covers on electricity, and what it costs."
    about="Each day the car uses its battery first, up to its electric range, then fuel for the rest. Daily electric distance = the smaller of your daily distance and the range. Electricity CO₂ uses your country's grid (Ember) and fuel CO₂ the EPA or DESNZ factors. Charge every day for these figures; real-world electric range is often lower than rated, so enter a realistic figure."
    :calc="['engine' => 'eco-living', 'tool' => 'phev', 'fields' => ['daily', 'range', 'days', 'kwh_100', 'kwh_unit', 'economy', 'economy_unit', 'fuel', 'power_price', 'fuel_price', 'price_unit', 'grid', 'grid_custom'], 'unitFields' => ['daily' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'range' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()], 'data' => collect(config('ecology_data'))->only(['grid', 'fuels'])->all()]"
    :how-to="[
        ['name' => 'Enter your daily driving', 'text' => 'And the car\'s electric range.'],
        ['name' => 'Enter efficiency and prices', 'text' => 'From the window sticker or your bills.'],
    ]"
    :faqs="[
        ['question' => 'How much driving is electric in a PHEV?', 'answer' => 'All of it on days within the range; for 40 miles a day and 30 miles of range, 75%.'],
        ['question' => 'Is a PHEV cheaper to run?', 'answer' => 'Usually, when charged daily and electricity is cheaper per mile than fuel.'],
        ['question' => 'Does charging every day matter?', 'answer' => 'Yes; unplugged PHEVs run as ordinary hybrids.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="daily" label="Distance per day" value="40" min="0" placeholder="Distance per day">
            <label for="calc-daily-unit" class="sr-only">Distance per day unit</label>
            <select id="calc-daily-unit" name="daily-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="range" label="Electric range" value="30" min="0" placeholder="Electric range">
            <label for="calc-range-unit" class="sr-only">Electric range unit</label>
            <select id="calc-range-unit" name="range-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="days" label="Driving days a year" value="300" min="1" max="366" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="kwh_100" label="Electric use" value="33" min="0" suffix="kWh per 100" />
        <x-calc.select name="kwh_unit" label="Per 100" :options="['mi' => 'miles', 'km' => 'km']" selected="mi" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="economy" label="Fuel economy on gas" value="45" min="0" />
        <x-calc.select name="economy_unit" label="Economy unit" :options="['mpg_us' => 'mpg (US)', 'mpg_uk' => 'mpg (UK)', 'l100km' => 'L/100 km', 'kml' => 'km/L']" selected="mpg_us" />
        <x-calc.select name="fuel" label="Fuel" :options="['us_gasoline' => 'US gasoline (EPA)', 'us_diesel' => 'US diesel (EPA)', 'uk_petrol' => 'Petrol, UK average blend (DESNZ)', 'uk_diesel' => 'Diesel, UK average blend (DESNZ)']" selected="us_gasoline" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="power_price" label="Electricity price" value="0.16" min="0" step="0.001" suffix="$/kWh" />
        <x-calc.field name="fuel_price" label="Fuel price" value="3.5" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Fuel price" :options="['l' => 'per liter', 'gal' => 'per US gallon']" selected="gal" />
    </div>

    <x-calc.select name="grid" label="Electricity grid" :options="['OWID_WRL' => 'World average'] + collect(config('ecology_data.grid'))->except('OWID_WRL')->sortBy('name')->map(fn ($g) => $g['name'])->all() + ['custom' => 'My own value (g/kWh)']" selected="USA" />

    <div data-show-when="grid:custom" hidden>
        <x-calc.field name="grid_custom" label="Grid intensity" value="400" min="0" suffix="g CO₂e/kWh" />
    </div>

    <x-calc.result label="Share of miles on electricity" />

    <x-calc.options :examples="[
        '40 mi a day, 30 mi range' => ['daily' => 40, 'daily-unit' => 'mi', 'range' => 30, 'range-unit' => 'mi', 'days' => 300, 'kwh_100' => 33, 'kwh_unit' => 'mi', 'economy' => 45, 'economy_unit' => 'mpg_us', 'fuel' => 'us_gasoline', 'power_price' => 0.16, 'fuel_price' => 3.5, 'price_unit' => 'gal', 'grid' => 'USA'],
        'Short trips in the UK' => ['daily' => 25, 'daily-unit' => 'km', 'range' => 50, 'range-unit' => 'km', 'days' => 330, 'kwh_100' => 18, 'kwh_unit' => 'km', 'economy' => 5.5, 'economy_unit' => 'l100km', 'fuel' => 'uk_petrol', 'power_price' => 0.25, 'fuel_price' => 1.4, 'price_unit' => 'l', 'grid' => 'GBR'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cost' => ['label' => 'Running cost'],
            'co2' => ['label' => 'CO₂'],
            'energy' => ['label' => 'Energy used'],
            'grid' => ['label' => 'Grid'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>electric distance = min(daily, range)</li>
            <li>cost = kWh × price + fuel × price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
