<x-calc.page
    title="FTP Calculator - SolveKit"
    description="Free FTP calculator: functional threshold power from a 20-minute, ramp or 8-minute test."
    lede="Find your FTP."
    about="Functional threshold power is roughly the power you can hold for an hour. Shorter tests are scaled down: 95% of a 20-minute test or 75% of a ramp test’s best minute."
    :calc="['engine' => 'sp-cycle', 'tool' => 'ftp', 'fields' => ['test', 'P', 'w', 'out'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'power', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What FTP does a 250 W 20-minute test give?', 'answer' => '237.5 W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="test" label="Test" :options="['t20' => '20-minute test (average power)', 'ramp' => 'Ramp test (best 1-minute power)', 't8' => '8-minute test (average of two)', 't60' => 'One-hour best']" selected="t20" />
        <x-calc.field name="P" label="Test power" value="250" min="0" placeholder="Test power">
            <label for="calc-P-unit" class="sr-only">Test power unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w" label="Body weight" value="75" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="w" />
    </div>

    <x-calc.result label="Functional threshold power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'w', 'test' => 't20', 'P' => 250, 'P-unit' => 'w', 'w' => 75, 'w-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'wkg' => ['label' => 'Watts per kg'],
            'factor' => ['label' => 'Factor used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
