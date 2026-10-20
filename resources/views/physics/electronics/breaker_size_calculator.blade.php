<x-calc.page
    title="Breaker Size Calculator - SolveKit"
    description="Free breaker size calculator: circuit breaker rating for a load with the 125% continuous rule and standard sizes."
    lede="Find the breaker size for a load."
    about="Continuous loads (3 hours or more) need a breaker rated at 125% of the load current, then rounded up to a standard size (NEC 210.20 and 240.6). Local codes may differ."
    :calc="['engine' => 'ph-elec', 'tool' => 'breaker', 'fields' => ['mode', 'I', 'P', 'V', 'phase', 'cont'], 'unitFields' => ['I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What breaker suits a 3 kW continuous load at 240 V?', 'answer' => '20 A.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Load given as" :options="['A' => 'Current', 'W' => 'Power']" selected="W" />
        <div data-show-when="mode:A">
            <x-calc.field name="I" label="Load current" value="16" placeholder="Load current">
                <label for="calc-I-unit" class="sr-only">Load current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:W">
            <x-calc.field name="P" label="Load power" value="3000" min="0" placeholder="Load power">
                <label for="calc-P-unit" class="sr-only">Load power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="V" label="Voltage" value="240" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="phase" label="Supply" :options="['single' => 'Single phase', 'three' => 'Three phase']" selected="single" />
        <x-calc.select name="cont" label="Continuous load (3 h or more)" :options="['yes' => 'Yes', 'no' => 'No']" selected="yes" />
    </div>

    <x-calc.result label="Breaker size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'W', 'I' => 16, 'I-unit' => 'a', 'P' => 3000, 'P-unit' => 'w', 'V' => 240, 'V-unit' => 'v', 'phase' => 'single', 'cont' => 'yes'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'I' => ['label' => 'Load current'],
            'need' => ['label' => 'Minimum rating'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
