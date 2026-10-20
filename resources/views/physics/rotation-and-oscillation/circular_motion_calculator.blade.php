<x-calc.page
    title="Circular Motion Calculator - SolveKit"
    description="Free circular motion calculator: speed, angular velocity, period, frequency and centripetal acceleration."
    lede="Find every circular-motion quantity."
    about="Uniform circular motion links v = ωr, T = 2π/ω and a = v²/r. Enter the radius and one rate to get the rest."
    :calc="['engine' => 'ph-mech', 'tool' => 'circular', 'fields' => ['r', 'known', 'v', 'T', 'n', 'out'], 'unitFields' => ['r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'T' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'n' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'angular_speed', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the speed at 2 m radius and 30 rpm?', 'answer' => '6.28319 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r" label="Radius" value="2" placeholder="Radius">
            <label for="calc-r-unit" class="sr-only">Radius unit</label>
            <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="known" label="I know" :options="['v' => 'The speed', 'T' => 'The period', 'n' => 'The rotation rate']" selected="n" />
        <div data-show-when="known:v">
            <x-calc.field name="v" label="Speed" value="5" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:T">
            <x-calc.field name="T" label="Period" value="2" placeholder="Period">
                <label for="calc-T-unit" class="sr-only">Period unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:n">
            <x-calc.field name="n" label="Rotation rate" value="30" placeholder="Rotation rate">
                <label for="calc-n-unit" class="sr-only">Rotation rate unit</label>
                <select id="calc-n-unit" name="n-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rpm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'r' => 2, 'r-unit' => 'm', 'known' => 'n', 'v' => 5, 'v-unit' => 'ms', 'T' => 2, 'T-unit' => 's', 'n' => 30, 'n-unit' => 'rpm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'w' => ['label' => 'Angular velocity'],
            'T' => ['label' => 'Period'],
            'f' => ['label' => 'Frequency'],
            'a' => ['label' => 'Centripetal acceleration'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
