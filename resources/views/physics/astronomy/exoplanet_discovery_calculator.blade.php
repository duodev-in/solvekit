<x-calc.page
    title="Exoplanet Discovery Calculator - SolveKit"
    description="Free exoplanet calculator: transit depth, radial-velocity wobble and transit duration for a planet around a star."
    lede="See how detectable a planet is."
    about="A planet crossing its star dims it by (R_p/R_*)², and its pull makes the star wobble at a few m/s or less. Earth seen from afar dims the Sun by 84 ppm and moves it by 9 cm/s."
    :calc="['engine' => 'ph-astro', 'tool' => 'exoplanet', 'fields' => ['Ms', 'Rs', 'Mp', 'Rp', 'P', 'incl'], 'unitFields' => ['Ms' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'Mp' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'P' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'incl' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How deep is Earth’s transit across the Sun?', 'answer' => '83.86 ppm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Ms" label="Star mass" value="1" min="0" placeholder="Star mass">
            <label for="calc-Ms-unit" class="sr-only">Star mass unit</label>
            <select id="calc-Ms-unit" name="Ms-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'msun')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Rs" label="Star radius (in solar radii)" value="1" min="0" step="any" />
        <x-calc.field name="Mp" label="Planet mass" value="1" min="0" placeholder="Planet mass">
            <label for="calc-Mp-unit" class="sr-only">Planet mass unit</label>
            <select id="calc-Mp-unit" name="Mp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mearth')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Rp" label="Planet radius (in Earth radii)" value="1" min="0" step="any" />
        <x-calc.field name="P" label="Orbital period" value="365.256" placeholder="Orbital period">
            <label for="calc-P-unit" class="sr-only">Orbital period unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'day')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="incl" label="Inclination" value="90" placeholder="Inclination">
            <label for="calc-incl-unit" class="sr-only">Inclination unit</label>
            <select id="calc-incl-unit" name="incl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Transit depth" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Ms' => 1, 'Ms-unit' => 'msun', 'Rs' => 1, 'Mp' => 1, 'Mp-unit' => 'mearth', 'Rp' => 1, 'P' => 365.256, 'P-unit' => 'day', 'incl' => 90, 'incl-unit' => 'deg'],
        'Hot Jupiter' => ['Ms' => 1, 'Ms-unit' => 'msun', 'Rs' => 1, 'Mp' => 1, 'Mp-unit' => 'mjup', 'Rp' => 11.2, 'P' => 3.5, 'P-unit' => 'day', 'incl' => 90, 'incl-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'K' => ['label' => 'Radial-velocity amplitude of the star'],
            'a' => ['label' => 'Orbit size (semi-major axis)'],
            'dur' => ['label' => 'Transit duration (central transit)'],
            'prob' => ['label' => 'Chance a random orientation transits'],
            'astro' => ['label' => 'Star’s wobble (astrometric, at 10 pc)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
