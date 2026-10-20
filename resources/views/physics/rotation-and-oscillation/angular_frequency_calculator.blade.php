<x-calc.page
    title="Angular Frequency Calculator - SolveKit"
    description="Free angular frequency calculator: ω = 2πf between rad/s and hertz."
    lede="Convert frequency to ω."
    about="Angular frequency ω counts radians per second; one full cycle is 2π radians, so ω = 2πf."
    :calc="['engine' => 'ph-mech', 'tool' => 'ang_freq', 'fields' => ['solve', 'w', 'f', 'out_w', 'out_f'], 'unitFields' => ['w' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['angular_speed', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'short_time', 'speed', 'w'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is ω for 50 Hz?', 'answer' => '314.159 rad/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['w' => 'Angular frequency ω', 'f' => 'Frequency f']" selected="w" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:f" hidden>
            <x-calc.field name="w" label="Angular frequency ω" value="314.159" placeholder="Angular frequency ω">
                <label for="calc-w-unit" class="sr-only">Angular frequency ω unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rads')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:w">
            <x-calc.field name="f" label="Frequency f" value="50" min="0" placeholder="Frequency f">
                <label for="calc-f-unit" class="sr-only">Frequency f unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:w">
            <x-calc.select name="out_w" label="Show the result in" :options="['rads' => 'rad/s', 'rpm' => 'rpm', 'rps' => 'rev/s', 'degs' => '°/s', 'radmin' => 'rad/min']" selected="rads" />
        </div>
        <div data-show-when="solve:f" hidden>
            <x-calc.select name="out_f" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
        </div>
    </div>

    <x-calc.result label="Angular frequency ω" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'w', 'w' => 314.159, 'w-unit' => 'rads', 'out_w' => 'rads', 'f' => 50, 'f-unit' => 'hz', 'out_f' => 'hz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'T' => ['label' => 'Period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ω = 2π f</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
