<x-calc.page
    title="Battery Life Calculator - SolveKit"
    description="Free battery life calculator: runtime from capacity and load, with Peukert’s law for high currents."
    lede="Estimate battery runtime."
    about="Runtime is roughly capacity divided by current, but batteries deliver less at high current. Peukert’s law models this; lithium cells are close to ideal."
    :calc="['engine' => 'ph-elec', 'tool' => 'battery_life', 'fields' => ['cap', 'H', 'mode', 'I', 'P', 'V', 'k', 'usable', 'out'], 'unitFields' => ['I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'time', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long does 2,000 mAh last at 200 mA?', 'answer' => 'About 8.64775 h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap" label="Rated capacity (mAh)" value="2000" min="0" step="any" />
        <x-calc.field name="H" label="Rated discharge time (h)" value="20" min="0" step="any" />
        <x-calc.select name="mode" label="Load given as" :options="['I' => 'Current', 'P' => 'Power']" selected="I" />
        <div data-show-when="mode:I">
            <x-calc.field name="I" label="Load current" value="200" placeholder="Load current">
                <label for="calc-I-unit" class="sr-only">Load current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ma')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:P">
            <x-calc.field name="P" label="Load power" value="1" min="0" placeholder="Load power">
                <label for="calc-P-unit" class="sr-only">Load power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="V" label="Battery voltage" value="3.7" placeholder="Battery voltage">
            <label for="calc-V-unit" class="sr-only">Battery voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="k" label="Peukert exponent (1 for lithium, 1.1–1.3 for lead-acid)" value="1.05" min="1" step="any" />
        <x-calc.field name="usable" label="Usable share (%)" value="90" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="h" />
    </div>

    <x-calc.result label="Runtime" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'h', 'cap' => 2000, 'H' => 20, 'mode' => 'I', 'I' => 200, 'I-unit' => 'ma', 'P' => 1, 'P-unit' => 'w', 'V' => 3.7, 'V-unit' => 'v', 'k' => 1.05, 'usable' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'simple' => ['label' => 'Simple capacity ÷ current'],
            'eff' => ['label' => 'Effective capacity at this load'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
