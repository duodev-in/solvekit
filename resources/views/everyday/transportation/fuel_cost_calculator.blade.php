<x-calc.page
    title="Fuel Cost Calculator - SolveKit"
    description="Free fuel cost calculator: fuel used and cost of a trip from distance, fuel economy in mpg, L/100 km or km/L, and fuel price."
    lede="Work out the fuel cost of any trip."
    about="Fuel used = distance × fuel per distance (from mpg, L/100 km or km/L), and cost = fuel × price. 1 US gallon = 3.785 L; 1 UK gallon = 4.546 L."
    :calc="['engine' => 'ev-transport', 'tool' => 'fuel_cost', 'fields' => ['distance', 'round_trip', 'economy', 'economy_unit', 'price', 'price_unit'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the distance', 'text' => 'Tick round trip to double it.'],
        ['name' => 'Enter fuel economy and price', 'text' => 'In your units.'],
    ]"
    :faqs="[
        ['question' => 'How much fuel for 250 miles at 28 mpg?', 'answer' => '8.93 US gallons, about $31 at $3.50 a gallon.'],
        ['question' => 'How do I convert mpg to L/100 km?', 'answer' => '235.2 ÷ mpg (US).'],
        ['question' => 'Does round trip double the cost?', 'answer' => 'Yes, it doubles the distance.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="distance" label="Distance" value="250" min="0" placeholder="Distance">
            <label for="calc-distance-unit" class="sr-only">Distance unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.checkbox name="round_trip" label="Round trip (double it)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="economy" label="Fuel economy" value="28" min="0" step="0.1" />
        <x-calc.select name="economy_unit" label="Economy unit" :options="['mpg_us' => 'mpg (US)', 'mpg_uk' => 'mpg (UK)', 'l100km' => 'L/100 km', 'kml' => 'km/L']" selected="mpg_us" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Fuel price" value="3.5" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Price" :options="['gal' => 'per US gallon', 'l' => 'per liter', 'gal_uk' => 'per UK gallon']" selected="gal" />
    </div>

    <x-calc.result label="Fuel cost" />

    <x-calc.options :examples="[
        '250 mi at 28 mpg' => ['distance' => 250, 'distance-unit' => 'mi', 'round_trip' => false, 'economy' => 28, 'economy_unit' => 'mpg_us', 'price' => 3.5, 'price_unit' => 'gal'],
        'Round trip, 6.5 L/100 km' => ['distance' => 320, 'distance-unit' => 'km', 'round_trip' => true, 'economy' => 6.5, 'economy_unit' => 'l100km', 'price' => 1.75, 'price_unit' => 'l'],
        'Diesel van, UK' => ['distance' => 180, 'distance-unit' => 'mi', 'round_trip' => false, 'economy' => 38, 'economy_unit' => 'mpg_uk', 'price' => 1.45, 'price_unit' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fuel' => ['label' => 'Fuel used'],
            'mile' => ['label' => 'Per mile'],
            'hundred' => ['label' => 'Fuel use'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fuel = distance × fuel per distance</li>
            <li>cost = fuel × price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
