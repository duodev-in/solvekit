<x-calc.page
    title="mcg to IU Converter - SolveKit"
    description="Free mcg to IU converter: convert micrograms (or milligrams) and International Units for vitamin D, vitamin A and vitamin E with the NIH conversion factors."
    lede="Convert vitamins between mcg and IU."
    about="International Units depend on the vitamin and its form. NIH Office of Dietary Supplements: vitamin D 1 IU = 0.025 µg (1 µg = 40 IU); vitamin A as retinol 1 IU = 0.3 µg RAE, as supplemental beta-carotene 0.15 µg RAE; vitamin E natural (d-alpha-tocopherol) 1 IU = 0.67 mg, synthetic (dl-) 0.45 mg. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'mcg_iu', 'fields' => ['amount', 'vitamin', 'direction']]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the vitamin and direction', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many µg is 1,000 IU of vitamin D?', 'answer' => '25.00 µg.'],
        ['question' => 'How many IU is 15 mg of natural vitamin E?', 'answer' => '22.4 IU.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="1000" min="0" step="any" />
        <x-calc.select name="vitamin" label="Vitamin" :options="['vitamin_d' => 'Vitamin D', 'vitamin_a' => 'Vitamin A (retinol)', 'beta_carotene' => 'Vitamin A (beta-carotene supplement)', 'vitamin_e_natural' => 'Vitamin E (natural)', 'vitamin_e_synthetic' => 'Vitamin E (synthetic)']" selected="vitamin_d" />
        <x-calc.select name="direction" label="Convert" :options="['from_iu' => 'IU to µg (or mg)', 'to_iu' => 'µg (or mg) to IU']" selected="from_iu" />
    </div>

    <x-calc.result label="Converted amount" />

    <x-calc.options :decimals="false" :examples="[
        'Vitamin D' => ['amount' => 1000, 'vitamin' => 'vitamin_d', 'direction' => 'from_iu'],
        'Vitamin E' => ['amount' => 15, 'vitamin' => 'vitamin_e_natural', 'direction' => 'to_iu'],
        'Vitamin A' => ['amount' => 5000, 'vitamin' => 'vitamin_a', 'direction' => 'from_iu'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Factor'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>amount = IU × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
