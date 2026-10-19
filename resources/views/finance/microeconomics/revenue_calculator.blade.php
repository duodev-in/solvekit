<x-calc.page
    title="Revenue Calculator - SolveKit"
    description="Free Revenue Calculator: revenue = price × units. Revenue (sales) is price times quantity."
    lede="Work out the revenue from average price and units sold."
    about="Revenue (sales) is price times quantity. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'revenue', 'fields' => ['price', 'units']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Average price, Units sold.'],
        ['name' => 'Read the result', 'text' => 'The revenue appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the revenue?', 'answer' => 'Revenue = price × units.'],
        ['question' => 'What is the revenue for average price $25, units sold 4,000?', 'answer' => '$100,000.00.'],
        ['question' => 'And for average price $8.99, units sold 1,350?', 'answer' => '$12,136.50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Discounts and returns reduce net revenue.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Average price" value="25" step="0.01" suffix="$" />
        <x-calc.field name="units" label="Units sold" value="4000" step="any" />
    </div>

    <x-calc.result label="Revenue" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 25, 'units' => 4000],
        'Example B' => ['price' => 8.99, 'units' => 1350],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>revenue = price × units</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
