<x-calc.page
    title="Resonant Frequency Calculator - SolveKit"
    description="Free resonant frequency calculator: solve f = 1 ÷ 2π√(LC) for frequency, inductance or capacitance."
    lede="Solve f = 1 ÷ 2π√(LC) for frequency, inductance or capacitance."
    about="An LC circuit resonates where the inductive and capacitive reactances are equal."
    :calc="['engine' => 'ph-elec', 'tool' => 'resonant_frequency', 'fields' => ['solve', 'f', 'L', 'C', 'out_f', 'out_L', 'out_C'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'L' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'f', 'force', 'frequency_hz', 'inductance', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the resonant frequency of 10 mH and 100 nF?', 'answer' => '5.03292 kHz.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['f' => 'Resonant frequency', 'L' => 'Inductance', 'C' => 'Capacitance']" selected="f" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:L,C" hidden>
            <x-calc.field name="f" label="Resonant frequency" value="5.03292" min="0" placeholder="Resonant frequency">
                <label for="calc-f-unit" class="sr-only">Resonant frequency unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'khz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f,C">
            <x-calc.field name="L" label="Inductance" value="10" min="0" placeholder="Inductance">
                <label for="calc-L-unit" class="sr-only">Inductance unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f,L">
            <x-calc.field name="C" label="Capacitance" value="100" min="0" placeholder="Capacitance">
                <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
                <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nf')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f">
            <x-calc.select name="out_f" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="khz" />
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['h' => 'H', 'mh' => 'mH', 'uh' => 'µH', 'nh' => 'nH']" selected="mh" />
        </div>
        <div data-show-when="solve:C" hidden>
            <x-calc.select name="out_C" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="nf" />
        </div>
    </div>

    <x-calc.result label="Resonant frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'f', 'f' => 5.03292, 'f-unit' => 'khz', 'out_f' => 'khz', 'L' => 10, 'L-unit' => 'mh', 'out_L' => 'mh', 'C' => 100, 'C-unit' => 'nf', 'out_C' => 'nf'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'Z0' => ['label' => 'Characteristic impedance √(L/C)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f = 1 ÷ (2π √(L C))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
