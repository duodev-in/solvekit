<x-calc.page
    title="Cycling Wattage Calculator - SolveKit"
    description="Free cycling power calculator: watts needed for a speed, gradient, position and wind."
    lede="Find cycling power."
    about="Riding power goes to rolling resistance, air drag and climbing. Air drag grows with the cube of speed, which is why position matters so much."
    :calc="['engine' => 'sp-cycle', 'tool' => 'cycling_wattage', 'fields' => ['rider', 'bike', 'v', 'grade', 'pos', 'tyre', 'wind', 'rho', 'out'], 'unitFields' => ['rider' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'bike' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'wind' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'length', 'mass', 'power', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What power holds 30 km/h on the flat?', 'answer' => '144.497 W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rider" label="Rider weight" value="75" min="0" placeholder="Rider weight">
            <label for="calc-rider-unit" class="sr-only">Rider weight unit</label>
            <select id="calc-rider-unit" name="rider-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bike" label="Bike and kit weight" value="9" min="0" placeholder="Bike and kit weight">
            <label for="calc-bike-unit" class="sr-only">Bike and kit weight unit</label>
            <select id="calc-bike-unit" name="bike-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Speed" value="30" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="grade" label="Gradient (%)" value="0" min="0" step="any" />
        <x-calc.select name="pos" label="Position" :options="['tops' => 'Upright, hands on the tops (CdA ≈ 0.40)', 'hoods' => 'On the hoods (CdA ≈ 0.32)', 'drops' => 'In the drops (CdA ≈ 0.30)', 'aero' => 'Aero or time-trial position (CdA ≈ 0.23)', 'mtb' => 'Mountain bike, upright (CdA ≈ 0.45)']" selected="hoods" />
        <x-calc.select name="tyre" label="Surface and tyres" :options="['road' => 'Road tyres on smooth tarmac (Crr 0.004)', 'rough' => 'Road tyres on rough tarmac (Crr 0.006)', 'gravel' => 'Gravel (Crr 0.008)', 'mtb' => 'Knobby MTB tyres (Crr 0.012)']" selected="road" />
        <x-calc.field name="wind" label="Headwind (negative for tailwind)" value="0" placeholder="Headwind (negative for tailwind)">
            <label for="calc-wind-unit" class="sr-only">Headwind (negative for tailwind) unit</label>
            <select id="calc-wind-unit" name="wind-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
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
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="w" />
    </div>

    <x-calc.result label="Power needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'w', 'rider' => 75, 'rider-unit' => 'kg', 'bike' => 9, 'bike-unit' => 'kg', 'v' => 30, 'v-unit' => 'kmh', 'grade' => 0, 'pos' => 'hoods', 'tyre' => 'road', 'wind' => 0, 'wind-unit' => 'kmh', 'rho' => 1.225, 'rho-unit' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'wkg' => ['label' => 'Watts per kg (rider)'],
            'air' => ['label' => 'Aerodynamic drag'],
            'roll' => ['label' => 'Rolling resistance'],
            'climb' => ['label' => 'Climbing'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
