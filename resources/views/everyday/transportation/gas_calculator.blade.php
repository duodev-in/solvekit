<x-calc.page
    title="Gas Calculator - SolveKit"
    description="Free gas calculator: gallons of gas and cost for a trip, split per person, with the number of tank fills."
    lede="Work out the gas cost of a trip and each person's share."
    about="Gas needed = distance ÷ mpg; cost = gallons × price; each person's share = cost ÷ people. The tank count shows how many full tanks the trip uses."
    :calc="['engine' => 'ev-transport', 'tool' => 'gas', 'fields' => ['distance', 'round_trip', 'economy', 'economy_unit', 'price', 'price_unit', 'people', 'tank'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'tank' => collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk'])->all()]]"
    :how-to="[
        ['name' => 'Enter the trip', 'text' => 'Distance, mpg and gas price.'],
        ['name' => 'Add people and tank size', 'text' => 'To split the cost.'],
    ]"
    :faqs="[
        ['question' => 'How much gas for a 600-mile round trip at 30 mpg?', 'answer' => '40 gallons: $136 at $3.40.'],
        ['question' => 'How do I split gas money?', 'answer' => 'Divide the total by the number of people.'],
        ['question' => 'How far does a tank go?', 'answer' => 'Tank size × mpg: 14 gal × 30 mpg = 420 miles.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="distance" label="Distance" value="600" min="0" placeholder="Distance">
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
        <x-calc.field name="price" label="Fuel price" value="3.4" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Price" :options="['gal' => 'per US gallon', 'l' => 'per liter', 'gal_uk' => 'per UK gallon']" selected="gal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="people" label="People sharing" value="2" min="1" step="1" />
        <x-calc.field name="tank" label="Tank size (optional)" value="14" min="0" placeholder="Tank size (optional)">
            <label for="calc-tank-unit" class="sr-only">Tank size (optional) unit</label>
            <select id="calc-tank-unit" name="tank-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Gas cost" />

    <x-calc.options :examples="[
        '600 mi round trip, 2 people' => ['distance' => 600, 'distance-unit' => 'mi', 'round_trip' => true, 'economy' => 30, 'economy_unit' => 'mpg_us', 'price' => 3.4, 'price_unit' => 'gal', 'people' => 2, 'tank' => 14, 'tank-unit' => 'gal_us'],
        'Road trip, 4 people' => ['distance' => 1200, 'distance-unit' => 'mi', 'round_trip' => false, 'economy' => 24, 'economy_unit' => 'mpg_us', 'price' => 3.6, 'price_unit' => 'gal', 'people' => 4, 'tank' => 18, 'tank-unit' => 'gal_us'],
        'Metric' => ['distance' => 500, 'distance-unit' => 'km', 'round_trip' => true, 'economy' => 7, 'economy_unit' => 'l100km', 'price' => 1.7, 'price_unit' => 'l', 'people' => 3, 'tank' => 50, 'tank-unit' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'person' => ['label' => 'Per person'],
            'fuel' => ['label' => 'Gas used'],
            'tanks' => ['label' => 'Tanks'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gallons = miles ÷ mpg</li>
            <li>cost = gallons × price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
