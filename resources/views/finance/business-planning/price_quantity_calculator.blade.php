<x-calc.page
    title="Price / Quantity Calculator - SolveKit"
    description="Free Price / Quantity Calculator: revenue = price × quantity. Total revenue is price times quantity sold."
    lede="Work out the total revenue from price per unit and quantity."
    about="Total revenue is price times quantity sold. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_quantity', 'fields' => ['price', 'quantity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price per unit, Quantity.'],
        ['name' => 'Read the result', 'text' => 'The total revenue appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the total revenue?', 'answer' => 'Revenue = price × quantity.'],
        ['question' => 'What is the total revenue for price per unit $12.50, quantity 400?', 'answer' => '$5,000.00.'],
        ['question' => 'And for price per unit $3.25, quantity 1,800?', 'answer' => '$5,850.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Raising price raises revenue only if quantity falls by a smaller percentage.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price per unit" value="12.5" step="0.01" suffix="$" />
        <x-calc.field name="quantity" label="Quantity" value="400" step="any" />
    </div>

    <x-calc.result label="Total revenue" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 12.5, 'quantity' => 400],
        'Example B' => ['price' => 3.25, 'quantity' => 1800],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>revenue = price × quantity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
