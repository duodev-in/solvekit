<x-calc.page
    title="Capacitive Reactance Calculator - SolveKit"
    description="Free capacitive reactance calculator: solve X_C = 1 ÷ 2πfC for reactance, frequency or capacitance."
    lede="Solve X_C = 1 ÷ 2πfC for reactance, frequency or capacitance."
    about="A capacitor opposes alternating current less as the frequency rises: X_C = 1/(2πfC). At DC it blocks completely."
    :calc="['engine' => 'ph-em', 'tool' => 'capacitive_reactance', 'fields' => ['solve', 'X', 'f', 'C', 'out_X', 'out_f', 'out_C'], 'unitFields' => ['X' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all()], 'data' => ['units' => collect(config('units'))->only(['X', 'capacitance', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the reactance of 100 µF at 50 Hz?', 'answer' => '31.831 Ω.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['X' => 'Capacitive reactance', 'f' => 'Frequency', 'C' => 'Capacitance']" selected="X" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:f,C" hidden>
            <x-calc.field name="X" label="Capacitive reactance" value="31.831" min="0" placeholder="Capacitive reactance">
                <label for="calc-X-unit" class="sr-only">Capacitive reactance unit</label>
                <select id="calc-X-unit" name="X-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:X,C">
            <x-calc.field name="f" label="Frequency" value="50" min="0" placeholder="Frequency">
                <label for="calc-f-unit" class="sr-only">Frequency unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:X,f">
            <x-calc.field name="C" label="Capacitance" value="100" min="0" placeholder="Capacitance">
                <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
                <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:X">
            <x-calc.select name="out_X" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="ohm" />
        </div>
        <div data-show-when="solve:f" hidden>
            <x-calc.select name="out_f" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
        </div>
        <div data-show-when="solve:C" hidden>
            <x-calc.select name="out_C" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="uf" />
        </div>
    </div>

    <x-calc.result label="Capacitive reactance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'X', 'X' => 31.831, 'X-unit' => 'ohm', 'out_X' => 'ohm', 'f' => 50, 'f-unit' => 'hz', 'out_f' => 'hz', 'C' => 100, 'C-unit' => 'uf', 'out_C' => 'uf'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'I' => ['label' => 'Current at 230 V'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>X_C = 1 ÷ (2π f C)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
