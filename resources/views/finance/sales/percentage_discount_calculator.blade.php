<x-calc.page
    title="Percentage Discount Calculator - SolveKit"
    description="Free Percentage Discount Calculator: discount % = (original − sale) ÷ original. Finds the percentage off from the two prices."
    lede="Work out the discount from original price and sale price."
    about="Finds the percentage off from the two prices. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'percentage_discount', 'fields' => ['original', 'sale']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Original price, Sale price.'],
        ['name' => 'Read the result', 'text' => 'The discount appears as you type, with saved below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the discount?', 'answer' => 'Discount % = (original − sale) ÷ original.'],
        ['question' => 'What is the discount for original price $80, sale price $60?', 'answer' => '25%. Saved: $20.00.'],
        ['question' => 'And for original price $349, sale price $279?', 'answer' => '20.06%. Saved: $70.00.'],
        ['question' => 'What does the result tell me?', 'answer' => '$80 down to $60 is 25% off.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="original" label="Original price" value="80" step="0.01" suffix="$" />
        <x-calc.field name="sale" label="Sale price" value="60" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Discount" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['original' => 80, 'sale' => 60],
        'Example B' => ['original' => 349, 'sale' => 279],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Saved'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>discount % = (original − sale) ÷ original</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
