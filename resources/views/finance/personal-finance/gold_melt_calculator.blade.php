<x-calc.page
    title="Gold Melt Calculator - SolveKit"
    description="Free Gold Melt Calculator: value = grams × purity ÷ 31.1035 × spot price. Melt value is the gold content at the spot price; buyers usually pay less."
    lede="Work out the melt value from your figures."
    about="Melt value is the gold content at the spot price; buyers usually pay less. Enter today's spot price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gold_melt', 'fields' => ['weight', 'unit', 'purity', 'spot']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Weight, Weight unit, Purity (karat ÷ 24, or fineness), Gold spot price per troy ounce.'],
        ['name' => 'Read the result', 'text' => 'The melt value appears as you type, with pure gold below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the melt value?', 'answer' => 'Value = grams × purity ÷ 31.1035 × spot price.'],
        ['question' => 'What is the melt value for weight 10, weight unit grams, purity 58.33%, gold spot price per troy ounce $4,000?', 'answer' => '$750.14. Pure gold: 5.833.'],
        ['question' => 'And for weight 1, weight unit troy ounces, purity 91.67%, gold spot price per troy ounce $4,000?', 'answer' => '$3,666.80. Pure gold: 28.51.'],
        ['question' => 'What does the result tell me?', 'answer' => '14 karat is 58.33% gold, 18 karat 75%, 24 karat 99.9%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="10" step="any" />
        <x-calc.select name="unit" label="Weight unit" :options="['1' => 'Grams', '31.1034768' => 'Troy ounces', '28.349523125' => 'Ounces']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="purity" label="Purity (karat ÷ 24, or fineness)" value="58.33" step="any" suffix="%" />
        <x-calc.field name="spot" label="Gold spot price per troy ounce" value="4000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Melt value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['weight' => 10, 'unit' => '1', 'purity' => 58.33, 'spot' => 4000],
        'Example B' => ['weight' => 1, 'unit' => '31.1034768', 'purity' => 91.67, 'spot' => 4000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Pure gold'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = grams × purity ÷ 31.1035 × spot price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
