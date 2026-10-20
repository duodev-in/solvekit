<x-calc.page
    title="Scuba Air Consumption Calculator - SolveKit"
    description="Free scuba air consumption calculator: SAC and RMV from pressure used, cylinder size, time and depth."
    lede="Find your air consumption."
    about="Gas use grows with depth because each breath is denser. Correcting to the surface gives a rate you can compare between dives."
    :calc="['engine' => 'sp-misc', 'tool' => 'sac', 'fields' => ['used', 'V', 't', 'depth', 'water'], 'unitFields' => ['used' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'depth' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'pressure', 'speed', 'time', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What RMV does the example dive give?', 'answer' => '16 L/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="used" label="Pressure used" value="100" min="0" placeholder="Pressure used">
            <label for="calc-used-unit" class="sr-only">Pressure used unit</label>
            <select id="calc-used-unit" name="used-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'bar')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V" label="Cylinder size (water volume)" value="12" min="0" placeholder="Cylinder size (water volume)">
            <label for="calc-V-unit" class="sr-only">Cylinder size (water volume) unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Time at depth" value="30" placeholder="Time at depth">
            <label for="calc-t-unit" class="sr-only">Time at depth unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Average depth" value="15" placeholder="Average depth">
            <label for="calc-depth-unit" class="sr-only">Average depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="water" label="Water" :options="['salt' => 'Salt water', 'fresh' => 'Fresh water']" selected="salt" />
    </div>

    <x-calc.result label="RMV (surface air consumption)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['used' => 100, 'used-unit' => 'bar', 'V' => 12, 'V-unit' => 'l', 't' => 30, 't-unit' => 'min', 'depth' => 15, 'depth-unit' => 'm', 'water' => 'salt'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sac' => ['label' => 'SAC rate (pressure per minute at the surface)'],
            'ata' => ['label' => 'Pressure at that depth'],
            'note' => ['label' => 'Important'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
