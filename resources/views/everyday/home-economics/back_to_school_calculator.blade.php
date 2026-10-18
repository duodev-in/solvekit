<x-calc.page
    title="Back to School Calculator - SolveKit"
    description="Free back to school calculator: the cost of school supplies, clothes and fees for one child or several, with sales tax and discounts."
    lede="Budget for back-to-school shopping."
    about="Total = Σ quantity × price, less discounts, plus sales tax, multiplied by the number of children with the same list. Edit the example list to match your school's supply list."
    :calc="['engine' => 'ev-home', 'tool' => 'shopping_list', 'fields' => ['items', 'people', 'tax', 'coupons']]"
    :how-to="[
        ['name' => 'List the supplies', 'text' => 'Quantity and price.'],
        ['name' => 'Enter children, tax and discounts', 'text' => 'For the total.'],
    ]"
    :faqs="[
        ['question' => 'How much does back to school cost?', 'answer' => 'It depends on the list; enter yours for a real figure.'],
        ['question' => 'Is tax included?', 'answer' => 'Yes, at the rate you enter (some states have tax-free weekends).'],
        ['question' => 'Can I budget for several children?', 'answer' => 'Yes, set the number of children.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Shopping list (per child)" :columns="['name' => 'Item', 'qty' => 'Qty', 'price' => 'Price $']" :rows="[['Backpack', 1, 35], ['Notebooks', 6, 1.5], ['Pencils (pack)', 2, 3], ['Calculator', 1, 15], ['Shoes', 1, 50]]" add-label="Add item" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="people" label="Children" value="2" min="1" step="1" />
        <x-calc.field name="tax" label="Sales tax" value="7" min="0" max="30" step="0.1" suffix="%" />
        <x-calc.field name="coupons" label="Discounts (per child)" value="10" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Total" />

    <x-calc.options :decimals="false" :examples="[
        '2 children' => ['items' => 'Backpack	1	35
Notebooks	6	1.5
Pencils (pack)	2	3
Calculator	1	15
Shoes	1	50', 'people' => 2, 'tax' => 7, 'coupons' => 10],
        'College' => ['items' => 'Laptop	1	700
Textbooks	4	85
Bedding	1	60', 'people' => 1, 'tax' => 6, 'coupons' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'subtotal' => ['label' => 'Subtotal per child'],
            'tax' => ['label' => 'Tax per child'],
            'each' => ['label' => 'Per child'],
            'items' => ['label' => 'Items'],
        ]" />
        <x-calc.quick-ref heading="Items" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = (Σ qty × price − discounts) × (1 + tax) × children</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
