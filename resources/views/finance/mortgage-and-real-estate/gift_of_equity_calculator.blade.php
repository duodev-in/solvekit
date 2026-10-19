<x-calc.page
    title="Gift of Equity Calculator - SolveKit"
    description="Free Gift of Equity Calculator: gift = appraised value − sale price. A gift of equity is a below-market sale to a relative; lenders can count it toward the down payment."
    lede="Work out the gift of equity from appraised value and sale price to the family member."
    about="A gift of equity is a below-market sale to a relative; lenders can count it toward the down payment. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gift_of_equity', 'fields' => ['value', 'price']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Appraised value, Sale price to the family member.'],
        ['name' => 'Read the result', 'text' => 'The gift of equity appears as you type, with as % of value (counts as down payment) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the gift of equity?', 'answer' => 'Gift = appraised value − sale price.'],
        ['question' => 'What is the gift of equity for appraised value $350,000, sale price to the family member $280,000?', 'answer' => '$70,000.00. As % of value (counts as down payment): 20%.'],
        ['question' => 'And for appraised value $500,000, sale price to the family member $425,000?', 'answer' => '$75,000.00. As % of value (counts as down payment): 15%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Gifts above the IRS annual exclusion may need a gift tax return (Form 709).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Appraised value" value="350000" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Sale price to the family member" value="280000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Gift of equity" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['value' => 350000, 'price' => 280000],
        'Example B' => ['value' => 500000, 'price' => 425000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'As % of value (counts as down payment)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gift = appraised value − sale price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
