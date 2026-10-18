<x-calc.page
    title="Flight Carbon Footprint Calculator - SolveKit"
    description="Free flight carbon footprint calculator: CO₂e of a flight between any two airports by cabin class, one way or return, with and without radiative forcing, using UK government DESNZ 2025 factors."
    lede="Work out the carbon footprint of a flight."
    about="The distance is the great-circle distance between the airports (OurAirports data). DESNZ 2025 factors already add 8% for indirect routes and delays. Flights to or from the UK are split into domestic, short-haul (Europe and North Africa) and long-haul; other flights use the international average, which can understate short domestic flights. With RF includes the warming from contrails and other non-CO₂ effects."
    :calc="['engine' => 'eco-footprint', 'tool' => 'flight', 'fields' => ['mode', 'from', 'to', 'distance', 'category', 'cabin', 'trip', 'passengers', 'rf'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()], 'data' => ['flights' => config('ecology_data.flights')]]"
    :how-to="[
        ['name' => 'Enter the airports', 'text' => 'IATA codes like LHR or a city name.'],
        ['name' => 'Choose cabin and trip', 'text' => 'Business and first take more space per passenger.'],
    ]"
    :faqs="[
        ['question' => 'How much CO₂ is a London–New York return?', 'answer' => 'About 1.3 t CO₂e in economy with radiative forcing (DESNZ 2025).'],
        ['question' => 'What is radiative forcing?', 'answer' => 'Extra warming from contrails, water vapor and NOx at altitude, roughly 1.7 times the CO₂ effect.'],
        ['question' => 'Why does business class count more?', 'answer' => 'Seats take more floor space, so each passenger carries a larger share of the plane.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Route" :options="['airports' => 'Airports', 'distance' => 'Distance']" selected="airports" />

    <datalist id="airport-list"></datalist>

    <div data-show-when="mode:airports">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="from" label="From" value="LHR" type="text" placeholder="IATA code or city" list="airport-list" />
            <x-calc.field name="to" label="To" value="JFK" type="text" placeholder="IATA code or city" list="airport-list" />
        </div>
    </div>

    <div data-show-when="mode:distance" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="distance" label="Distance one way" value="1000" min="0" placeholder="Distance one way">
                <label for="calc-distance-unit" class="sr-only">Distance one way unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.select name="category" label="Type of flight" :options="['international' => 'International average', 'domestic' => 'UK domestic', 'short' => 'Short-haul (UK–Europe)', 'long' => 'Long-haul (to/from UK)']" selected="international" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="cabin" label="Cabin" :options="['economy' => 'Economy', 'premium_economy' => 'Premium economy', 'business' => 'Business', 'first' => 'First', 'average_passenger' => 'Average passenger']" selected="economy" />
        <x-calc.segmented name="trip" legend="Trip" :options="['one_way' => 'One way', 'return' => 'Return']" selected="return" />
        <x-calc.field name="passengers" label="Passengers" value="1" min="1" step="1" />
    </div>

    <x-calc.segmented name="rf" legend="Non-CO₂ effects" :options="['yes' => 'Include (with RF)', 'no' => 'CO₂, CH₄, N₂O only']" selected="yes" />

    <x-calc.result label="Flight emissions including non-CO₂ effects" />

    <x-calc.options :examples="[
        'London to New York, return' => ['mode' => 'airports', 'from' => 'LHR', 'to' => 'JFK', 'cabin' => 'economy', 'trip' => 'return', 'passengers' => 1, 'rf' => 'yes'],
        'Delhi to Mumbai' => ['mode' => 'airports', 'from' => 'DEL', 'to' => 'BOM', 'cabin' => 'economy', 'trip' => 'one_way', 'passengers' => 1, 'rf' => 'yes'],
        'London to Paris, business' => ['mode' => 'airports', 'from' => 'LHR', 'to' => 'CDG', 'cabin' => 'business', 'trip' => 'return', 'passengers' => 2, 'rf' => 'no'],
        '5,000 km one way' => ['mode' => 'distance', 'distance' => 5000, 'distance-unit' => 'km', 'category' => 'international', 'cabin' => 'economy', 'trip' => 'one_way', 'passengers' => 1, 'rf' => 'yes'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'distance' => ['label' => 'Distance'],
            'with_rf' => ['label' => 'With radiative forcing'],
            'without_rf' => ['label' => 'Without'],
            'factor' => ['label' => 'Factor'],
            'cabin' => ['label' => 'Trip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>distance = 2R asin(√(sin²(Δφ/2) + cos φ₁ cos φ₂ sin²(Δλ/2)))</li>
            <li>CO₂e = km × factor (kg per passenger-km) × legs × passengers</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
