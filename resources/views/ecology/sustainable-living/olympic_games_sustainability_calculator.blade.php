<x-calc.page
    title="Olympic Games Sustainability Calculator - SolveKit"
    description="Free Olympic Games sustainability calculator: reported carbon footprints of the London, Rio, Tokyo and Paris Games and the footprint of your own trip to the Games."
    lede="Compare the footprints of recent Olympic Games, and your trip to one."
    about="Organising committees report the footprint of each Games: about 3.3 Mt CO₂e for London 2012, 4.5 Mt for Rio 2016, 1.96 Mt for Tokyo 2020 (held without spectators) and 1.59 Mt for Paris 2024. What is counted differs between Games, so compare with care. Your trip adds flights (DESNZ international factors with radiative forcing) and hotel nights (DESNZ hotel factors by country)."
    :calc="['engine' => 'eco-living', 'tool' => 'olympics', 'fields' => ['games', 'flight_km', 'cabin', 'trip', 'nights', 'hotel'], 'unitFields' => ['flight_km' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()], 'data' => collect(config('ecology_data'))->only(['olympics', 'flights', 'hotels'])->all()]"
    :how-to="[
        ['name' => 'Choose the Games', 'text' => 'To see its reported footprint.'],
        ['name' => 'Add your trip', 'text' => 'Flight and hotel nights.'],
    ]"
    :faqs="[
        ['question' => 'What was the carbon footprint of Paris 2024?', 'answer' => '1.59 Mt CO₂e, reported as less than half of London 2012 and Rio 2016.'],
        ['question' => 'Why was Tokyo lower?', 'answer' => 'It was held almost without spectators.'],
        ['question' => 'What is the biggest part of a Games footprint?', 'answer' => 'Usually spectator travel, followed by construction and operations.'],
    ]"
>
    <x-calc.select name="games" label="Games" :options="collect(config('ecology_data.olympics'))->map(fn ($g) => $g['name'])->all()" selected="paris_2024" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="flight_km" label="Flight distance (one way, optional)" value="5500" min="0" placeholder="Flight distance (one way, optional)">
            <label for="calc-flight_km-unit" class="sr-only">Flight distance (one way, optional) unit</label>
            <select id="calc-flight_km-unit" name="flight_km-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="cabin" label="Cabin" :options="['economy' => 'Economy', 'premium_economy' => 'Premium economy', 'business' => 'Business', 'first' => 'First']" selected="economy" />
        <x-calc.segmented name="trip" legend="Trip" :options="['one_way' => 'One way', 'return' => 'Return']" selected="return" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nights" label="Hotel nights" value="7" min="0" step="1" />
        <x-calc.select name="hotel" label="Hotel country" :options="collect(config('ecology_data.hotels'))->map(fn ($h) => $h['name'].' ('.$h['kg'].' kg/night)')->all()" selected="france" />
    </div>

    <x-calc.result label="Games footprint" />

    <x-calc.options :examples="[
        'Paris 2024, trip from New York' => ['games' => 'paris_2024', 'flight_km' => 5840, 'flight_km-unit' => 'km', 'cabin' => 'economy', 'trip' => 'return', 'nights' => 7, 'hotel' => 'france'],
        'London 2012' => ['games' => 'london_2012', 'flight_km' => '', 'nights' => 0, 'hotel' => 'uk_london'],
        'Rio 2016, trip from London' => ['games' => 'rio_2016', 'flight_km' => 9230, 'flight_km-unit' => 'km', 'cabin' => 'economy', 'trip' => 'return', 'nights' => 10, 'hotel' => 'brazil'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'trip' => ['label' => 'Your trip'],
            'versus' => ['label' => 'Against Paris 2024'],
            'scope' => ['label' => 'Scope'],
        ]" />
        <x-calc.quick-ref heading="Games and your trip" name="games" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>trip = km × factor × legs + nights × hotel factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
