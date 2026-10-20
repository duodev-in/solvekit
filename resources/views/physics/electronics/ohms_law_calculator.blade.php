<x-calc.page
    title="Ohm's Law Calculator - SolveKit"
    description="Free Ohm's law calculator: voltage, current, resistance and power from any two values."
    lede="Solve V = IR."
    about="Ohm’s law says current through a resistor is proportional to the voltage across it: V = IR. Power follows from P = VI."
    :calc="['engine' => 'ph-elec', 'tool' => 'ohms_law', 'fields' => ['pair', 'V', 'I', 'R', 'P', 'out'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'resistance', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What current flows through 6 Ω at 12 V?', 'answer' => '2 A.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="pair" label="I know" :options="['VI' => 'Voltage and current', 'VR' => 'Voltage and resistance', 'IR' => 'Current and resistance', 'PV' => 'Power and voltage', 'PI' => 'Power and current', 'PR' => 'Power and resistance']" selected="VR" />
        <div data-show-when="pair:VI,VR,PV">
            <x-calc.field name="V" label="Voltage" value="12" placeholder="Voltage">
                <label for="calc-V-unit" class="sr-only">Voltage unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="pair:VI,IR,PI">
            <x-calc.field name="I" label="Current" value="2" placeholder="Current">
                <label for="calc-I-unit" class="sr-only">Current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="pair:VR,IR,PR">
            <x-calc.field name="R" label="Resistance" value="6" min="0" placeholder="Resistance">
                <label for="calc-R-unit" class="sr-only">Resistance unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="pair:PV,PI,PR">
            <x-calc.field name="P" label="Power" value="24" min="0" placeholder="Power">
                <label for="calc-P-unit" class="sr-only">Power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
    </div>

    <x-calc.result label="Current" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'a', 'pair' => 'VR', 'V' => 12, 'V-unit' => 'v', 'I' => 2, 'I-unit' => 'a', 'R' => 6, 'R-unit' => 'ohm', 'P' => 24, 'P-unit' => 'w'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'V' => ['label' => 'Voltage V'],
            'I' => ['label' => 'Current I'],
            'R' => ['label' => 'Resistance R'],
            'P' => ['label' => 'Power P'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
