<x-calc.page
    title="Frequency Calculator - SolveKit"
    description="Free frequency calculator: f = 1 ÷ T between frequency and period. Includes practice questions."
    lede="Convert period to frequency."
    about="Frequency is the number of cycles per second; the period is the time for one cycle; each is the reciprocal of the other."
    :calc="['engine' => 'ph-mech', 'tool' => 'frequency', 'fields' => ['mode', 'solve', 'f', 'T', 'out_f', 'out_T', 'question', 'answer'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'T' => collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h'])->all()], 'data' => ['units' => collect(config('units'))->only(['angular_speed', 'energy', 'f', 'force', 'frequency_hz', 'length', 'mass', 'short_time', 'speed'])->all()], 'practice' => 'frequency']"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the frequency for a 20 ms period?', 'answer' => '50 Hz.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered frequency, period and wavelength problems, with answer checking and the working. This replaces the old frequency quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <x-calc.select name="solve" label="Solve for" :options="['f' => 'Frequency', 'T' => 'Period']" selected="f" />
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="solve:T" hidden>
                <x-calc.field name="f" label="Frequency" value="50" min="0" placeholder="Frequency">
                    <label for="calc-f-unit" class="sr-only">Frequency unit</label>
                    <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="solve:f">
                <x-calc.field name="T" label="Period" value="20" min="0" placeholder="Period">
                    <label for="calc-T-unit" class="sr-only">Period unit</label>
                    <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="solve:f">
                <x-calc.select name="out_f" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
            </div>
            <div data-show-when="solve:T" hidden>
                <x-calc.select name="out_T" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'ns' => 'ns', 'ps' => 'ps', 'min' => 'min', 'h' => 'h']" selected="ms" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'solve' => 'f', 'f' => 50, 'f-unit' => 'hz', 'out_f' => 'hz', 'T' => 20, 'T-unit' => 'ms', 'out_T' => 'ms'],
        'Practice' => ['solve' => 'f', 'f' => 50, 'f-unit' => 'hz', 'out_f' => 'hz', 'T' => 20, 'T-unit' => 'ms', 'out_T' => 'ms', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'formula' => ['label' => 'Rearranged formula'],
                'si' => ['label' => 'Result in common units'],
                'w' => ['label' => 'Angular frequency'],
                'lambda' => ['label' => 'Wavelength of sound at this frequency (343 m/s)'],
            ]" />
        </div>
        <div data-show-when="mode:practice" hidden>
            <x-calc.rows heading="Details" :rows="[
                'question' => ['label' => 'Question'],
                'yours' => ['label' => 'Your answer'],
                'check' => ['label' => 'Check'],
                'answer' => ['label' => 'Answer'],
            ]" />
        </div>
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f = 1 ÷ T</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
