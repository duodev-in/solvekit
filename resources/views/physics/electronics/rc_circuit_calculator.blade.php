<x-calc.page
    title="RC Circuit Calculator - SolveKit"
    description="Free RC circuit calculator: time constant and capacitor voltage while charging or discharging, with the curve."
    lede="Analyse an RC circuit."
    about="An RC circuit charges and discharges exponentially with time constant τ = RC."
    :calc="['engine' => 'ph-elec', 'tool' => 'rc_circuit', 'fields' => ['R', 'X', 'V', 'mode', 't', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'X' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 't' => collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'length', 'mass', 'resistance', 'short_time', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the voltage after 1 s with 10 kΩ, 100 µF and 12 V?', 'answer' => '7.58545 V.'],
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
        <x-calc.field name="X" label="Capacitance" value="100" min="0" placeholder="Capacitance">
            <label for="calc-X-unit" class="sr-only">Capacitance unit</label>
            <select id="calc-X-unit" name="X-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V" label="Source voltage" value="12" placeholder="Source voltage">
            <label for="calc-V-unit" class="sr-only">Source voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mode" label="Response" :options="['charge' => 'Charging', 'discharge' => 'Discharging']" selected="charge" />
        <x-calc.field name="t" label="At time" value="1" min="0" placeholder="At time">
            <label for="calc-t-unit" class="sr-only">At time unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
    </div>

    <x-calc.result label="Capacitor voltage at that time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'v', 'R' => 10, 'R-unit' => 'kohm', 'X' => 100, 'X-unit' => 'uf', 'V' => 12, 'V-unit' => 'v', 'mode' => 'charge', 't' => 1, 't-unit' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Response over 5 time constants" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'tau' => ['label' => 'Time constant τ'],
            'five' => ['label' => '99.3% reached after 5τ'],
            'fc' => ['label' => 'Cutoff frequency'],
            'energy' => ['label' => 'Energy stored when full'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
