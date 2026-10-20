<x-calc.page
    title="Inductive Reactance Calculator - SolveKit"
    description="Free inductive reactance calculator: solve X_L = 2πfL for reactance, frequency or inductance."
    lede="Solve X_L = 2πfL for reactance, frequency or inductance."
    about="An inductor opposes alternating current more as the frequency rises: X_L = 2πfL. At DC it is just a wire."
    :calc="['engine' => 'ph-em', 'tool' => 'inductive_reactance', 'fields' => ['solve', 'X', 'f', 'L', 'out_X', 'out_f', 'out_L'], 'unitFields' => ['X' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'L' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all()], 'data' => ['units' => collect(config('units'))->only(['X', 'energy', 'force', 'frequency_hz', 'inductance', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the reactance of 100 mH at 50 Hz?', 'answer' => '31.4159 Ω.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['X' => 'Inductive reactance', 'f' => 'Frequency', 'L' => 'Inductance']" selected="X" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:f,L" hidden>
            <x-calc.field name="X" label="Inductive reactance" value="31.4159" min="0" placeholder="Inductive reactance">
                <label for="calc-X-unit" class="sr-only">Inductive reactance unit</label>
                <select id="calc-X-unit" name="X-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:X,L">
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
            <x-calc.field name="L" label="Inductance" value="100" min="0" placeholder="Inductance">
                <label for="calc-L-unit" class="sr-only">Inductance unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
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
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['h' => 'H', 'mh' => 'mH', 'uh' => 'µH', 'nh' => 'nH']" selected="mh" />
        </div>
    </div>

    <x-calc.result label="Inductive reactance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'X', 'X' => 31.4159, 'X-unit' => 'ohm', 'out_X' => 'ohm', 'f' => 50, 'f-unit' => 'hz', 'out_f' => 'hz', 'L' => 100, 'L-unit' => 'mh', 'out_L' => 'mh'],
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
            <li>X_L = 2π f L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
