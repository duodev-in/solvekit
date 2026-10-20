<x-calc.page
    title="Ground Speed Calculator - SolveKit"
    description="Free ground speed calculator: aircraft ground speed, track and drift from true airspeed, heading and wind."
    lede="Find ground speed and track with wind."
    about="An aircraft moves through the air at its true airspeed, and the air itself moves with the wind. Adding the two velocity vectors gives the ground speed and the track actually flown. Wind is given the aviation way: the direction it blows from."
    :calc="['engine' => 'ph-mech', 'tool' => 'ground_speed', 'fields' => ['tas', 'heading', 'wind', 'from', 'out'], 'unitFields' => ['tas' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'heading' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'wind' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'from' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the ground speed at 120 kt heading 090° with 20 kt wind from 045°?', 'answer' => '106.798 kn.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tas" label="True airspeed" value="120" placeholder="True airspeed">
            <label for="calc-tas-unit" class="sr-only">True airspeed unit</label>
            <select id="calc-tas-unit" name="tas-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="heading" label="Heading" value="90" placeholder="Heading">
            <label for="calc-heading-unit" class="sr-only">Heading unit</label>
            <select id="calc-heading-unit" name="heading-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="wind" label="Wind speed" value="20" placeholder="Wind speed">
            <label for="calc-wind-unit" class="sr-only">Wind speed unit</label>
            <select id="calc-wind-unit" name="wind-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="from" label="Wind from (direction)" value="45" placeholder="Wind from (direction)">
            <label for="calc-from-unit" class="sr-only">Wind from (direction) unit</label>
            <select id="calc-from-unit" name="from-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="knot" />
    </div>

    <x-calc.result label="Ground speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'knot', 'tas' => 120, 'tas-unit' => 'knot', 'heading' => 90, 'heading-unit' => 'deg', 'wind' => 20, 'wind-unit' => 'knot', 'from' => 45, 'from-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'track' => ['label' => 'Track over the ground'],
            'drift' => ['label' => 'Drift angle'],
            'head' => ['label' => 'Headwind component'],
            'cross' => ['label' => 'Crosswind component'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
