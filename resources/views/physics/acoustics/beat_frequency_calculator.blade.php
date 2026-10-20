<x-calc.page
    title="Beat Frequency Calculator - SolveKit"
    description="Free beat frequency calculator: beats per second between two tones, with their difference in cents."
    lede="Find the beat frequency."
    about="Two close tones interfere and their loudness pulses at the difference frequency |f₁ − f₂|. Tuners listen for the beats to disappear."
    :calc="['engine' => 'ph-wave', 'tool' => 'beat', 'fields' => ['f1', 'f2', 'out'], 'unitFields' => ['f1' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'f2' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'short_time', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many beats do 440 and 444 Hz make?', 'answer' => '4 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="f1" label="First frequency" value="440" min="0" placeholder="First frequency">
            <label for="calc-f1-unit" class="sr-only">First frequency unit</label>
            <select id="calc-f1-unit" name="f1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f2" label="Second frequency" value="444" min="0" placeholder="Second frequency">
            <label for="calc-f2-unit" class="sr-only">Second frequency unit</label>
            <select id="calc-f2-unit" name="f2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
    </div>

    <x-calc.result label="Beat frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hz', 'f1' => 440, 'f1-unit' => 'hz', 'f2' => 444, 'f2-unit' => 'hz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Time between beats'],
            'avg' => ['label' => 'Tone you hear'],
            'cents' => ['label' => 'Difference in cents'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
