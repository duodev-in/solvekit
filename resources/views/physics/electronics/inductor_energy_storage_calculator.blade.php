<x-calc.page
    title="Inductor Energy Storage Calculator - SolveKit"
    description="Free inductor energy storage calculator: stored energy E = ½LI² solved for any value."
    lede="Stored energy E = ½LI² solved for any value."
    about="An inductor stores energy in its magnetic field: ½LI². That is why interrupting inductor current causes voltage spikes."
    :calc="['engine' => 'ph-elec', 'tool' => 'inductor_energy', 'fields' => ['solve', 'E', 'L', 'I', 'out_E', 'out_L', 'out_I'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'L' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['E', 'current', 'energy', 'force', 'inductance', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How much energy does 10 mH store at 3.16 A?', 'answer' => '0.0500007 J.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['E' => 'Energy stored', 'L' => 'Inductance', 'I' => 'Current']" selected="E" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:L,I" hidden>
            <x-calc.field name="E" label="Energy stored" value="0.05" placeholder="Energy stored">
                <label for="calc-E-unit" class="sr-only">Energy stored unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,I">
            <x-calc.field name="L" label="Inductance" value="10" min="0" placeholder="Inductance">
                <label for="calc-L-unit" class="sr-only">Inductance unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,L">
            <x-calc.field name="I" label="Current" value="3.1623" placeholder="Current">
                <label for="calc-I-unit" class="sr-only">Current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E">
            <x-calc.select name="out_E" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="j" />
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['h' => 'H', 'mh' => 'mH', 'uh' => 'µH', 'nh' => 'nH']" selected="mh" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
        </div>
    </div>

    <x-calc.result label="Energy stored" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'E', 'E' => 0.05, 'E-unit' => 'j', 'out_E' => 'j', 'L' => 10, 'L-unit' => 'mh', 'out_L' => 'mh', 'I' => 3.1623, 'I-unit' => 'a', 'out_I' => 'a'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = ½ L I²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
