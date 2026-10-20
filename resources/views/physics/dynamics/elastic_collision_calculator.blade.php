<x-calc.page
    title="Elastic Collision Calculator - SolveKit"
    description="Free elastic collision calculator: final velocities after a 1D elastic collision from the masses and initial velocities."
    lede="Find velocities after an elastic collision."
    about="In an elastic collision both momentum and kinetic energy are conserved, which fixes both final velocities. Equal masses swap velocities; a light ball bounces off a heavy one."
    :calc="['engine' => 'ph-mech', 'tool' => 'elastic_collision', 'fields' => ['m1', 'u1', 'm2', 'u2', 'out'], 'unitFields' => ['m1' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'u1' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'm2' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'u2' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'A 1 kg ball at 4 m/s hits a resting 3 kg ball. What happens?', 'answer' => 'It moves at −2 m/s; Body 2 leaves at 2 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m1" label="Mass 1" value="1" min="0" placeholder="Mass 1">
            <label for="calc-m1-unit" class="sr-only">Mass 1 unit</label>
            <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="u1" label="Velocity 1" value="4" placeholder="Velocity 1">
            <label for="calc-u1-unit" class="sr-only">Velocity 1 unit</label>
            <select id="calc-u1-unit" name="u1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m2" label="Mass 2" value="3" min="0" placeholder="Mass 2">
            <label for="calc-m2-unit" class="sr-only">Mass 2 unit</label>
            <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="u2" label="Velocity 2" value="0" placeholder="Velocity 2">
            <label for="calc-u2-unit" class="sr-only">Velocity 2 unit</label>
            <select id="calc-u2-unit" name="u2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Final velocity of body 1" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'm1' => 1, 'm1-unit' => 'kg', 'u1' => 4, 'u1-unit' => 'ms', 'm2' => 3, 'm2-unit' => 'kg', 'u2' => 0, 'u2-unit' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v2' => ['label' => 'Final velocity of body 2'],
            'p' => ['label' => 'Momentum before and after'],
            'ke' => ['label' => 'Kinetic energy before and after'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
