<x-calc.page
    title="Free Fall Calculator - SolveKit"
    description="Free free fall calculator: fall time, impact speed and height for an object dropped without air resistance."
    lede="Find how long a fall takes and how fast it ends."
    about="In free fall the only force is gravity, so the speed grows by g every second: v = gt and h = ½gt². That is accurate for dense objects over short drops; for long falls air resistance matters (use the free fall with air resistance calculator)."
    :calc="['engine' => 'ph-mech', 'tool' => 'free_fall', 'fields' => ['known', 'h', 't', 'v', 'g', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 20 m fall take?', 'answer' => '2.01962 s, ending at Hits at 19.8057 m/s (71.3005 km/h), no air resistance.'],
        ['question' => 'Does a heavier object fall faster?', 'answer' => 'Not without air: every object falls with the same acceleration g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="known" label="I know" :options="['h' => 'The height', 't' => 'The fall time', 'v' => 'The impact speed']" selected="h" />
        <div data-show-when="known:h">
            <x-calc.field name="h" label="Height" value="20" placeholder="Height">
                <label for="calc-h-unit" class="sr-only">Height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:t">
            <x-calc.field name="t" label="Fall time" value="2" placeholder="Fall time">
                <label for="calc-t-unit" class="sr-only">Fall time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:v">
            <x-calc.field name="v" label="Impact speed" value="20" placeholder="Impact speed">
                <label for="calc-v-unit" class="sr-only">Impact speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="g" label="Gravity" value="9.80665" placeholder="Gravity">
            <label for="calc-g-unit" class="sr-only">Gravity unit</label>
            <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
    </div>

    <x-calc.result label="Fall time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 's', 'known' => 'h', 'h' => 20, 'h-unit' => 'm', 't' => 2, 't-unit' => 's', 'v' => 20, 'v-unit' => 'ms', 'g' => 9.80665, 'g-unit' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'h' => ['label' => 'Height'],
            't' => ['label' => 'Fall time'],
            'v' => ['label' => 'Impact speed'],
            'energy' => ['label' => 'Energy per kilogram'],
            'first' => ['label' => 'Distance fallen in each second'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
