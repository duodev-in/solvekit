<x-calc.page
    title="dB Gain Calculator - SolveKit"
    description="Free dB gain calculator: amplifier or attenuator gain in decibels from input and output voltage or power."
    lede="Find gain in dB."
    about="Gain in decibels is 20 log₁₀(V_out/V_in) for voltages and 10 log₁₀(P_out/P_in) for powers. Negative values are losses."
    :calc="['engine' => 'ph-wave', 'tool' => 'db_gain', 'fields' => ['kind', 'vin', 'vout', 'pin', 'pout'], 'unitFields' => ['vin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'vout' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'pin' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'pout' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the gain from 100 mV to 2 V?', 'answer' => '26.021 dB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Measure" :options="['v' => 'Voltages', 'p' => 'Powers']" selected="v" />
        <div data-show-when="kind:v">
            <x-calc.field name="vin" label="Input voltage" value="100" placeholder="Input voltage">
                <label for="calc-vin-unit" class="sr-only">Input voltage unit</label>
                <select id="calc-vin-unit" name="vin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mv')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:v">
            <x-calc.field name="vout" label="Output voltage" value="2" placeholder="Output voltage">
                <label for="calc-vout-unit" class="sr-only">Output voltage unit</label>
                <select id="calc-vout-unit" name="vout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:p">
            <x-calc.field name="pin" label="Input power" value="1" min="0" placeholder="Input power">
                <label for="calc-pin-unit" class="sr-only">Input power unit</label>
                <select id="calc-pin-unit" name="pin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'milliwatt')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:p">
            <x-calc.field name="pout" label="Output power" value="1" min="0" placeholder="Output power">
                <label for="calc-pout-unit" class="sr-only">Output power unit</label>
                <select id="calc-pout-unit" name="pout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Gain" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'v', 'vin' => 100, 'vin-unit' => 'mv', 'vout' => 2, 'vout-unit' => 'v', 'pin' => 1, 'pin-unit' => 'milliwatt', 'pout' => 1, 'pout-unit' => 'w'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Gain as a ratio'],
            'type' => ['label' => 'Type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
