<x-calc.page
    title="Lux to Foot Candles Converter - SolveKit"
    description="Free lux to foot-candles converter: convert illuminance between lux, foot-candles, phot and kilolux."
    lede="Convert lux and foot-candles."
    about="Lux is lumens per square metre; a foot-candle is lumens per square foot, so 1 fc = 10.7639 lx."
    :calc="['engine' => 'ph-wave', 'tool' => 'lux_fc', 'fields' => ['E', 'out'], 'unitFields' => ['E' => collect(config('units.illuminance'))->only(['lx', 'fc', 'phot', 'klx'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'illuminance', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many foot-candles is 500 lux?', 'answer' => '46.4515 fc.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="E" label="Illuminance" value="500" min="0" placeholder="Illuminance">
            <label for="calc-E-unit" class="sr-only">Illuminance unit</label>
            <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.illuminance'))->only(['lx', 'fc', 'phot', 'klx']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lx')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['lx' => 'lx', 'fc' => 'fc', 'phot' => 'ph', 'klx' => 'klx']" selected="fc" />
    </div>

    <x-calc.result label="Converted illuminance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'fc', 'E' => 500, 'E-unit' => 'lx'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lx' => ['label' => 'In lux'],
            'typical' => ['label' => 'Typical levels'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
