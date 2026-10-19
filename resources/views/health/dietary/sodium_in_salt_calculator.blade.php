<x-calc.page
    title="Sodium in Salt Calculator - SolveKit"
    description="Free sodium in salt calculator: convert grams or teaspoons of salt to milligrams of sodium and back, against the 2,300 mg daily value and WHO's 2,000 mg."
    lede="Convert salt and sodium."
    about="Salt (sodium chloride) is 39.3% sodium by weight, so 1 g of salt has 393 mg sodium and a level teaspoon of table salt (about 6 g) about 2,360 mg. The FDA daily value is 2,300 mg sodium; WHO advises under 2,000 mg (5 g salt). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'sodium_salt', 'fields' => ['amount', 'unit']]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much sodium is in a teaspoon of salt?', 'answer' => '2,360 mg sodium.'],
        ['question' => 'How much salt is 2,300 mg sodium?', 'answer' => '5.8 g salt.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['tsp' => 'Teaspoons of salt', 'g' => 'Grams of salt', 'sodium_mg' => 'Milligrams of sodium']" selected="tsp" />
    </div>

    <x-calc.result label="Sodium" />

    <x-calc.options :decimals="false" :examples="[
        '1 tsp' => ['amount' => 1, 'unit' => 'tsp'],
        '2,300 mg' => ['amount' => 2300, 'unit' => 'sodium_mg'],
        '5 g' => ['amount' => 5, 'unit' => 'g'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fda' => ['label' => 'FDA daily value'],
            'who' => ['label' => 'WHO'],
            'tsp' => ['label' => 'Teaspoons'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sodium = salt × 0.393</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
