<x-calc.page
    title="RMS to Watts Converter - SolveKit"
    description="Professional RMS to watts converter for AC power calculations. Convert RMS voltage and current to power for electrical engineering and power system analysis."
    lede="Calculate real power from RMS voltage, current and resistance."
    about="With a resistive load, power is V² ÷ R or I² × R. With voltage and current measured on an AC load, real power is V × I × power factor; the rest of V × I (the apparent power) is reactive power that flows back and forth without doing work."
    :calc="['engine' => 'rms-to-watts']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Voltage and resistance, current and resistance, or voltage and current.'],
        ['name' => 'Enter the values', 'text' => 'Use RMS values. For voltage and current, add the power factor (1 for a purely resistive load).'],
    ]"
    :faqs="[
        ['question' => 'How do I convert RMS voltage to watts?', 'answer' => 'With a resistance: P = V² ÷ R. 230 V across 53 Ω is about 1,000 W.'],
        ['question' => 'What is power factor?', 'answer' => 'The fraction of apparent power (V × I) that does real work. Resistive heaters are close to 1; motors are often 0.7 to 0.9.'],
        ['question' => 'Is RMS power the same as average power?', 'answer' => 'Yes. Real power calculated from RMS values is the average power delivered. The audio term RMS watts means the same thing.'],
    ]"
>
    <x-calc.segmented name="method" legend="I know" :options="['vr' => 'Voltage + resistance', 'ir' => 'Current + resistance', 'vi' => 'Voltage + current']" selected="vr" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="method:vr,vi"><x-calc.field name="voltage" label="Voltage (rms)" value="230" min="0" suffix="V" placeholder="Volts" /></div>
        <div data-show-when="method:ir,vi" hidden><x-calc.field name="current" label="Current (rms)" value="4.35" min="0" suffix="A" placeholder="Amps" /></div>
        <div data-show-when="method:vr,ir"><x-calc.field name="resistance" label="Resistance" value="53" min="0" suffix="Ω" placeholder="Ohms" /></div>
        <div data-show-when="method:vi" hidden><x-calc.field name="pf" label="Power factor" value="1" min="0" max="1" step="0.01" placeholder="0 to 1" /></div>
    </div>

    <x-calc.result label="Real power" />

    <x-calc.options :examples="[
        'Heater 230 V, 53 Ω' => ['method' => 'vr', 'voltage' => 230, 'resistance' => 53],
        'Motor 120 V, 8 A, PF 0.8' => ['method' => 'vi', 'voltage' => 120, 'current' => 8, 'pf' => 0.8],
        'Speaker 4 A, 8 Ω' => ['method' => 'ir', 'current' => 4, 'resistance' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Circuit values" :rows="[
            'kw' => ['label' => 'Kilowatts', 'unit' => 'kW'],
            'hp' => ['label' => 'Horsepower', 'unit' => 'hp'],
            'v' => ['label' => 'Voltage (rms)', 'unit' => 'V'],
            'a' => ['label' => 'Current (rms)', 'unit' => 'A'],
            'ohm' => ['label' => 'Resistance or impedance', 'unit' => 'Ω'],
            'va' => ['label' => 'Apparent power', 'unit' => 'VA'],
            'var' => ['label' => 'Reactive power', 'unit' => 'VAR'],
            'kwh' => ['label' => 'Energy per day (24 h)', 'unit' => 'kWh'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = V² ÷ R = I² × R</li>
            <li>P = V × I × PF · S = V × I</li>
            <li>Q = √(S² − P²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
