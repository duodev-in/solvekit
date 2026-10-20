<x-calc.page
    title="Watt-hour Calculator - SolveKit"
    description="Free watt-hour calculator: energy in Wh from power and time, or from battery mAh and voltage."
    lede="Find watt-hours."
    about="Watt-hours are power times hours. A 5,000 mAh, 3.7 V battery holds 18.5 Wh."
    :calc="['engine' => 'ph-em', 'tool' => 'watt_hour', 'fields' => ['mode', 'P', 't', 'mah', 'V', 'out'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed', 'time', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many Wh in a 5,000 mAh 3.7 V battery?', 'answer' => '18.5 Wh.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['pt' => 'Power and time', 'mah' => 'Battery capacity and voltage']" selected="pt" />
        <div data-show-when="mode:pt">
            <x-calc.field name="P" label="Power" value="60" min="0" placeholder="Power">
                <label for="calc-P-unit" class="sr-only">Power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:pt">
            <x-calc.field name="t" label="Time" value="5" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'h')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:mah">
            <x-calc.field name="mah" label="Capacity (mAh)" value="5000" min="0" step="any" />
        </div>
        <div data-show-when="mode:mah">
            <x-calc.field name="V" label="Voltage" value="3.7" placeholder="Voltage">
                <label for="calc-V-unit" class="sr-only">Voltage unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="wh" />
    </div>

    <x-calc.result label="Energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'wh', 'mode' => 'pt', 'P' => 60, 'P-unit' => 'w', 't' => 5, 't-unit' => 'h', 'mah' => 5000, 'V' => 3.7, 'V-unit' => 'v'],
        'mAh' => ['out' => 'wh', 'mode' => 'mah', 'P' => 60, 'P-unit' => 'w', 't' => 5, 't-unit' => 'h', 'mah' => 5000, 'V' => 3.7, 'V-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kwh' => ['label' => 'In kWh'],
            'J' => ['label' => 'In joules'],
            'flight' => ['label' => 'Airline cabin limit (100 Wh)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
