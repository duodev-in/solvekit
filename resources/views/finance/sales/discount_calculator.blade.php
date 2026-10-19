<x-calc.page
    title="Discount Calculator - SolveKit"
    description="Free Discount Calculator: sale price = price × (1 − discount). The price after a percentage discount."
    lede="Work out the sale price from original price and discount."
    about="The price after a percentage discount. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'discount', 'fields' => ['price', 'discount']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Original price, Discount.'],
        ['name' => 'Read the result', 'text' => 'The sale price appears as you type, with you save below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the sale price?', 'answer' => 'Sale price = price × (1 − discount).'],
        ['question' => 'What is the sale price for original price $80, discount 25%?', 'answer' => '$60.00. You save: $20.00.'],
        ['question' => 'And for original price $1,299, discount 15%?', 'answer' => '$1,104.15. You save: $194.85.'],
        ['question' => 'What does the result tell me?', 'answer' => '25% off $80 saves $20.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Original price" value="80" step="0.01" suffix="$" />
        <x-calc.field name="discount" label="Discount" value="25" step="any" suffix="%" />
    </div>

    <x-calc.result label="Sale price" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 80, 'discount' => 25],
        'Example B' => ['price' => 1299, 'discount' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'You save'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sale price = price × (1 − discount)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
