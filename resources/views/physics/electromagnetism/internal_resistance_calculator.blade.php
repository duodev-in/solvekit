<x-calc.page
    title="Internal Resistance Calculator - SolveKit"
    description="Free internal resistance calculator: battery or source resistance from EMF, terminal voltage and load."
    lede="Find internal resistance."
    about="A source’s voltage sags under load because of its internal resistance: r = (ε − V)/I."
    :calc="['engine' => 'ph-em', 'tool' => 'internal_resistance', 'fields' => ['emf', 'V', 'mode', 'I', 'R', 'out'], 'unitFields' => ['emf' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'resistance', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is r for 12.6 V falling to 12.0 V at 10 A?', 'answer' => '60 mΩ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="emf" label="EMF (open-circuit voltage)" value="12.6" placeholder="EMF (open-circuit voltage)">
            <label for="calc-emf-unit" class="sr-only">EMF (open-circuit voltage) unit</label>
            <select id="calc-emf-unit" name="emf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V" label="Terminal voltage under load" value="12" placeholder="Terminal voltage under load">
            <label for="calc-V-unit" class="sr-only">Terminal voltage under load unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mode" label="Load given as" :options="['I' => 'Current', 'R' => 'Resistance']" selected="I" />
        <div data-show-when="mode:I">
            <x-calc.field name="I" label="Load current" value="10" placeholder="Load current">
                <label for="calc-I-unit" class="sr-only">Load current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:R">
            <x-calc.field name="R" label="Load resistance" value="1.2" min="0" placeholder="Load resistance">
                <label for="calc-R-unit" class="sr-only">Load resistance unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="mohm" />
    </div>

    <x-calc.result label="Internal resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mohm', 'emf' => 12.6, 'emf-unit' => 'v', 'V' => 12, 'V-unit' => 'v', 'mode' => 'I', 'I' => 10, 'I-unit' => 'a', 'R' => 1.2, 'R-unit' => 'ohm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Isc' => ['label' => 'Short-circuit current'],
            'Pmax' => ['label' => 'Maximum power into a matched load'],
            'lost' => ['label' => 'Power wasted inside'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
