<x-calc.page
    title="Double Discount Calculator - SolveKit"
    description="Free Double Discount Calculator: final = price × (1 − d₁)(1 − d₂). Successive discounts multiply; 20% then 10% is 28% off, not 30%."
    lede="Work out the final price from original price, first discount and second discount."
    about="Successive discounts multiply; 20% then 10% is 28% off, not 30%. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'double_discount', 'fields' => ['price', 'd1', 'd2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Original price, First discount, Second discount.'],
        ['name' => 'Read the result', 'text' => 'The final price appears as you type, with total discount, you save below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the final price?', 'answer' => 'Final = price × (1 − d₁)(1 − d₂).'],
        ['question' => 'What is the final price for original price $100, first discount 20%, second discount 10%?', 'answer' => '$72.00. Total discount: 28%.'],
        ['question' => 'And for original price $250, first discount 30%, second discount 15%?', 'answer' => '$148.75. Total discount: 40.5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The order does not matter.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Original price" value="100" step="0.01" suffix="$" />
        <x-calc.field name="d1" label="First discount" value="20" step="any" suffix="%" />
        <x-calc.field name="d2" label="Second discount" value="10" step="any" suffix="%" />
    </div>

    <x-calc.result label="Final price" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 100, 'd1' => 20, 'd2' => 10],
        'Example B' => ['price' => 250, 'd1' => 30, 'd2' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total discount'],
            'r2' => ['label' => 'You save'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>final = price × (1 − d₁)(1 − d₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
