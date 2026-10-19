<x-calc.page
    title="IQ Percentile Calculator - SolveKit"
    description="Free IQ percentile calculator: the percentile and rarity of an IQ score on a normal distribution with mean 100."
    lede="Turn an IQ score into a percentile."
    about="IQ scores are scaled to a normal distribution with mean 100 and standard deviation 15 (16 on some older tests). Percentile = Φ((IQ − 100) ÷ SD). Classification labels follow the Wechsler scales. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'iq_percentile', 'fields' => ['iq', 'sd']]"
    :how-to="[
        ['name' => 'Enter the score', 'text' => ''],
        ['name' => 'Pick the test\'s SD', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What percentile is an IQ of 115?', 'answer' => '84th percentile.'],
        ['question' => 'How rare is 130?', 'answer' => 'About 1 in 44 people score this high or higher.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="iq" label="IQ score" value="115" min="40" max="200" step="1" />
        <x-calc.select name="sd" label="Test standard deviation" :options="['15' => '15 (Wechsler, Stanford-Binet 5)', '16' => '16 (older Stanford-Binet, Cattell)']" selected="15" />
    </div>

    <x-calc.result label="IQ" />

    <x-calc.options :decimals="false" :examples="[
        '115' => ['iq' => 115, 'sd' => '15'],
        '130' => ['iq' => 130, 'sd' => '15'],
        '85' => ['iq' => 85, 'sd' => '15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'z' => ['label' => 'Z-score'],
            'rarity' => ['label' => 'Rarity'],
            'range' => ['label' => 'Classification'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>percentile = Φ((IQ − 100) ÷ SD)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
