<x-calc.page
    title="Frequency Converter - SolveKit"
    description="Free frequency converter: convert between hertz, kHz, MHz, period, angular frequency and rpm."
    lede="Convert frequency, period and rpm."
    about="Frequency, period, angular frequency and rotation rate describe the same thing: f = 1/T = ω/2π = rpm/60."
    :calc="['engine' => 'ph-wave', 'tool' => 'freq_converter', 'fields' => ['value', 'from'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 50 Hz in other forms?', 'answer' => 'Period 0.02 s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Value" value="50" min="0" step="any" />
        <x-calc.select name="from" label="Given as" :options="['hz' => 'Frequency (Hz)', 'khz' => 'Frequency (kHz)', 'mhz' => 'Frequency (MHz)', 'ghz' => 'Frequency (GHz)', 's' => 'Period (s)', 'ms' => 'Period (ms)', 'us' => 'Period (µs)', 'w' => 'Angular frequency (rad/s)', 'rpm' => 'Revolutions per minute']" selected="hz" />
    </div>

    <x-calc.result label="Frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => 50, 'from' => 'hz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Period'],
            'w' => ['label' => 'Angular frequency'],
            'rpm' => ['label' => 'Revolutions per minute'],
            'lambda' => ['label' => 'Wavelength of a radio wave'],
            'sound' => ['label' => 'Wavelength of sound in air (343 m/s)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
