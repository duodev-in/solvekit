<x-calc.page
    title="Transistor Biasing Calculator - SolveKit"
    description="Free transistor biasing calculator: BJT operating point for voltage-divider and fixed bias."
    lede="Find a BJT’s operating point."
    about="Biasing sets a transistor’s quiescent current and voltage. Voltage-divider bias with an emitter resistor keeps the operating point steady as β varies."
    :calc="['engine' => 'ph-elec', 'tool' => 'transistor_bias', 'fields' => ['type', 'Vcc', 'R1', 'R2', 'Rb', 'Rc', 'Re', 'beta', 'Vbe', 'out'], 'unitFields' => ['Vcc' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'R1' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'R2' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Rb' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Rc' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Re' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Vbe' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'resistance', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is I_C in the example divider-biased stage?', 'answer' => '2.66096 mA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Bias" :options="['divider' => 'Voltage divider', 'fixed' => 'Fixed base resistor']" selected="divider" />
        <x-calc.field name="Vcc" label="Supply V_CC" value="12" placeholder="Supply V_CC">
            <label for="calc-Vcc-unit" class="sr-only">Supply V_CC unit</label>
            <select id="calc-Vcc-unit" name="Vcc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="type:divider">
            <x-calc.field name="R1" label="R1 (top of divider)" value="47" min="0" placeholder="R1 (top of divider)">
                <label for="calc-R1-unit" class="sr-only">R1 (top of divider) unit</label>
                <select id="calc-R1-unit" name="R1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="type:divider">
            <x-calc.field name="R2" label="R2 (bottom of divider)" value="10" min="0" placeholder="R2 (bottom of divider)">
                <label for="calc-R2-unit" class="sr-only">R2 (bottom of divider) unit</label>
                <select id="calc-R2-unit" name="R2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="type:fixed">
            <x-calc.field name="Rb" label="Base resistor R_B" value="470" min="0" placeholder="Base resistor R_B">
                <label for="calc-Rb-unit" class="sr-only">Base resistor R_B unit</label>
                <select id="calc-Rb-unit" name="Rb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="Rc" label="Collector resistor R_C" value="2.2" min="0" placeholder="Collector resistor R_C">
            <label for="calc-Rc-unit" class="sr-only">Collector resistor R_C unit</label>
            <select id="calc-Rc-unit" name="Rc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Re" label="Emitter resistor R_E" value="470" min="0" placeholder="Emitter resistor R_E">
            <label for="calc-Re-unit" class="sr-only">Emitter resistor R_E unit</label>
            <select id="calc-Re-unit" name="Re-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="beta" label="Current gain β" value="150" min="1" step="any" />
        <x-calc.field name="Vbe" label="V_BE" value="0.7" placeholder="V_BE">
            <label for="calc-Vbe-unit" class="sr-only">V_BE unit</label>
            <select id="calc-Vbe-unit" name="Vbe-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="ma" />
    </div>

    <x-calc.result label="Collector current I_C" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ma', 'type' => 'divider', 'Vcc' => 12, 'Vcc-unit' => 'v', 'R1' => 47, 'R1-unit' => 'kohm', 'R2' => 10, 'R2-unit' => 'kohm', 'Rb' => 470, 'Rb-unit' => 'kohm', 'Rc' => 2.2, 'Rc-unit' => 'kohm', 'Re' => 470, 'Re-unit' => 'ohm', 'beta' => 150, 'Vbe' => 0.7, 'Vbe-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Vce' => ['label' => 'V_CE'],
            'Ib' => ['label' => 'Base current'],
            'Ve' => ['label' => 'Emitter voltage'],
            'region' => ['label' => 'Operating region'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
