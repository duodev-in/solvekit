<x-calc.page
    title="Op-Amp Gain Calculator - SolveKit"
    description="Free op-amp gain calculator: gain and output voltage of inverting, non-inverting, difference and summing amplifiers."
    lede="Find op-amp gain."
    about="With negative feedback an ideal op-amp’s gain depends only on its resistors. The output cannot go beyond the supply rails."
    :calc="['engine' => 'ph-elec', 'tool' => 'opamp', 'fields' => ['config', 'Rf', 'Rin', 'Vin', 'V2', 'inputs', 'rail', 'out'], 'unitFields' => ['Rf' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Rin' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Vin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'V2' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'rail' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'resistance', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a non-inverting stage with 10k/1k do to 0.1 V?', 'answer' => 'It gives 1.1 V.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="config" label="Configuration" :options="['inverting' => 'Inverting', 'noninverting' => 'Non-inverting', 'difference' => 'Difference (matched resistors)', 'summing' => 'Inverting summer']" selected="noninverting" />
        <x-calc.field name="Rf" label="Feedback resistor R_f" value="10" min="0" placeholder="Feedback resistor R_f">
            <label for="calc-Rf-unit" class="sr-only">Feedback resistor R_f unit</label>
            <select id="calc-Rf-unit" name="Rf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="config:inverting,noninverting,difference">
            <x-calc.field name="Rin" label="Input (or ground) resistor" value="1" min="0" placeholder="Input (or ground) resistor">
                <label for="calc-Rin-unit" class="sr-only">Input (or ground) resistor unit</label>
                <select id="calc-Rin-unit" name="Rin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="config:inverting,noninverting,difference">
            <x-calc.field name="Vin" label="Input voltage" value="0.1" placeholder="Input voltage">
                <label for="calc-Vin-unit" class="sr-only">Input voltage unit</label>
                <select id="calc-Vin-unit" name="Vin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="config:difference">
            <x-calc.field name="V2" label="Second input V₂ (difference)" value="0.2" placeholder="Second input V₂ (difference)">
                <label for="calc-V2-unit" class="sr-only">Second input V₂ (difference) unit</label>
                <select id="calc-V2-unit" name="V2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="config:summing">
            <x-calc.textarea name="inputs" label="Summer inputs: voltage, resistor in kΩ (one per line)" value="1, 10
0.5, 20" rows="3" />
        </div>
        <x-calc.field name="rail" label="Supply rail (±)" value="12" placeholder="Supply rail (±)">
            <label for="calc-rail-unit" class="sr-only">Supply rail (±) unit</label>
            <select id="calc-rail-unit" name="rail-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
    </div>

    <x-calc.result label="Output voltage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'v', 'config' => 'noninverting', 'Rf' => 10, 'Rf-unit' => 'kohm', 'Rin' => 1, 'Rin-unit' => 'kohm', 'Vin' => 0.1, 'Vin-unit' => 'v', 'V2' => 0.2, 'V2-unit' => 'v', 'inputs' => '1, 10
0.5, 20', 'rail' => 12, 'rail-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gain' => ['label' => 'Gain'],
            'db' => ['label' => 'Gain in dB'],
            'clip' => ['label' => 'Clipping'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
