<x-calc.page
    title="Joule Heating Calculator - SolveKit"
    description="Free Joule heating calculator: Q = I²Rt, solved for any value."
    lede="Solve Q = I²Rt."
    about="Current through a resistance turns electrical energy into heat at I²R watts."
    :calc="['engine' => 'ph-thermo', 'tool' => 'joule_heating', 'fields' => ['solve', 'Q', 'I', 'R', 't', 'out_Q', 'out_I', 'out_R', 'out_t'], 'unitFields' => ['Q' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['Q', 'current', 'energy', 'force', 'length', 'mass', 'resistance', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What heat does 10 A through 2 Ω make in 30 s?', 'answer' => '6 kJ.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Q' => 'Heat generated', 'I' => 'Current', 'R' => 'Resistance', 't' => 'Time']" selected="Q" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:I,R,t" hidden>
            <x-calc.field name="Q" label="Heat generated" value="120" placeholder="Heat generated">
                <label for="calc-Q-unit" class="sr-only">Heat generated unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kj')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,R,t">
            <x-calc.field name="I" label="Current" value="10" placeholder="Current">
                <label for="calc-I-unit" class="sr-only">Current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,I,t">
            <x-calc.field name="R" label="Resistance" value="2" min="0" placeholder="Resistance">
                <label for="calc-R-unit" class="sr-only">Resistance unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,I,R">
            <x-calc.field name="t" label="Time" value="0.5" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q">
            <x-calc.select name="out_Q" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="kj" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
        </div>
        <div data-show-when="solve:R" hidden>
            <x-calc.select name="out_R" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="ohm" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="min" />
        </div>
    </div>

    <x-calc.result label="Heat generated" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Q', 'Q' => 120, 'Q-unit' => 'kj', 'out_Q' => 'kj', 'I' => 10, 'I-unit' => 'a', 'out_I' => 'a', 'R' => 2, 'R-unit' => 'ohm', 'out_R' => 'ohm', 't' => 0.5, 't-unit' => 'min', 'out_t' => 'min'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'P' => ['label' => 'Power'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = I² R t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
