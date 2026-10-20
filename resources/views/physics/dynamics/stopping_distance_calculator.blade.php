<x-calc.page
    title="Stopping Distance Calculator - SolveKit"
    description="Free stopping distance calculator: reaction and braking distance from speed, reaction time, road surface and slope."
    lede="Find how far a car needs to stop."
    about="Stopping distance is reaction distance (speed × reaction time) plus braking distance (v² ÷ 2μg). Doubling the speed roughly quadruples the braking part. The friction values are typical, so allow a margin."
    :calc="['engine' => 'ph-mech', 'tool' => 'stopping_distance', 'fields' => ['v', 'tr', 'road', 'grade', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'tr' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far does a car need to stop from 100 km/h on a dry road?', 'answer' => 'About 97.868 m; 41.6667 m thinking + 56.2013 m braking.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Speed" value="100" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="tr" label="Reaction time" value="1.5" placeholder="Reaction time">
            <label for="calc-tr-unit" class="sr-only">Reaction time unit</label>
            <select id="calc-tr-unit" name="tr-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="road" label="Road surface" :options="['dry' => 'Dry asphalt (μ ≈ 0.7)', 'wet' => 'Wet asphalt (μ ≈ 0.4)', 'gravel' => 'Gravel (μ ≈ 0.35)', 'snow' => 'Packed snow (μ ≈ 0.2)', 'ice' => 'Ice (μ ≈ 0.1)']" selected="dry" />
        <x-calc.field name="grade" label="Downhill slope (%)" value="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Stopping distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'v' => 100, 'v-unit' => 'kmh', 'tr' => 1.5, 'tr-unit' => 's', 'road' => 'dry', 'grade' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'react' => ['label' => 'Reaction distance'],
            'brake' => ['label' => 'Braking distance'],
            'time' => ['label' => 'Total time to stop'],
            'decel' => ['label' => 'Braking deceleration'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
