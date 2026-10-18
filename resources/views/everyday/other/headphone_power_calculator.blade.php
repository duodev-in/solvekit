<x-calc.page
    title="Headphone Power Calculator - SolveKit"
    description="Free headphone power calculator: the power, voltage and current an amplifier needs to drive headphones to a target loudness from their sensitivity and impedance."
    lede="Work out whether an amplifier can drive your headphones."
    about="With sensitivity in dB per milliwatt, power = 10^((target SPL − sensitivity) ÷ 10) mW and voltage = √(power × impedance). With sensitivity in dB per volt, voltage = 10^((SPL − sensitivity) ÷ 20). For headroom, check peaks around 110 dB; for hearing, NIOSH treats 85 dBA as safe for 8 hours, halving the time for each 3 dB more."
    :calc="['engine' => 'ev-care', 'tool' => 'headphones', 'fields' => ['sensitivity', 'basis', 'impedance', 'spl']]"
    :how-to="[
        ['name' => 'Enter sensitivity and impedance', 'text' => 'From the headphone specs.'],
        ['name' => 'Set the target loudness', 'text' => '110 dB peaks gives headroom.'],
    ]"
    :faqs="[
        ['question' => 'How much power for 300 Ω, 98 dB/mW headphones?', 'answer' => 'About 15.8 mW and 2.2 V RMS for 110 dB peaks.'],
        ['question' => 'What is the difference between dB/mW and dB/V?', 'answer' => 'They measure sensitivity per milliwatt or per volt; this converts either.'],
        ['question' => 'Are high-impedance headphones hard to drive?', 'answer' => 'They need more voltage but little current.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sensitivity" label="Sensitivity" value="98" step="0.5" suffix="dB" />
        <x-calc.segmented name="basis" legend="Per" :options="['mw' => 'mW', 'v' => 'V']" selected="mw" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="impedance" label="Impedance" value="300" min="1" suffix="Ω" />
        <x-calc.field name="spl" label="Target loudness" value="110" min="60" max="130" step="1" suffix="dB SPL" />
    </div>

    <x-calc.result label="Power needed" />

    <x-calc.options :examples="[
        '300 Ω, 98 dB/mW' => ['sensitivity' => 98, 'basis' => 'mw', 'impedance' => 300, 'spl' => 110],
        '32 Ω, 105 dB/V' => ['sensitivity' => 105, 'basis' => 'v', 'impedance' => 32, 'spl' => 110],
        'Planar 50 Ω, 90 dB/mW' => ['sensitivity' => 90, 'basis' => 'mw', 'impedance' => 50, 'spl' => 115],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'volts' => ['label' => 'Voltage'],
            'current' => ['label' => 'Current'],
            'safety' => ['label' => 'Hearing'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P (mW) = 10^((SPL − S) ÷ 10)</li>
            <li>V = √(P × R)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
