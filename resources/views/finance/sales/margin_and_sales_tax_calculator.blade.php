<x-calc.page
    title="Margin and Sales Tax Calculator - SolveKit"
    description="Free Margin and Sales Tax Calculator: price = cost ÷ (1 − margin). Sets a price for a target margin, then adds sales tax for the shelf price."
    lede="Work out the price with tax from cost, margin and sales tax."
    about="Sets a price for a target margin, then adds sales tax for the shelf price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_and_sales_tax', 'fields' => ['cost', 'margin', 'tax']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cost, Margin, Sales tax.'],
        ['name' => 'Read the result', 'text' => 'The price with tax appears as you type, with price before tax, sales tax below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price with tax?', 'answer' => 'Price = cost ÷ (1 − margin); with tax × (1 + tax rate).'],
        ['question' => 'What is the price with tax for cost $50, margin 35%, sales tax 8.25%?', 'answer' => '$83.27. Price before tax: $76.92.'],
        ['question' => 'And for cost $22, margin 45%, sales tax 6%?', 'answer' => '$42.40. Price before tax: $40.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Tax is collected for the state; it is not revenue.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cost" label="Cost" value="50" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Margin" value="35" step="any" suffix="%" />
        <x-calc.field name="tax" label="Sales tax" value="8.25" step="any" suffix="%" />
    </div>

    <x-calc.result label="Price with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost' => 50, 'margin' => 35, 'tax' => 8.25],
        'Example B' => ['cost' => 22, 'margin' => 45, 'tax' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Price before tax'],
            'r2' => ['label' => 'Sales tax'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>price = cost ÷ (1 − margin)</li>
            <li>with tax × (1 + tax rate)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
