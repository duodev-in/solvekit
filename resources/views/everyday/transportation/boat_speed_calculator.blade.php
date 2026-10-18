<x-calc.page
    title="Boat Speed Calculator - SolveKit"
    description="Free boat speed calculator: estimated top speed of a planing boat from horsepower and weight using Crouch's formula, in knots, mph and km/h."
    lede="Estimate a planing boat's top speed from its power and weight."
    about="Crouch's formula, used by naval architects for planing hulls: speed (knots) = C ÷ √(weight in lb ÷ shaft horsepower). The constant C reflects the hull: about 150 for average runabouts and cruisers, 190 for high-speed runabouts, 210 for race boats and 220 for three-point hydroplanes (Dave Gerr, The Propeller Handbook). Use the loaded weight and the power at the propeller shaft."
    :calc="['engine' => 'ev-transport', 'tool' => 'boat_speed', 'fields' => ['power', 'weight', 'constant'], 'unitFields' => ['power' => collect(config('units.power'))->only(['hp', 'kw', 'ps'])->all(), 'weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter power and weight', 'text' => 'Shaft horsepower and the loaded boat.'],
        ['name' => 'Pick the hull', 'text' => 'It sets Crouch\'s constant.'],
    ]"
    :faqs="[
        ['question' => 'How fast will a 4,000 lb boat with 250 hp go?', 'answer' => 'About 37.5 knots (43 mph) with C = 150.'],
        ['question' => 'Does it work for sailboats?', 'answer' => 'No, only for planing hulls; displacement hulls are limited by hull speed.'],
        ['question' => 'What weight should I use?', 'answer' => 'The boat with fuel, gear and people aboard.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="power" label="Shaft horsepower" value="250" min="0" placeholder="Shaft horsepower">
            <label for="calc-power-unit" class="sr-only">Shaft horsepower unit</label>
            <select id="calc-power-unit" name="power-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['hp', 'kw', 'ps']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Loaded boat weight" value="4000" min="0" placeholder="Loaded boat weight">
            <label for="calc-weight-unit" class="sr-only">Loaded boat weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.select name="constant" label="Hull type (Crouch constant)" :options="['150' => 'Average runabout or cruiser (150)', '190' => 'High-speed runabout (190)', '210' => 'Race boat (210)', '220' => 'Three-point hydroplane (220)']" selected="150" />

    <x-calc.result label="Estimated top speed" />

    <x-calc.options :examples="[
        'Runabout, 250 hp' => ['power' => 250, 'power-unit' => 'hp', 'weight' => 4000, 'weight-unit' => 'lb', 'constant' => '150'],
        'Bass boat, 200 hp' => ['power' => 200, 'power-unit' => 'hp', 'weight' => 2600, 'weight-unit' => 'lb', 'constant' => '190'],
        'Cruiser, 2 × 300 kW' => ['power' => 600, 'power-unit' => 'kw', 'weight' => 9000, 'weight-unit' => 'kg', 'constant' => '150'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mph' => ['label' => 'In mph'],
            'kmh' => ['label' => 'In km/h'],
            'ratio' => ['label' => 'Weight to power'],
            'note' => ['label' => 'Limits'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>knots = C ÷ √(lb ÷ hp)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
