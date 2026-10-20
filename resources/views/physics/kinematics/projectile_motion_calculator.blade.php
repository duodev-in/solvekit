<x-calc.page
    title="Projectile Motion Calculator - SolveKit"
    description="Free projectile motion calculator: range, time of flight, maximum height and impact speed, with the trajectory."
    lede="Find where a projectile lands."
    about="Without air resistance a projectile moves at constant horizontal speed while gravity slows and reverses its vertical speed, so its path is a parabola. From level ground the range is longest at 45°; from a height a slightly flatter angle goes further."
    :calc="['engine' => 'ph-mech', 'tool' => 'projectile', 'fields' => ['v', 'angle', 'h', 'g', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'angle', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far does a ball thrown at 20 m/s and 45° travel?', 'answer' => '40.7886 m.'],
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
        <x-calc.field name="angle" label="Launch angle" value="45" placeholder="Launch angle">
            <label for="calc-angle-unit" class="sr-only">Launch angle unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Launch height" value="0" placeholder="Launch height">
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
        'Example' => ['out' => 'm', 'v' => 20, 'v-unit' => 'ms', 'angle' => 45, 'angle-unit' => 'deg', 'h' => 0, 'h-unit' => 'm', 'g' => 9.80665, 'g-unit' => 'ms2'],
        'From a cliff' => ['out' => 'm', 'v' => 20, 'v-unit' => 'ms', 'angle' => 20, 'angle-unit' => 'deg', 'h' => 30, 'h-unit' => 'm', 'g' => 9.80665, 'g-unit' => 'ms2'],
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
