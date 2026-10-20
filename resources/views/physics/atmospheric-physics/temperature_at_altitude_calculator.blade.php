<x-calc.page
    title="Temperature at Altitude Calculator - SolveKit"
    description="Free temperature at altitude calculator: air temperature with height from the standard lapse rate."
    lede="Find temperature at altitude."
    about="In the lower atmosphere air cools by about 6.5 °C per kilometre on average."
    :calc="['engine' => 'ph-thermo', 'tool' => 'temperature_altitude', 'fields' => ['z', 'T0', 'h0', 'out'], 'unitFields' => ['z' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'T0' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'h0' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the standard temperature at 3,000 m?', 'answer' => '5.5 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="z" label="Altitude" value="3000" placeholder="Altitude">
            <label for="calc-z-unit" class="sr-only">Altitude unit</label>
            <select id="calc-z-unit" name="z-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T0" label="Ground temperature (optional)" value="25" placeholder="Ground temperature (optional)">
            <label for="calc-T0-unit" class="sr-only">Ground temperature (optional) unit</label>
            <select id="calc-T0-unit" name="T0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h0" label="Ground elevation" value="0" placeholder="Ground elevation">
            <label for="calc-h0-unit" class="sr-only">Ground elevation unit</label>
            <select id="calc-h0-unit" name="h0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Temperature at that altitude" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'z' => 3000, 'z-unit' => 'm', 'T0' => 25, 'T0-unit' => 'c', 'h0' => 0, 'h0-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'isa' => ['label' => 'Standard atmosphere temperature'],
            'lapse' => ['label' => 'Lapse rate used'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
