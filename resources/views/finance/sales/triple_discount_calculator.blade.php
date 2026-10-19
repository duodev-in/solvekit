<x-calc.page
    title="Triple Discount Calculator - SolveKit"
    description="Free Triple Discount Calculator: final = price × (1 − d₁)(1 − d₂)(1 − d₃). Three successive discounts multiply together."
    lede="Work out the final price from your figures."
    about="Three successive discounts multiply together. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'triple_discount', 'fields' => ['price', 'd1', 'd2', 'd3']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Original price, First discount, Second discount, Third discount.'],
        ['name' => 'Read the result', 'text' => 'The final price appears as you type, with total discount below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the final price?', 'answer' => 'Final = price × (1 − d₁)(1 − d₂)(1 − d₃).'],
        ['question' => 'What is the final price for original price $100, first discount 20%, second discount 10%, third discount 5%?', 'answer' => '$68.40. Total discount: 31.6%.'],
        ['question' => 'And for original price $480, first discount 25%, second discount 10%, third discount 10%?', 'answer' => '$291.60. Total discount: 39.25%.'],
        ['question' => 'What does the result tell me?', 'answer' => '20%, 10% and 5% off is 31.6% off in total.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Original price" value="100" step="0.01" suffix="$" />
        <x-calc.field name="d1" label="First discount" value="20" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d2" label="Second discount" value="10" step="any" suffix="%" />
        <x-calc.field name="d3" label="Third discount" value="5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Final price" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 100, 'd1' => 20, 'd2' => 10, 'd3' => 5],
        'Example B' => ['price' => 480, 'd1' => 25, 'd2' => 10, 'd3' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total discount'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>final = price × (1 − d₁)(1 − d₂)(1 − d₃)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
