<x-calc.page
    title="Horizontal Projectile Motion Calculator - SolveKit"
    description="Free horizontal projectile calculator: range, fall time and impact speed for something launched horizontally from a height."
    lede="Find where a horizontally launched object lands."
    about="An object thrown or rolled horizontally off a height falls exactly as if dropped, while moving sideways at its launch speed. So the fall time depends only on the height, t = √(2h/g), and the range is the launch speed times that time."
    :calc="['engine' => 'ph-mech', 'tool' => 'projectile_horizontal', 'fields' => ['v', 'h', 'g', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far does a ball rolled off a 10 m ledge at 20 m/s land?', 'answer' => '28.5617 m away.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Launch speed" value="20" placeholder="Launch speed">
            <label for="calc-v-unit" class="sr-only">Launch speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Launch height" value="10" placeholder="Launch height">
            <label for="calc-h-unit" class="sr-only">Launch height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="g" label="Gravity" value="9.80665" placeholder="Gravity">
            <label for="calc-g-unit" class="sr-only">Gravity unit</label>
            <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Range" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'v' => 20, 'v-unit' => 'ms', 'h' => 10, 'h-unit' => 'm', 'g' => 9.80665, 'g-unit' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Trajectory" name="trajectory" />
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Range'],
            'time' => ['label' => 'Time of flight'],
            'height' => ['label' => 'Maximum height'],
            'impact' => ['label' => 'Impact speed'],
            'impactAngle' => ['label' => 'Impact angle below horizontal'],
            'best' => ['label' => 'Angle for the longest range from this height'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
