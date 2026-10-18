<x-calc.page
    title="Traffic Density Calculator - SolveKit"
    description="Free traffic density calculator: vehicles per km or mile from flow and speed, or from a count over a road length, with spacing, headway and level of service."
    lede="Work out traffic density, spacing and headway."
    about="Traffic flow, speed and density are linked by q = k × v: density k = flow q ÷ speed v. Spacing = 1 ÷ density and headway = 1 ÷ flow, per lane. The Highway Capacity Manual grades freeway level of service by density from A (free flow) to F (breakdown above about 28 passenger cars per km per lane)."
    :calc="['engine' => 'ev-transport', 'tool' => 'traffic', 'fields' => ['mode', 'flow', 'speed', 'vehicles', 'length', 'lanes'], 'unitFields' => ['speed' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all(), 'length' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Flow and speed, or a count.'],
        ['name' => 'Enter the values', 'text' => 'And the number of lanes.'],
    ]"
    :faqs="[
        ['question' => 'What is traffic density?', 'answer' => 'Vehicles per unit length of road.'],
        ['question' => 'What is the density at 3,600 veh/h and 55 mph?', 'answer' => 'About 40.7 vehicles per km, 20.3 per km per lane on 2 lanes.'],
        ['question' => 'What is headway?', 'answer' => 'The time between successive vehicles passing a point.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['flow' => 'Flow and speed', 'count' => 'Count on a length']" selected="flow" />

    <div data-show-when="mode:flow">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="flow" label="Flow" value="3600" min="1" step="1" suffix="veh/h" />
            <x-calc.field name="speed" label="Average speed" value="55" min="0" placeholder="Average speed">
                <label for="calc-speed-unit" class="sr-only">Average speed unit</label>
                <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:count" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="vehicles" label="Vehicles counted" value="60" min="1" step="1" />
            <x-calc.field name="length" label="Road length" value="1" min="0" placeholder="Road length">
                <label for="calc-length-unit" class="sr-only">Road length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.field name="lanes" label="Lanes (one direction)" value="2" min="1" step="1" />

    <x-calc.result label="Traffic density" />

    <x-calc.options :examples="[
        '3,600 veh/h at 55 mph' => ['mode' => 'flow', 'flow' => 3600, 'speed' => 55, 'speed-unit' => 'mph', 'vehicles' => '', 'length' => '', 'length-unit' => 'mi', 'lanes' => 2],
        '60 cars on a mile' => ['mode' => 'count', 'flow' => '', 'speed' => '', 'speed-unit' => 'mph', 'vehicles' => 60, 'length' => 1, 'length-unit' => 'mi', 'lanes' => 2],
        'City street' => ['mode' => 'flow', 'flow' => 900, 'speed' => 30, 'speed-unit' => 'kmh', 'vehicles' => '', 'length' => '', 'length-unit' => 'mi', 'lanes' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'spacing' => ['label' => 'Spacing'],
            'headway' => ['label' => 'Headway'],
            'los' => ['label' => 'Level of service'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>k = q ÷ v</li>
            <li>spacing = 1 ÷ k</li>
            <li>headway = 1 ÷ q</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
