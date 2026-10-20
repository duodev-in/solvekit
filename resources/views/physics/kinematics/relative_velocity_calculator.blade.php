<x-calc.page
    title="Relative Velocity Calculator - SolveKit"
    description="Free relative velocity calculator: the velocity of one object as seen from another moving object."
    lede="Find the velocity of A relative to B."
    about="The velocity of A relative to B is v_A − v_B as vectors. Two cars at 60 and 80 km/h at right angles approach each other at 100 km/h."
    :calc="['engine' => 'ph-mech', 'tool' => 'relative_velocity', 'fields' => ['va', 'da', 'vb', 'db', 'out'], 'unitFields' => ['va' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'da' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'vb' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'db' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'A goes 60 km/h east, B 80 km/h north. How fast does A move relative to B?', 'answer' => '100 km/h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="va" label="Speed of A" value="60" placeholder="Speed of A">
            <label for="calc-va-unit" class="sr-only">Speed of A unit</label>
            <select id="calc-va-unit" name="va-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="da" label="Direction of A" value="0" placeholder="Direction of A">
            <label for="calc-da-unit" class="sr-only">Direction of A unit</label>
            <select id="calc-da-unit" name="da-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vb" label="Speed of B" value="80" placeholder="Speed of B">
            <label for="calc-vb-unit" class="sr-only">Speed of B unit</label>
            <select id="calc-vb-unit" name="vb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="db" label="Direction of B" value="90" placeholder="Direction of B">
            <label for="calc-db-unit" class="sr-only">Direction of B unit</label>
            <select id="calc-db-unit" name="db-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kmh" />
    </div>

    <x-calc.result label="Speed of A relative to B" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kmh', 'va' => 60, 'va-unit' => 'kmh', 'da' => 0, 'da-unit' => 'deg', 'vb' => 80, 'vb-unit' => 'kmh', 'db' => 90, 'db-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dir' => ['label' => 'Direction of A as seen from B'],
            'ba' => ['label' => 'B relative to A'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
