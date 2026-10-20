<x-calc.page
    title="Capacitor Charge Time Calculator - SolveKit"
    description="Free capacitor charge time calculator: time for an RC circuit to reach a target voltage, with the charging curve."
    lede="Find RC charge time."
    about="A capacitor charging through a resistor approaches the supply exponentially with time constant RC. It reaches 63% after one RC and 99% after five."
    :calc="['engine' => 'ph-elec', 'tool' => 'cap_charge_time', 'fields' => ['R', 'C', 'Vs', 'V0', 'Vt', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all(), 'Vs' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'V0' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vt' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'length', 'mass', 'resistance', 'short_time', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long to reach 9 V from 12 V through 10 kΩ and 100 µF?', 'answer' => '1.38629 s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Resistance" value="10" min="0" placeholder="Resistance">
            <label for="calc-R-unit" class="sr-only">Resistance unit</label>
            <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="C" label="Capacitance" value="100" min="0" placeholder="Capacitance">
            <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
            <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vs" label="Supply voltage" value="12" placeholder="Supply voltage">
            <label for="calc-Vs-unit" class="sr-only">Supply voltage unit</label>
            <select id="calc-Vs-unit" name="Vs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V0" label="Starting voltage" value="0" placeholder="Starting voltage">
            <label for="calc-V0-unit" class="sr-only">Starting voltage unit</label>
            <select id="calc-V0-unit" name="V0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vt" label="Target voltage" value="9" placeholder="Target voltage">
            <label for="calc-Vt-unit" class="sr-only">Target voltage unit</label>
            <select id="calc-Vt-unit" name="Vt-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'ns' => 'ns', 'ps' => 'ps', 'min' => 'min', 'h' => 'h']" selected="s" />
    </div>

    <x-calc.result label="Time to reach the target" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 's', 'R' => 10, 'R-unit' => 'kohm', 'C' => 100, 'C-unit' => 'uf', 'Vs' => 12, 'Vs-unit' => 'v', 'V0' => 0, 'V0-unit' => 'v', 'Vt' => 9, 'Vt-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Charging curve" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'tau' => ['label' => 'Time constant RC'],
            'share' => ['label' => 'Share of the way'],
            'five' => ['label' => 'Practically full (5RC)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
