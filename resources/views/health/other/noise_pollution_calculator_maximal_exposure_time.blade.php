<x-calc.page
    title="Noise Pollution Calculator - Maximal Exposure Time - SolveKit"
    description="Free noise exposure calculator: the maximum safe daily time at a sound level, by the NIOSH recommendation and the OSHA limit."
    lede="Find how long a noise level is safe."
    about="NIOSH recommends no more than 85 dBA for 8 hours, halving the time for every 3 dB louder: T = 480 ÷ 2^((L − 85) ÷ 3) minutes. OSHA's legal limit is 90 dBA for 8 hours with a 5 dB exchange rate. Hearing protection is advised above 85 dBA. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'noise', 'fields' => ['level']]"
    :how-to="[
        ['name' => 'Enter the sound level', 'text' => 'From a sound meter or app.'],
    ]"
    :faqs="[
        ['question' => 'How long is 94 dBA safe?', 'answer' => '1.0 h a day (NIOSH).'],
        ['question' => 'And 100 dBA?', 'answer' => '15 min.'],
    ]"
>
    <x-calc.field name="level" label="Sound level" value="94" min="70" max="140" step="1" suffix="dBA" />

    <x-calc.result label="Safe exposure a day (NIOSH)" />

    <x-calc.options :decimals="false" :examples="[
        '94 dBA' => ['level' => 94],
        '100 dBA' => ['level' => 100],
        '85 dBA' => ['level' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'niosh' => ['label' => 'NIOSH'],
            'osha' => ['label' => 'OSHA'],
            'examples' => ['label' => 'Examples'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T = 480 ÷ 2^((L − 85) ÷ 3)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
