<x-calc.page
    title="Wind Correction Angle Calculator - SolveKit"
    description="Free wind correction angle calculator: heading and ground speed to hold a course in a crosswind."
    lede="Find the wind correction angle."
    about="To hold a course in a crosswind, a pilot points the aircraft into the wind by the wind correction angle."
    :calc="['engine' => 'ph-fluid', 'tool' => 'wind_correction', 'fields' => ['tas', 'course', 'wind', 'from', 'out'], 'unitFields' => ['tas' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'course' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'wind' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'from' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What correction holds 090° at 120 kt with 20 kt from 045°?', 'answer' => '−6.7681 °.'],
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
        <x-calc.field name="course" label="Desired course" value="90" placeholder="Desired course">
            <label for="calc-course-unit" class="sr-only">Desired course unit</label>
            <select id="calc-course-unit" name="course-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
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
        <x-calc.field name="from" label="Wind from" value="45" placeholder="Wind from">
            <label for="calc-from-unit" class="sr-only">Wind from unit</label>
            <select id="calc-from-unit" name="from-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="Wind correction angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'tas' => 120, 'tas-unit' => 'knot', 'course' => 90, 'course-unit' => 'deg', 'wind' => 20, 'wind-unit' => 'knot', 'from' => 45, 'from-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'heading' => ['label' => 'Heading to fly'],
            'gs' => ['label' => 'Ground speed'],
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
