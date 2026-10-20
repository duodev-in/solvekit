<x-calc.page
    title="Signal-to-Noise Ratio Calculator - SolveKit"
    description="Free SNR calculator: signal-to-noise ratio in dB from powers, voltages or levels, with Shannon capacity."
    lede="Find the signal-to-noise ratio."
    about="SNR compares signal and noise power. For powers it is 10 log₁₀(P_s/P_n) dB; for voltages 20 log₁₀(V_s/V_n). Shannon’s limit gives the maximum data rate for a bandwidth."
    :calc="['engine' => 'ph-mech', 'tool' => 'snr', 'fields' => ['kind', 's', 'n', 'bw'], 'unitFields' => ['bw' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the SNR for 100 and 1 (powers)?', 'answer' => '20 dB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Values are" :options="['power' => 'Powers (same unit)', 'voltage' => 'Voltages or amplitudes (same unit)', 'db' => 'Levels in dB (dBm, dBV …)']" selected="power" />
        <x-calc.field name="s" label="Signal" value="100" step="any" />
        <x-calc.field name="n" label="Noise" value="1" step="any" />
        <x-calc.field name="bw" label="Bandwidth (optional, for capacity)" value="20" min="0" placeholder="Bandwidth (optional, for capacity)">
            <label for="calc-bw-unit" class="sr-only">Bandwidth (optional, for capacity) unit</label>
            <select id="calc-bw-unit" name="bw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Signal-to-noise ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'power', 's' => 100, 'n' => 1, 'bw' => 20, 'bw-unit' => 'mhz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'linear' => ['label' => 'Linear power ratio'],
            'capacity' => ['label' => 'Shannon capacity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
