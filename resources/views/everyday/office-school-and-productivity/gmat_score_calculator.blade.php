<x-calc.page
    title="GMAT Score Calculator - SolveKit"
    description="Free GMAT score calculator: the percentile rank of a GMAT Focus Edition total score and its equivalent on the old 10th Edition scale, from GMAC's official concordance table."
    lede="Find the percentile of your GMAT Focus score."
    about="GMAT Focus Edition total scores run from 205 to 805 and always end in 5. The percentile is the share of test takers at or below your score in GMAC's August 2026 table (July 2021 – June 2026 data), which also links each score to the old 10th Edition scale. GMAC does not publish how section scores combine into the total, so this works from the total score."
    :calc="['engine' => 'ev-office', 'tool' => 'gmat', 'fields' => ['score'], 'data' => ['gmat' => config('everyday_data.gmat')]]"
    :how-to="[
        ['name' => 'Enter your total score', 'text' => 'From 205 to 805.'],
    ]"
    :faqs="[
        ['question' => 'What percentile is a 645 on the GMAT Focus?', 'answer' => 'The 85.6th percentile (GMAC, August 2026).'],
        ['question' => 'What is a 705 on the old scale?', 'answer' => '750 on the 10th Edition scale, 97.5th percentile.'],
        ['question' => 'What is the average GMAT Focus score?', 'answer' => 'About 555–565 is near the median.'],
    ]"
>
    <x-calc.field name="score" label="GMAT Focus total score" value="645" min="205" max="805" step="10" />

    <x-calc.result label="Percentile" />

    <x-calc.options :decimals="false" :examples="[
        '645' => ['score' => 645],
        '705' => ['score' => 705],
        '565' => ['score' => 565],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tenth' => ['label' => '10th Edition equivalent'],
            'above' => ['label' => 'Scored higher'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>percentile = GMAC table lookup</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
