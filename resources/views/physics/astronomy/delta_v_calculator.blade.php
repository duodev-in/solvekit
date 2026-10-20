<x-calc.page
    title="Delta V Calculator - SolveKit"
    description="Free delta-v calculator: a rocket’s velocity change from specific impulse or exhaust velocity and its wet and dry mass."
    lede="Find a rocket stage’s delta-v."
    about="Delta-v is the total change in velocity a rocket can make, set by its exhaust velocity and how much of its mass is propellant. Reaching low Earth orbit takes about 9.4 km/s including losses."
    :calc="['engine' => 'ph-astro', 'tool' => 'delta_v', 'fields' => ['mode', 'isp', 've', 'm0', 'mf', 'out'], 'unitFields' => ['ve' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'm0' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'mf' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What delta-v does a 549 t stage with 140 t dry mass and Isp 311 s give?', 'answer' => '4.16751 km/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Engine given as" :options="['isp' => 'Specific impulse', 've' => 'Exhaust velocity']" selected="isp" />
        <div data-show-when="mode:isp">
            <x-calc.field name="isp" label="Specific impulse (s)" value="311" min="0" step="any" />
        </div>
        <div data-show-when="mode:ve">
            <x-calc.field name="ve" label="Exhaust velocity" value="3.05" placeholder="Exhaust velocity">
                <label for="calc-ve-unit" class="sr-only">Exhaust velocity unit</label>
                <select id="calc-ve-unit" name="ve-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="m0" label="Wet mass (start)" value="549" min="0" placeholder="Wet mass (start)">
            <label for="calc-m0-unit" class="sr-only">Wet mass (start) unit</label>
            <select id="calc-m0-unit" name="m0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mf" label="Dry mass (end)" value="140" min="0" placeholder="Dry mass (end)">
            <label for="calc-mf-unit" class="sr-only">Dry mass (end) unit</label>
            <select id="calc-mf-unit" name="mf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
    </div>

    <x-calc.result label="Delta-v" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kms', 'mode' => 'isp', 'isp' => 311, 've' => 3.05, 've-unit' => 'kms', 'm0' => 549, 'm0-unit' => 't', 'mf' => 140, 'mf-unit' => 't'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Mass ratio m₀/m_f'],
            'prop' => ['label' => 'Propellant used'],
            'fraction' => ['label' => 'Propellant fraction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
