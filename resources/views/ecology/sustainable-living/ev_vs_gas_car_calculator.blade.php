<x-calc.page
    title="EV vs Gas Car Calculator - SolveKit"
    description="Free EV vs gas car calculator: yearly CO₂ and running cost of an electric car against a gasoline or diesel car, with your country's electricity grid."
    lede="Compare the running CO₂ and cost of an electric and a gas car."
    about="An EV's emissions are its electricity use × your grid's carbon intensity (Ember, via Our World in Data); a gas car's are its fuel × the EPA or DESNZ factor. Include charging losses in the EV's kWh figure (window-sticker figures already do). Making the battery adds a one-off footprint not counted here."
    :calc="['engine' => 'eco-living', 'tool' => 'ev_gas', 'fields' => ['distance', 'kwh_100', 'kwh_unit', 'economy', 'economy_unit', 'fuel', 'power_price', 'fuel_price', 'price_unit', 'grid', 'grid_custom'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()], 'data' => collect(config('ecology_data'))->only(['grid', 'fuels'])->all()]"
    :how-to="[
        ['name' => 'Enter the yearly distance', 'text' => 'And each car\'s efficiency.'],
        ['name' => 'Choose your grid', 'text' => 'And enter prices.'],
    ]"
    :faqs="[
        ['question' => 'Is an EV cleaner on a coal-heavy grid?', 'answer' => 'It depends on the car; on India\'s grid (about 670 g/kWh) a 30 kWh/100 mi EV emits about 200 g per mile, less than a 30 mpg car\'s 290 g.'],
        ['question' => 'How much cheaper is it to run an EV?', 'answer' => 'Often half the energy cost per mile or less, depending on prices.'],
        ['question' => 'What about making the battery?', 'answer' => 'It adds several tonnes once; studies find EVs usually make this back within a few years of driving.'],
    ]"
>
    <x-calc.field name="distance" label="Distance a year" value="12000" min="0" placeholder="Distance a year">
        <label for="calc-distance-unit" class="sr-only">Distance a year unit</label>
        <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="kwh_100" label="EV electricity use" value="30" min="0" suffix="kWh per 100" />
        <x-calc.select name="kwh_unit" label="Per 100" :options="['mi' => 'miles', 'km' => 'km']" selected="mi" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="economy" label="Gas car fuel economy" value="30" min="0" />
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

    <x-calc.result label="Driving electric instead of gas" />

    <x-calc.options :examples="[
        'US, 12,000 mi' => ['distance' => 12000, 'distance-unit' => 'mi', 'kwh_100' => 30, 'kwh_unit' => 'mi', 'economy' => 30, 'economy_unit' => 'mpg_us', 'fuel' => 'us_gasoline', 'power_price' => 0.16, 'fuel_price' => 3.5, 'price_unit' => 'gal', 'grid' => 'USA'],
        'India, 15,000 km' => ['distance' => 15000, 'distance-unit' => 'km', 'kwh_100' => 15, 'kwh_unit' => 'km', 'economy' => 15, 'economy_unit' => 'kml', 'fuel' => 'us_gasoline', 'power_price' => 0.09, 'fuel_price' => 1.2, 'price_unit' => 'l', 'grid' => 'IND'],
        'France, 15,000 km' => ['distance' => 15000, 'distance-unit' => 'km', 'kwh_100' => 17, 'kwh_unit' => 'km', 'economy' => 6, 'economy_unit' => 'l100km', 'fuel' => 'uk_petrol', 'power_price' => 0.25, 'fuel_price' => 1.8, 'price_unit' => 'l', 'grid' => 'FRA'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ev' => ['label' => 'Electric car'],
            'gas' => ['label' => 'Gas car'],
            'cost' => ['label' => 'Money'],
            'per_mile' => ['label' => 'Per mile'],
            'scope' => ['label' => 'Scope'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EV CO₂ = kWh × grid</li>
            <li>gas CO₂ = liters × fuel factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
