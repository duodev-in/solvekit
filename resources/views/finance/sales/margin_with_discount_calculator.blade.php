<x-calc.page
    title="Margin With Discount Calculator - SolveKit"
    description="Free Margin With Discount Calculator: margin = (price × (1 − d) − cost) ÷ (price × (1 − d)). Discounts come straight out of margin."
    lede="Work out the margin after the discount from list price, cost and discount."
    about="Discounts come straight out of margin. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_with_discount', 'fields' => ['price', 'cost', 'discount']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'List price, Cost, Discount.'],
        ['name' => 'Read the result', 'text' => 'The margin after the discount appears as you type, with margin before, profit after the discount below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the margin after the discount?', 'answer' => 'Margin = (price × (1 − d) − cost) ÷ (price × (1 − d)).'],
        ['question' => 'What is the margin after the discount for list price $100, cost $60, discount 15%?', 'answer' => '29.41%. Margin before: 40%.'],
        ['question' => 'And for list price $45, cost $30, discount 20%?', 'answer' => '16.67%. Margin before: 33.33%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 15% discount on a 40% margin item leaves 29.4%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="List price" value="100" step="0.01" suffix="$" />
        <x-calc.field name="cost" label="Cost" value="60" step="0.01" suffix="$" />
        <x-calc.field name="discount" label="Discount" value="15" step="any" suffix="%" />
    </div>

    <x-calc.result label="Margin after the discount" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 100, 'cost' => 60, 'discount' => 15],
        'Example B' => ['price' => 45, 'cost' => 30, 'discount' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Margin before'],
            'r2' => ['label' => 'Profit after the discount'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>margin = (price × (1 − d) − cost) ÷ (price × (1 − d))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
