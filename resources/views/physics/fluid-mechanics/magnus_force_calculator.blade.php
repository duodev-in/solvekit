<x-calc.page
    title="Magnus Force Calculator - SolveKit"
    description="Free Magnus force calculator: sideways force on a spinning ball and its curve."
    lede="Find the Magnus force on a spinning ball."
    about="A spinning ball drags air around with it, pushing the wake sideways and the ball the other way. That curves pitches, free kicks and slices."
    :calc="['engine' => 'ph-fluid', 'tool' => 'magnus', 'fields' => ['r', 'v', 'spin', 'rho', 'm', 'out'], 'unitFields' => ['r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'spin' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['angular_speed', 'density', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What force acts on a baseball at 40 m/s and 2,000 rpm?', 'answer' => '0.845385 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r" label="Ball radius" value="3.66" placeholder="Ball radius">
            <label for="calc-r-unit" class="sr-only">Ball radius unit</label>
            <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Speed" value="40" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="spin" label="Spin" value="2000" placeholder="Spin">
            <label for="calc-spin-unit" class="sr-only">Spin unit</label>
            <select id="calc-spin-unit" name="spin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'rpm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rho" label="Air density" value="1.225" min="0" placeholder="Air density">
            <label for="calc-rho-unit" class="sr-only">Air density unit</label>
            <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m" label="Ball mass (optional)" value="145" min="0" placeholder="Ball mass (optional)">
            <label for="calc-m-unit" class="sr-only">Ball mass (optional) unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Magnus force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'r' => 3.66, 'r-unit' => 'cm', 'v' => 40, 'v-unit' => 'ms', 'spin' => 2000, 'spin-unit' => 'rpm', 'rho' => 1.225, 'rho-unit' => 'kgm3', 'm' => 145, 'm-unit' => 'g'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'S' => ['label' => 'Spin parameter rω/v'],
            'CL' => ['label' => 'Lift coefficient used'],
            'a' => ['label' => 'Sideways acceleration'],
            'defl' => ['label' => 'Deflection over 18 m (pitching distance)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
