<x-calc.page
    title="Grocery Calculator - SolveKit"
    description="Free grocery calculator: a shopping list total with quantities, prices, coupons and sales tax."
    lede="Add up your grocery list before you shop."
    about="Total = Σ quantity × price, less coupons, plus sales tax on the rest. Many US states tax groceries at a lower rate or not at all; enter your rate."
    :calc="['engine' => 'ev-home', 'tool' => 'shopping_list', 'fields' => ['items', 'tax', 'coupons']]"
    :how-to="[
        ['name' => 'List your groceries', 'text' => 'Quantity and price.'],
        ['name' => 'Add tax and coupons', 'text' => 'If any.'],
    ]"
    :faqs="[
        ['question' => 'How do I estimate my grocery bill?', 'answer' => 'Add quantity × price for each item, then coupons and tax.'],
        ['question' => 'Are groceries taxed?', 'answer' => 'In many states not, or at a reduced rate.'],
        ['question' => 'Can I save the list?', 'answer' => 'Copy the total; the list stays while the page is open.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Shopping list" :columns="['name' => 'Item', 'qty' => 'Qty', 'price' => 'Price $']" :rows="[['Milk (gallon)', 2, 3.99], ['Bread', 1, 2.79], ['Eggs (dozen)', 1, 3.49], ['Apples (lb)', 3, 1.69], ['Chicken (lb)', 2, 4.99]]" add-label="Add item" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Sales tax" value="0" min="0" max="30" step="0.1" suffix="%" />
        <x-calc.field name="coupons" label="Coupons" value="2" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Total" />

    <x-calc.options :decimals="false" :examples="[
        'Weekly shop' => ['items' => 'Milk (gallon)	2	3.99
Bread	1	2.79
Eggs (dozen)	1	3.49
Apples (lb)	3	1.69
Chicken (lb)	2	4.99', 'tax' => 0, 'coupons' => 2, 'people' => 1],
        'Party snacks, 8% tax' => ['items' => 'Chips	4	3.5
Soda (12-pack)	3	6.99
Pizza	5	11', 'tax' => 8, 'coupons' => 0, 'people' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'subtotal' => ['label' => 'Subtotal'],
            'tax' => ['label' => 'Tax'],
            'each' => ['label' => 'Total'],
            'items' => ['label' => 'Items'],
        ]" />
        <x-calc.quick-ref heading="Items" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = Σ qty × price − coupons + tax</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
