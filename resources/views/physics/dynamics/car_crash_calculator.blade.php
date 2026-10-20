<x-calc.page
    title="Car Crash Calculator - SolveKit"
    description="Free car crash force calculator: average impact force and g-force from speed, mass and stopping distance."
    lede="Find the force in a crash."
    about="In a crash the kinetic energy ½mv² is absorbed over the stopping distance, so the average force is ½mv² ÷ d. Seat belts and crumple zones lengthen d and cut the force. Real peak forces are higher than the average."
    :calc="['engine' => 'ph-mech', 'tool' => 'car_crash', 'fields' => ['m', 'v', 'd', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'short_time', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What force acts on a 75 kg person stopping from 50 km/h in 50 cm?', 'answer' => '14.4676 kN, 19.6705 g average deceleration.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Mass of the person (or car)" value="75" min="0" placeholder="Mass of the person (or car)">
            <label for="calc-m-unit" class="sr-only">Mass of the person (or car) unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Impact speed" value="50" placeholder="Impact speed">
            <label for="calc-v-unit" class="sr-only">Impact speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Stopping distance (crumple zone, belt stretch)" value="50" placeholder="Stopping distance (crumple zone, belt stretch)">
            <label for="calc-d-unit" class="sr-only">Stopping distance (crumple zone, belt stretch) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="kn" />
    </div>

    <x-calc.result label="Average impact force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kn', 'm' => 75, 'm-unit' => 'kg', 'v' => 50, 'v-unit' => 'kmh', 'd' => 50, 'd-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g' => ['label' => 'Average deceleration'],
            'time' => ['label' => 'Duration of the impact'],
            'energy' => ['label' => 'Kinetic energy'],
            'fall' => ['label' => 'Equivalent fall height'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
