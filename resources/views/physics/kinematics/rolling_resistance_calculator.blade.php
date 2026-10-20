<x-calc.page
    title="Rolling Resistance Calculator - SolveKit"
    description="Free rolling resistance calculator: force and power lost to tyre rolling resistance from C_rr and mass."
    lede="Find rolling resistance and the power it costs."
    about="Tyres deform as they roll, which costs energy. The force is the rolling resistance coefficient times the normal force, and the power is that force times speed."
    :calc="['engine' => 'ph-mech', 'tool' => 'rolling_resistance', 'fields' => ['crr', 'm', 'angle', 'v', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'power', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the rolling resistance of a 1,500 kg car with C_rr = 0.01?', 'answer' => '147.1 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="crr" label="Rolling resistance coefficient C_rr" value="0.01" min="0" step="any" />
        <x-calc.field name="m" label="Mass" value="1500" min="0" placeholder="Mass">
            <label for="calc-m-unit" class="sr-only">Mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="angle" label="Slope" value="0" placeholder="Slope">
            <label for="calc-angle-unit" class="sr-only">Slope unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Speed (for power)" value="100" placeholder="Speed (for power)">
            <label for="calc-v-unit" class="sr-only">Speed (for power) unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Rolling resistance force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'crr' => 0.01, 'm' => 1500, 'm-unit' => 'kg', 'angle' => 0, 'angle-unit' => 'deg', 'v' => 100, 'v-unit' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'power' => ['label' => 'Power to overcome it'],
            'typical' => ['label' => 'Typical C_rr'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
