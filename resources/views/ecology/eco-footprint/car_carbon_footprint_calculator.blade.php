<x-calc.page
    title="Car Carbon Footprint Calculator - SolveKit"
    description="Free car carbon footprint calculator: CO₂ from driving a gasoline or diesel car, from distance and fuel economy or the fuel you bought."
    lede="Work out the CO₂ from driving."
    about="CO₂ = fuel burned × the fuel's emission factor: 8.78 kg per US gallon of gasoline and 10.21 kg per gallon of diesel (EPA Emission Factors Hub 2025), or 2.07 kg per liter of UK petrol and 2.57 kg per liter of diesel including the biofuel blend (DESNZ 2025)."
    :calc="['engine' => 'eco-footprint', 'tool' => 'car', 'fields' => ['mode', 'distance', 'economy', 'economy_unit', 'fuel_amount', 'fuel'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'fuel_amount' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all()], 'data' => ['fuels' => config('ecology_data.fuels')]]"
    :how-to="[
        ['name' => 'Enter the distance and fuel economy', 'text' => 'Or the fuel you bought.'],
        ['name' => 'Choose the fuel', 'text' => 'US or UK factors.'],
    ]"
    :faqs="[
        ['question' => 'How much CO₂ does a gallon of gasoline make?', 'answer' => '8.78 kg (EPA Emission Factors Hub 2025).'],
        ['question' => 'What is the footprint of 12,000 miles at 28 mpg?', 'answer' => 'About 3.8 t CO₂.'],
        ['question' => 'Does this include making the car?', 'answer' => 'No, only the fuel burned.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['distance' => 'Distance and fuel economy', 'fuel' => 'Fuel bought']" selected="distance" />

    <div data-show-when="mode:distance">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="distance" label="Distance" value="12000" min="0" placeholder="Distance">
                <label for="calc-distance-unit" class="sr-only">Distance unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="economy" label="Fuel economy" value="28" min="0" />
            <x-calc.select name="economy_unit" label="Economy unit" :options="['mpg_us' => 'mpg (US)', 'mpg_uk' => 'mpg (UK)', 'l100km' => 'L/100 km', 'kml' => 'km/L']" selected="mpg_us" />
        </div>
    </div>

    <div data-show-when="mode:fuel" hidden>
        <x-calc.field name="fuel_amount" label="Fuel used" value="400" min="0" placeholder="Fuel used">
            <label for="calc-fuel_amount-unit" class="sr-only">Fuel used unit</label>
            <select id="calc-fuel_amount-unit" name="fuel_amount-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.select name="fuel" label="Fuel" :options="['us_gasoline' => 'US gasoline (EPA)', 'us_diesel' => 'US diesel (EPA)', 'uk_petrol' => 'Petrol, UK average blend (DESNZ)', 'uk_diesel' => 'Diesel, UK average blend (DESNZ)']" selected="us_gasoline" />

    <x-calc.result label="Driving emissions" />

    <x-calc.options :examples="[
        '12,000 mi at 28 mpg' => ['mode' => 'distance', 'distance' => 12000, 'distance-unit' => 'mi', 'economy' => 28, 'economy_unit' => 'mpg_us', 'fuel' => 'us_gasoline'],
        '15,000 km at 6 L/100 km' => ['mode' => 'distance', 'distance' => 15000, 'distance-unit' => 'km', 'economy' => 6, 'economy_unit' => 'l100km', 'fuel' => 'uk_petrol'],
        '400 gal of diesel' => ['mode' => 'fuel', 'fuel_amount' => 400, 'fuel_amount-unit' => 'gal_us', 'fuel' => 'us_diesel'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fuel' => ['label' => 'Fuel'],
            'per_km' => ['label' => 'Per distance'],
            'tonnes' => ['label' => 'Tonnes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CO₂ = liters × kg CO₂ per liter</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
