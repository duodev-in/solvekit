<x-calc.page
    title="E-Bike Range Calculator - SolveKit"
    description="Free e-bike range calculator: estimated range from battery, assist level, weight, speed and terrain."
    lede="Estimate e-bike range."
    about="Range is the battery energy divided by the energy used per kilometre, which depends on assist level, speed, weight and hills."
    :calc="['engine' => 'sp-cycle', 'tool' => 'ebike_range', 'fields' => ['wh', 'assist', 'rider', 'bike', 'v', 'grade', 'price', 'out'], 'unitFields' => ['rider' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'bike' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far does a 500 Wh battery go in Tour mode?', 'answer' => 'About 83.9419 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wh" label="Battery capacity (Wh)" value="500" min="1" step="any" />
        <x-calc.select name="assist" label="Assist level" :options="['2' => 'Sport (about 200%)', '3' => 'Turbo (about 300%)', '0.5' => 'Eco (motor adds about 50%)', '1.2' => 'Tour (about 120%)']" selected="1.2" />
        <x-calc.field name="rider" label="Rider weight" value="80" min="0" placeholder="Rider weight">
            <label for="calc-rider-unit" class="sr-only">Rider weight unit</label>
            <select id="calc-rider-unit" name="rider-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bike" label="E-bike weight" value="23" min="0" placeholder="E-bike weight">
            <label for="calc-bike-unit" class="sr-only">E-bike weight unit</label>
            <select id="calc-bike-unit" name="bike-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Average speed" value="22" placeholder="Average speed">
            <label for="calc-v-unit" class="sr-only">Average speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="grade" label="Average gradient (%)" value="1" min="0" step="any" />
        <x-calc.field name="price" label="Electricity price per kWh (optional)" value="0.2" min="0" step="any" suffix="$" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="km" />
    </div>

    <x-calc.result label="Estimated range" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'km', 'wh' => 500, 'assist' => '1.2', 'rider' => 80, 'rider-unit' => 'kg', 'bike' => 23, 'bike-unit' => 'kg', 'v' => 22, 'v-unit' => 'kmh', 'grade' => 1, 'price' => 0.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'whkm' => ['label' => 'Battery use'],
            'rider' => ['label' => 'Your pedalling power'],
            'cost' => ['label' => 'Cost of a full charge'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
