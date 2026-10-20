<x-calc.page
    title="Electric Motor Torque Calculator - SolveKit"
    description="Free motor torque calculator: shaft torque from power and speed, or from voltage, current and efficiency."
    lede="Find motor torque."
    about="Torque is power divided by angular speed. A 7.5 kW motor at 1,450 rpm gives about 49 N·m."
    :calc="['engine' => 'ph-em', 'tool' => 'motor_torque', 'fields' => ['mode', 'P', 'V', 'I', 'phase', 'pf', 'eff', 'rpm', 'out'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'torque', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What torque does 7.5 kW at 1,450 rpm give?', 'answer' => '49.3929 N·m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['power' => 'Output power', 'electrical' => 'Voltage, current and efficiency']" selected="power" />
        <div data-show-when="mode:power">
            <x-calc.field name="P" label="Output power" value="7.5" min="0" placeholder="Output power">
                <label for="calc-P-unit" class="sr-only">Output power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:electrical">
            <x-calc.field name="V" label="Voltage" value="400" placeholder="Voltage">
                <label for="calc-V-unit" class="sr-only">Voltage unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:electrical">
            <x-calc.field name="I" label="Current" value="14" placeholder="Current">
                <label for="calc-I-unit" class="sr-only">Current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:electrical">
            <x-calc.select name="phase" label="Supply" :options="['dc' => 'DC', 'single' => 'Single phase', 'three' => 'Three phase']" selected="three" />
        </div>
        <div data-show-when="mode:electrical">
            <x-calc.field name="pf" label="Power factor" value="0.85" min="0" step="any" />
        </div>
        <div data-show-when="mode:electrical">
            <x-calc.field name="eff" label="Efficiency (%)" value="90" min="0" step="any" />
        </div>
        <x-calc.field name="rpm" label="Speed (rpm)" value="1450" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['nm' => 'N·m', 'knm' => 'kN·m', 'ncm' => 'N·cm', 'nmm' => 'N·mm', 'lbfft' => 'ft·lbf', 'lbfin' => 'in·lbf', 'kgfm' => 'kgf·m']" selected="nm" />
    </div>

    <x-calc.result label="Torque" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nm', 'mode' => 'power', 'P' => 7.5, 'P-unit' => 'kw', 'V' => 400, 'V-unit' => 'v', 'I' => 14, 'I-unit' => 'a', 'phase' => 'three', 'pf' => 0.85, 'eff' => 90, 'rpm' => 1450],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'P' => ['label' => 'Mechanical power'],
            'lbft' => ['label' => 'In lbf·ft'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
