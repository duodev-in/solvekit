@php
    $units = config('units.frequency');
@endphp

<x-calc.page
    title="CPS Calculator - SolveKit"
    description="Professional CPS calculator for cycles per second calculations. Convert frequency units, analyze periodic signals, and calculate timing parameters for engineering applications."
    lede="Convert cycles per second (hertz) to rpm, periods and other frequency units, with wavelengths."
    about="One cycle per second is one hertz. Revolutions per minute divide by 60, angular frequency in rad/s divides by 2π, and the period is the inverse of frequency. Wavelength is wave speed ÷ frequency, shown for sound in air (343 m/s), sound in water (1,481 m/s) and light."
    :calc="['engine' => 'cps', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a frequency', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'Is CPS the same as hertz?', 'answer' => 'Yes. One cycle per second is exactly 1 Hz.'],
        ['question' => 'How do I convert rpm to Hz?', 'answer' => 'Divide by 60. 3,000 rpm is 50 Hz.'],
        ['question' => 'How is period related to frequency?', 'answer' => 'Period = 1 ÷ frequency. 50 Hz has a period of 20 ms.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="hz" to="rpm" value="50" min="0" label="Frequency" />

    <x-calc.result label="Revolutions per minute">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Mains 50 Hz' => ['value' => 50, 'from' => 'hz'],
        'Motor 1,800 rpm' => ['value' => 1800, 'from' => 'rpm'],
        'Wi-Fi 2.4 GHz' => ['value' => 2.4, 'from' => 'ghz'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="50 Hz in other units" />
        <x-calc.rows heading="Wavelength at this frequency" hint="meters" :rows="[
            'wave_air' => ['label' => 'Sound in air', 'unit' => 'm'],
            'wave_water' => ['label' => 'Sound in water', 'unit' => 'm'],
            'wave_light' => ['label' => 'Light or radio', 'unit' => 'm'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Hz = rpm ÷ 60</li>
            <li>period = 1 ÷ f</li>
            <li>λ = v ÷ f</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
