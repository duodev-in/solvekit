<x-calc.page
    title="Vitamin D Calculator - SolveKit"
    description="Free vitamin D calculator: convert IU and micrograms (1 µg = 40 IU) and compare with the RDA (600–800 IU) and the 4,000 IU upper limit."
    lede="Convert and check vitamin D."
    about="Vitamin D is labelled in µg or IU: 1 µg = 40 IU. The RDA is 15 µg (600 IU) for ages 1–70 and 20 µg (800 IU) over 70; the adult upper limit is 100 µg (4,000 IU) a day (National Academies). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'vitamin_d', 'fields' => ['amount', 'unit', 'age']]"
    :how-to="[
        ['name' => 'Enter the amount and unit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many micrograms is 1,000 IU?', 'answer' => '25.0 µg.'],
        ['question' => 'Is 5,000 IU above the limit?', 'answer' => 'Above the 100 µg (4,000 IU) adult upper limit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="1000" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['iu' => 'IU', 'mcg' => 'µg']" selected="iu" />
        <x-calc.field name="age" label="Age" value="45" min="0" step="1" suffix="years" />
    </div>

    <x-calc.result label="Vitamin D" />

    <x-calc.options :decimals="false" :examples="[
        '1,000 IU' => ['amount' => 1000, 'unit' => 'iu', 'age' => 45],
        '5,000 IU' => ['amount' => 5000, 'unit' => 'iu', 'age' => 45],
        '25 µg' => ['amount' => 25, 'unit' => 'mcg', 'age' => 75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rda' => ['label' => 'RDA'],
            'ul' => ['label' => 'Upper limit'],
            'sun' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>µg = IU ÷ 40</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
