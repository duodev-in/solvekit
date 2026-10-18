<x-calc.page
    title="Car vs. Bike Calculator - SolveKit"
    description="Free car vs bike calculator: CO₂, fuel and money saved and calories burned by cycling trips instead of driving."
    lede="Work out what cycling instead of driving saves."
    about="Fuel saved = distance × fuel use per distance; CO₂ uses the EPA or DESNZ fuel factors. Calories = MET × body weight (kg) × hours, with MET values for each cycling pace from the 2024 Adult Compendium of Physical Activities."
    :calc="['engine' => 'eco-living', 'tool' => 'car_bike', 'fields' => ['distance', 'trips', 'weeks', 'economy', 'economy_unit', 'fuel', 'price', 'price_unit', 'pace', 'weight'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => collect(config('ecology_data'))->only(['fuels', 'cycling'])->all()]"
    :how-to="[
        ['name' => 'Enter the trip and how often', 'text' => 'One-way distance and trips a week.'],
        ['name' => 'Enter the car', 'text' => 'Fuel economy and fuel.'],
        ['name' => 'Choose your pace', 'text' => 'For calories.'],
    ]"
    :faqs="[
        ['question' => 'How much CO₂ does cycling to work save?', 'answer' => 'A 5-mile trip twice a day, 5 days a week, saves about 750 kg a year against a 28 mpg car.'],
        ['question' => 'How many calories does cycling burn?', 'answer' => 'About 6.8 kcal per kg per hour at 10–12 mph.'],
        ['question' => 'Does an e-bike count?', 'answer' => 'Yes, choose the e-bike pace; its charging uses very little electricity.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="distance" label="Trip distance (one way)" value="5" min="0" placeholder="Trip distance (one way)">
            <label for="calc-distance-unit" class="sr-only">Trip distance (one way) unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="trips" label="Trips per week" value="10" min="0" step="1" />
        <x-calc.field name="weeks" label="Weeks a year" value="48" min="1" max="52" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="economy" label="Car fuel economy" value="28" min="0" />
        <x-calc.select name="economy_unit" label="Economy unit" :options="['mpg_us' => 'mpg (US)', 'mpg_uk' => 'mpg (UK)', 'l100km' => 'L/100 km', 'kml' => 'km/L']" selected="mpg_us" />
        <x-calc.select name="fuel" label="Fuel" :options="['us_gasoline' => 'US gasoline (EPA)', 'us_diesel' => 'US diesel (EPA)', 'uk_petrol' => 'Petrol, UK average blend (DESNZ)', 'uk_diesel' => 'Diesel, UK average blend (DESNZ)']" selected="us_gasoline" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Fuel price (optional)" value="3.5" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Price" :options="['l' => 'per liter', 'gal' => 'per US gallon']" selected="gal" />
        <x-calc.select name="pace" label="Cycling pace" :options="collect(config('ecology_data.cycling'))->map(fn ($c) => $c['name'].' ('.$c['met'].' MET)')->all()" selected="10_12" />
    </div>

    <x-calc.field name="weight" label="Your weight (optional)" value="160" min="0" placeholder="Your weight (optional)">
        <label for="calc-weight-unit" class="sr-only">Your weight (optional) unit</label>
        <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Cycling instead of driving" />

    <x-calc.options :examples="[
        'Commute 5 mi, 10 trips a week' => ['distance' => 5, 'distance-unit' => 'mi', 'trips' => 10, 'weeks' => 48, 'economy' => 28, 'economy_unit' => 'mpg_us', 'fuel' => 'us_gasoline', 'price' => 3.5, 'price_unit' => 'gal', 'pace' => '10_12', 'weight' => 160, 'weight-unit' => 'lb'],
        'Errands 3 km, 6 trips' => ['distance' => 3, 'distance-unit' => 'km', 'trips' => 6, 'weeks' => 50, 'economy' => 7, 'economy_unit' => 'l100km', 'fuel' => 'uk_petrol', 'price' => 1.4, 'price_unit' => 'l', 'pace' => 'leisure_lt10', 'weight' => 70, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fuel' => ['label' => 'Fuel saved'],
            'money' => ['label' => 'Money saved'],
            'calories' => ['label' => 'Calories burned'],
            'time' => ['label' => 'Time riding'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fuel = distance × L per distance</li>
            <li>kcal = MET × kg × hours</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
