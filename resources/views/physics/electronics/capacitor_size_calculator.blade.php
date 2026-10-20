<x-calc.page
    title="Capacitor Size Calculator - SolveKit"
    description="Free capacitor size calculator: capacitance for energy storage, supply smoothing or hold-up time."
    lede="Find the capacitor you need."
    about="For smoothing, C ≈ I/(2fΔV); for hold-up, the capacitor must supply the load’s energy as its voltage falls to the minimum."
    :calc="['engine' => 'ph-elec', 'tool' => 'cap_size', 'fields' => ['purpose', 'E', 'V', 'I', 'f', 'rect', 'dv', 'P', 't', 'Vmin', 'out'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'dv' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 't' => collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h'])->all(), 'Vmin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'current', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'power', 'short_time', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What smoothing capacitor gives 1 V ripple at 1 A?', 'answer' => '10,000 µF.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="purpose" label="Purpose" :options="['energy' => 'Store an amount of energy', 'smooth' => 'Smooth a rectified supply', 'holdup' => 'Hold up a load for a time']" selected="smooth" />
        <div data-show-when="purpose:energy">
            <x-calc.field name="E" label="Energy" value="10" placeholder="Energy">
                <label for="calc-E-unit" class="sr-only">Energy unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="V" label="Voltage" value="12" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="purpose:smooth">
            <x-calc.field name="I" label="Load current" value="1" placeholder="Load current">
                <label for="calc-I-unit" class="sr-only">Load current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="purpose:smooth">
            <x-calc.field name="f" label="Mains frequency" value="50" min="0" placeholder="Mains frequency">
                <label for="calc-f-unit" class="sr-only">Mains frequency unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="purpose:smooth">
            <x-calc.select name="rect" label="Rectifier" :options="['full' => 'Full wave', 'half' => 'Half wave']" selected="full" />
        </div>
        <div data-show-when="purpose:smooth">
            <x-calc.field name="dv" label="Allowed ripple or droop" value="1" placeholder="Allowed ripple or droop">
                <label for="calc-dv-unit" class="sr-only">Allowed ripple or droop unit</label>
                <select id="calc-dv-unit" name="dv-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="purpose:holdup">
            <x-calc.field name="P" label="Load power" value="10" min="0" placeholder="Load power">
                <label for="calc-P-unit" class="sr-only">Load power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="purpose:holdup">
            <x-calc.field name="t" label="Hold-up time" value="20" min="0" placeholder="Hold-up time">
                <label for="calc-t-unit" class="sr-only">Hold-up time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="purpose:holdup">
            <x-calc.field name="Vmin" label="Minimum voltage the load accepts" value="9" placeholder="Minimum voltage the load accepts">
                <label for="calc-Vmin-unit" class="sr-only">Minimum voltage the load accepts unit</label>
                <select id="calc-Vmin-unit" name="Vmin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="uf" />
    </div>

    <x-calc.result label="Capacitance needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'uf', 'purpose' => 'smooth', 'E' => 10, 'E-unit' => 'j', 'V' => 12, 'V-unit' => 'v', 'I' => 1, 'I-unit' => 'a', 'f' => 50, 'f-unit' => 'hz', 'rect' => 'full', 'dv' => 1, 'dv-unit' => 'v', 'P' => 10, 'P-unit' => 'w', 't' => 20, 't-unit' => 'ms', 'Vmin' => 9, 'Vmin-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rating' => ['label' => 'Voltage rating'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
