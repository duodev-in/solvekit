<x-calc.page
    title="Vitamin A Calculator - SolveKit"
    description="Free vitamin A calculator: convert IU to µg RAE (and back) for retinol, supplemental beta-carotene and food carotenoids, against the RDA and upper limit."
    lede="Convert vitamin A units."
    about="Labels may show vitamin A in IU or µg RAE (retinol activity equivalents). NIH Office of Dietary Supplements factors: 1 IU retinol = 0.3 µg RAE, supplemental beta-carotene 0.15, beta-carotene in food 0.05 and other provitamin A carotenoids 0.025. The adult RDA is 900 µg RAE (men) and 700 (women); the upper limit of 3,000 µg applies to preformed vitamin A. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'vitamin_a', 'fields' => ['amount', 'unit', 'form', 'sex']]"
    :how-to="[
        ['name' => 'Enter the amount and unit', 'text' => ''],
        ['name' => 'Choose the form', 'text' => 'From the label.'],
    ]"
    :faqs="[
        ['question' => 'How many µg RAE is 5,000 IU of retinol?', 'answer' => '1,500 µg RAE.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="5000" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['iu' => 'IU', 'mcg' => 'µg RAE']" selected="iu" />
        <x-calc.select name="form" label="Form" :options="['retinol' => 'Retinol (preformed)', 'beta_supp' => 'Beta-carotene, supplement', 'beta_food' => 'Beta-carotene in food', 'other' => 'Other carotenoids in food']" selected="retinol" />
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="female" />

    <x-calc.result label="Vitamin A" />

    <x-calc.options :decimals="false" :examples="[
        '5,000 IU' => ['amount' => 5000, 'unit' => 'iu', 'form' => 'retinol', 'sex' => 'female'],
        'Beta-carotene' => ['amount' => 10000, 'unit' => 'iu', 'form' => 'beta_supp', 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rda' => ['label' => 'RDA'],
            'ul' => ['label' => 'Upper limit'],
            'pregnancy' => ['label' => 'Pregnancy'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RAE = IU × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
