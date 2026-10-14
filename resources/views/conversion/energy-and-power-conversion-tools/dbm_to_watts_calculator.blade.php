<x-calc.page
    title="dBm to Watts Calculator - SolveKit"
    description="Professional dBm to watts calculator for RF power conversion. Convert decibel-milliwatts to watts for radio frequency and telecommunications applications."
    lede="Convert dBm, dBW, dBu and dBV to watts, or watts to dBm."
    about="dBm is power relative to 1 milliwatt on a log scale: W = 10^((dBm − 30) ÷ 10). dBW is relative to 1 W. dBu and dBV are voltage levels (0.7746 V and 1 V), so turning them into power needs the load impedance: P = V² ÷ R."
    :calc="['engine' => 'dbm-to-watts']"
    :how-to="[
        ['name' => 'Enter a level', 'text' => 'Type a value and choose dBm, dBW, dBu, dBV or a power unit.'],
        ['name' => 'Check the impedance', 'text' => '50 Ω is standard for RF; use 600 Ω or your load for audio.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert dBm to watts?', 'answer' => 'W = 10^((dBm − 30) ÷ 10). 30 dBm is 1 W, 0 dBm is 1 mW and 20 dBm is 100 mW.'],
        ['question' => 'What is the difference between dBm and dBW?', 'answer' => 'dBm is referenced to 1 mW and dBW to 1 W, so dBW = dBm − 30.'],
        ['question' => 'Why does dBu need an impedance?', 'answer' => 'dBu measures voltage. Power depends on the load: P = V² ÷ R.'],
        ['question' => 'How much power is 3 dB?', 'answer' => 'Every +3 dB roughly doubles the power, and +10 dB multiplies it by ten.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
        <x-calc.field name="value" label="Level" value="20" placeholder="Enter a level">
            <label for="calc-unit" class="sr-only">Level unit</label>
            <select id="calc-unit" name="unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(['dbm' => 'dBm', 'dbw' => 'dBW', 'dbu' => 'dBu', 'dbv' => 'dBV', 'w' => 'W', 'mw' => 'mW', 'uw' => 'µW'] as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="impedance" label="Impedance" value="50" min="0" suffix="Ω" placeholder="Ohms" />
    </div>

    <x-calc.result label="Watts" />

    <x-calc.options :examples="[
        'Wi-Fi 20 dBm' => ['value' => 20, 'unit' => 'dbm'],
        'Phone signal −90 dBm' => ['value' => -90, 'unit' => 'dbm'],
        'Transmitter 5 W' => ['value' => 5, 'unit' => 'w'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same level in" :rows="[
            'dbm' => ['label' => 'dBm', 'unit' => 'dBm'],
            'dbw' => ['label' => 'dBW', 'unit' => 'dBW'],
            'dbu' => ['label' => 'dBu', 'unit' => 'dBu'],
            'dbv' => ['label' => 'dBV', 'unit' => 'dBV'],
            'w' => ['label' => 'Watts', 'unit' => 'W'],
            'mw' => ['label' => 'Milliwatts', 'unit' => 'mW'],
            'uw' => ['label' => 'Microwatts', 'unit' => 'µW'],
            'v' => ['label' => 'Voltage (rms)', 'unit' => 'V'],
            'a' => ['label' => 'Current (rms)', 'unit' => 'A'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>W = 10^((dBm − 30) ÷ 10)</li>
            <li>dBm = 10 × log₁₀(W) + 30</li>
            <li>V = √(P × R) · dBu = 20 × log₁₀(V ÷ 0.7746)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
