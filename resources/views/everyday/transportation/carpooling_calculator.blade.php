<x-calc.page
    title="Carpooling Calculator - SolveKit"
    description="Free carpooling calculator: what each rider pays to share fuel, tolls and parking, the savings against driving alone, and the CO₂ saved."
    lede="Split the cost of a shared car trip fairly."
    about="Trip cost = fuel (distance × fuel use × price) + tolls + parking, split between everyone in the car. Each rider saves the difference against paying it all alone. CO₂ saved assumes each rider would otherwise have driven a similar car, using EPA (US) or DESNZ (UK) fuel factors."
    :calc="['engine' => 'ev-transport', 'tool' => 'carpool', 'fields' => ['distance', 'round_trip', 'economy', 'economy_unit', 'price', 'price_unit', 'riders', 'tolls', 'parking', 'fuel'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()], 'data' => ['fuels' => config('ecology_data.fuels')]]"
    :how-to="[
        ['name' => 'Enter the trip', 'text' => 'Distance, car economy and fuel price.'],
        ['name' => 'Add tolls and parking', 'text' => 'And how many share the car.'],
    ]"
    :faqs="[
        ['question' => 'How do you split gas for a carpool?', 'answer' => 'Add fuel, tolls and parking and divide by the number of people.'],
        ['question' => 'How much does a 3-person carpool save?', 'answer' => 'Each pays a third: two-thirds saved against driving alone.'],
        ['question' => 'Should the driver pay a share?', 'answer' => 'Usually yes, and some groups also share wear and tear.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="distance" label="Distance" value="30" min="0" placeholder="Distance">
            <label for="calc-distance-unit" class="sr-only">Distance unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.checkbox name="round_trip" label="Round trip (double it)" :checked="true" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="economy" label="Fuel economy" value="30" min="0" step="0.1" />
        <x-calc.select name="economy_unit" label="Economy unit" :options="['mpg_us' => 'mpg (US)', 'mpg_uk' => 'mpg (UK)', 'l100km' => 'L/100 km', 'kml' => 'km/L']" selected="mpg_us" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Fuel price" value="3.5" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Price" :options="['gal' => 'per US gallon', 'l' => 'per liter', 'gal_uk' => 'per UK gallon']" selected="gal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="riders" label="People sharing (with driver)" value="3" min="1" step="1" />
        <x-calc.field name="tolls" label="Tolls" value="6" min="0" step="0.01" suffix="$" />
        <x-calc.field name="parking" label="Parking" value="15" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.select name="fuel" label="Fuel (for CO₂)" :options="['us_gasoline' => 'Gasoline (EPA)', 'us_diesel' => 'Diesel (EPA)', 'uk_petrol' => 'Petrol, UK blend (DESNZ)', 'uk_diesel' => 'Diesel, UK blend (DESNZ)']" selected="us_gasoline" />

    <x-calc.result label="Cost per person" />

    <x-calc.options :examples="[
        'Commute, 3 people' => ['distance' => 30, 'distance-unit' => 'mi', 'round_trip' => true, 'economy' => 30, 'economy_unit' => 'mpg_us', 'price' => 3.5, 'price_unit' => 'gal', 'riders' => 3, 'tolls' => 6, 'parking' => 15, 'fuel' => 'us_gasoline'],
        'Road trip, 4 friends' => ['distance' => 400, 'distance-unit' => 'mi', 'round_trip' => true, 'economy' => 25, 'economy_unit' => 'mpg_us', 'price' => 3.4, 'price_unit' => 'gal', 'riders' => 4, 'tolls' => 20, 'parking' => 0, 'fuel' => 'us_gasoline'],
        'Metric, 2 people' => ['distance' => 45, 'distance-unit' => 'km', 'round_trip' => true, 'economy' => 6.5, 'economy_unit' => 'l100km', 'price' => 1.6, 'price_unit' => 'l', 'riders' => 2, 'tolls' => 0, 'parking' => 8, 'fuel' => 'uk_petrol'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fuel' => ['label' => 'Fuel used'],
            'saving' => ['label' => 'Saving per rider'],
            'co2' => ['label' => 'CO₂ saved'],
            'distance' => ['label' => 'Distance'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost each = (fuel + tolls + parking) ÷ people</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
