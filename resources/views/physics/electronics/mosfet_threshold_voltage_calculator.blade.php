<x-calc.page
    title="MOSFET Threshold Voltage Calculator - SolveKit"
    description="Free MOSFET threshold voltage calculator: V_th from doping, oxide thickness and body bias."
    lede="Find MOSFET threshold voltage."
    about="The threshold voltage is the gate voltage that inverts the surface: V_FB + 2φ_F plus the depletion charge term, which grows with body bias."
    :calc="['engine' => 'ph-elec', 'tool' => 'mosfet_vth', 'fields' => ['Na', 'tox', 'Vfb', 'Vsb', 'T', 'out'], 'unitFields' => ['tox' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'Vfb' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vsb' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is V_th for N_A = 10¹⁷ cm⁻³ and 10 nm oxide?', 'answer' => '0.417407 V.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Na" label="Substrate doping N_A (cm⁻³)" value="100000000000000000" min="0" step="any" />
        <x-calc.field name="tox" label="Gate oxide thickness" value="10" placeholder="Gate oxide thickness">
            <label for="calc-tox-unit" class="sr-only">Gate oxide thickness unit</label>
            <select id="calc-tox-unit" name="tox-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vfb" label="Flat-band voltage" value="-0.9" placeholder="Flat-band voltage">
            <label for="calc-Vfb-unit" class="sr-only">Flat-band voltage unit</label>
            <select id="calc-Vfb-unit" name="Vfb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vsb" label="Source–body voltage" value="0" placeholder="Source–body voltage">
            <label for="calc-Vsb-unit" class="sr-only">Source–body voltage unit</label>
            <select id="calc-Vsb-unit" name="Vsb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="300" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
    </div>

    <x-calc.result label="Threshold voltage (n-channel)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'v', 'Na' => 100000000000000000, 'tox' => 10, 'tox-unit' => 'nm', 'Vfb' => -0.9, 'Vfb-unit' => 'v', 'Vsb' => 0, 'Vsb-unit' => 'v', 'T' => 300, 'T-unit' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'phiF' => ['label' => 'Fermi potential φ_F'],
            'Cox' => ['label' => 'Oxide capacitance'],
            'gamma' => ['label' => 'Body-effect coefficient γ'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
