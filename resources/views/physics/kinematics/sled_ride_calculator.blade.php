<x-calc.page
    title="Sled Ride Calculator - SolveKit"
    description="Free sled ride calculator: speed at the bottom of a hill, time on the slope and run-out distance with snow friction."
    lede="Find how fast a sled goes."
    about="A sled accelerates down a slope at g(sin θ − μ cos θ), then slows on the flat at μg. Waxed sleds on packed snow have μ around 0.05; fresh powder is much draggier."
    :calc="['engine' => 'ph-mech', 'tool' => 'sled', 'fields' => ['h', 'angle', 'mu', 'm', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is a sled after a 15 m drop on a 20° slope?', 'answer' => '57.3502 km/h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h" label="Hill height" value="15" placeholder="Hill height">
            <label for="calc-h-unit" class="sr-only">Hill height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="angle" label="Slope angle" value="20" placeholder="Slope angle">
            <label for="calc-angle-unit" class="sr-only">Slope angle unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mu" label="Friction coefficient μ (snow ≈ 0.05)" value="0.05" min="0" step="any" />
        <x-calc.field name="m" label="Rider and sled mass" value="60" min="0" placeholder="Rider and sled mass">
            <label for="calc-m-unit" class="sr-only">Rider and sled mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kmh" />
    </div>

    <x-calc.result label="Speed at the bottom" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kmh', 'h' => 15, 'h-unit' => 'm', 'angle' => 20, 'angle-unit' => 'deg', 'mu' => 0.05, 'm' => 60, 'm-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'time' => ['label' => 'Time on the slope'],
            'runout' => ['label' => 'Run-out distance on the flat'],
            'length' => ['label' => 'Slope length'],
            'lost' => ['label' => 'Energy lost to friction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
