<x-calc.page
    title="Car Jump Distance Calculator - SolveKit"
    description="Free car jump distance calculator: how far a car flies off a ramp from its speed, the ramp angle and heights, with the trajectory."
    lede="Find how far a car jumps off a ramp."
    about="Once a car leaves a ramp it is a projectile: it keeps its horizontal speed while gravity pulls it down. The distance depends on the take-off speed and angle and on how much higher or lower the landing is. Air resistance and the car’s rotation are ignored, so treat the result as an ideal estimate, never as a stunt plan."
    :calc="['engine' => 'ph-mech', 'tool' => 'car_jump', 'fields' => ['v', 'angle', 'h', 'land', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'land' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far does a car at 80 km/h jump off a 15° ramp?', 'answer' => 'About 28.4778 m to level ground from a 1 m lip.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Speed at the ramp" value="80" placeholder="Speed at the ramp">
            <label for="calc-v-unit" class="sr-only">Speed at the ramp unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="angle" label="Ramp angle" value="15" placeholder="Ramp angle">
            <label for="calc-angle-unit" class="sr-only">Ramp angle unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Ramp lip height" value="1" placeholder="Ramp lip height">
            <label for="calc-h-unit" class="sr-only">Ramp lip height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="land" label="Landing height" value="0" placeholder="Landing height">
            <label for="calc-land-unit" class="sr-only">Landing height unit</label>
            <select id="calc-land-unit" name="land-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Jump distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'v' => 80, 'v-unit' => 'kmh', 'angle' => 15, 'angle-unit' => 'deg', 'h' => 1, 'h-unit' => 'm', 'land' => 0, 'land-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Trajectory" name="trajectory" />
        <x-calc.rows heading="Details" :rows="[
            'time' => ['label' => 'Air time'],
            'peak' => ['label' => 'Peak height'],
            'impact' => ['label' => 'Landing speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
