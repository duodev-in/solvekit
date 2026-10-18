<x-calc.page
    title="Unit Price Calculator - SolveKit"
    description="Free unit price calculator: compare products by price per ounce, gram, liter or item to find the best value."
    lede="Find which pack size is the best value."
    about="Unit price = price ÷ quantity, in the same unit for every product (all ounces, or all grams). The lowest unit price is the best value, as long as you will use it all before it spoils."
    :calc="['engine' => 'ev-home', 'tool' => 'unit_price', 'fields' => ['products', 'unit_name', 'per']]"
    :how-to="[
        ['name' => 'List the products', 'text' => 'Price and quantity in one unit.'],
        ['name' => 'Choose how to show prices', 'text' => 'Per 1 oz, per 100 g…'],
    ]"
    :faqs="[
        ['question' => 'How do I compare unit prices?', 'answer' => 'Divide each price by its quantity in the same unit.'],
        ['question' => 'Is the bigger pack always cheaper?', 'answer' => 'Often but not always; check.'],
        ['question' => 'What if one is in grams?', 'answer' => 'Convert first: 1 oz = 28.35 g.'],
    ]"
>
    <x-calc.rows-editor name="products" label="Products" :columns="['name' => 'Product', 'price' => 'Price $', 'qty' => 'Quantity']" :rows="[['Small (12 oz)', 3.49, 12], ['Medium (24 oz)', 5.99, 24], ['Family (48 oz)', 10.49, 48]]" add-label="Add product" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="unit_name" label="Unit" value="oz" type="text" placeholder="oz, g, L, items" />
        <x-calc.field name="per" label="Show price per" value="1" min="0.001" step="any" />
    </div>

    <x-calc.result label="Best value" />

    <x-calc.options :examples="[
        'Cereal sizes' => ['products' => 'Small (12 oz)	3.49	12
Medium (24 oz)	5.99	24
Family (48 oz)	10.49	48', 'unit_name' => 'oz', 'per' => 1],
        'Detergent per 100 loads' => ['products' => 'Brand A, 64 loads	12.99	64
Brand B, 110 loads	19.99	110', 'unit_name' => 'loads', 'per' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'saving' => ['label' => 'Saving'],
        ]" />
        <x-calc.quick-ref heading="Each product" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>unit price = price ÷ quantity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
