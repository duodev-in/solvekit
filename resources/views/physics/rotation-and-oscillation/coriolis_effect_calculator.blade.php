<x-calc.page
    title="Coriolis Effect Calculator - SolveKit"
    description="Free Coriolis effect calculator: Coriolis acceleration and sideways deflection for motion over the Earth."
    lede="Find the Coriolis deflection."
    about="On the rotating Earth, horizontally moving objects drift sideways: right in the northern hemisphere, left in the southern. The acceleration is 2Ωv sin(latitude)."
    :calc="['engine' => 'ph-mech', 'tool' => 'coriolis', 'fields' => ['v', 'lat', 'd', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'lat' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does a bullet at 800 m/s drift over 1 km at 45°?', 'answer' => 'Deflection 0.0644538 m over 1 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Speed" value="800" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="lat" label="Latitude" value="45" placeholder="Latitude">
            <label for="calc-lat-unit" class="sr-only">Latitude unit</label>
            <select id="calc-lat-unit" name="lat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Distance travelled" value="1" placeholder="Distance travelled">
            <label for="calc-d-unit" class="sr-only">Distance travelled unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
    </div>

    <x-calc.result label="Coriolis acceleration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms2', 'v' => 800, 'v-unit' => 'ms', 'lat' => 45, 'lat-unit' => 'deg', 'd' => 1, 'd-unit' => 'km'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'defl' => ['label' => 'Sideways deflection over that distance'],
            'dir' => ['label' => 'Direction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
