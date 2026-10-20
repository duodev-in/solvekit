<x-calc.page
    title="Rolling Down an Incline Calculator - SolveKit"
    description="Free rolling down an incline calculator: speed and time for spheres, discs, rings and sliding blocks."
    lede="Race shapes down a slope."
    about="Rolling objects share their energy between moving and spinning, so they are slower than a frictionless slider. a = g sin θ ÷ (1 + I/mr²): a solid sphere beats a disc, which beats a ring, whatever their size."
    :calc="['engine' => 'ph-mech', 'tool' => 'rolling_incline', 'fields' => ['shape', 'angle', 'L', 'out'], 'unitFields' => ['angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'angle', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is a solid sphere after 5 m down a 15° slope?', 'answer' => '4.25789 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Object" :options="['slide' => 'Sliding block (no rolling)', 'ring' => 'Ring or hoop', 'tube' => 'Thin-walled tube', 'disc' => 'Solid disc or cylinder', 'sphere' => 'Solid sphere', 'shell' => 'Hollow sphere']" selected="sphere" />
        <x-calc.field name="angle" label="Slope angle" value="15" placeholder="Slope angle">
            <label for="calc-angle-unit" class="sr-only">Slope angle unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Slope length" value="5" placeholder="Slope length">
            <label for="calc-L-unit" class="sr-only">Slope length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Speed at the bottom" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'shape' => 'sphere', 'angle' => 15, 'angle-unit' => 'deg', 'L' => 5, 'L-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Acceleration'],
            't' => ['label' => 'Time to roll down'],
            'race' => ['label' => 'Order in a race (fastest first)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
