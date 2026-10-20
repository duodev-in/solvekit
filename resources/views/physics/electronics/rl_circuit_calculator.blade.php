<x-calc.page
    title="RL Circuit Calculator - SolveKit"
    description="Free RL circuit calculator: time constant and current while switching on or off, with the curve."
    lede="Analyse an RL circuit."
    about="Current in an inductor cannot change instantly: it rises or falls exponentially with time constant L/R."
    :calc="['engine' => 'ph-elec', 'tool' => 'rl_circuit', 'fields' => ['R', 'X', 'V', 'mode', 't', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'X' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 't' => collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'inductance', 'length', 'mass', 'resistance', 'short_time', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the current 1 s after switching on in the example?', 'answer' => '120 mA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Resistance" value="100" min="0" placeholder="Resistance">
            <label for="calc-R-unit" class="sr-only">Resistance unit</label>
            <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="X" label="Inductance" value="500" min="0" placeholder="Inductance">
            <label for="calc-X-unit" class="sr-only">Inductance unit</label>
            <select id="calc-X-unit" name="X-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
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
        <x-calc.select name="mode" label="Response" :options="['charge' => 'Switch on (current rises)', 'discharge' => 'Switch off (current decays)']" selected="charge" />
        <x-calc.field name="t" label="At time" value="1" min="0" placeholder="At time">
            <label for="calc-t-unit" class="sr-only">At time unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="ma" />
    </div>

    <x-calc.result label="Current at that time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ma', 'R' => 100, 'R-unit' => 'ohm', 'X' => 500, 'X-unit' => 'mh', 'V' => 12, 'V-unit' => 'v', 'mode' => 'charge', 't' => 1, 't-unit' => 's'],
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
