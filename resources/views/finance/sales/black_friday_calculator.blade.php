<x-calc.page
    title="Black Friday Calculator - SolveKit"
    description="Free Black Friday calculator: total price and savings across several items with sale discounts, extra stacked discounts, a coupon and sales tax."
    lede="Add up your Black Friday deals."
    about="Each item's price = list price × (1 − sale %) × (1 − extra %) × quantity; stacked discounts multiply, so 30% then 20% is 44% off, not 50%. A coupon comes off the subtotal, then sales tax is added. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'stacked_discounts', 'fields' => ['items', 'coupon', 'tax']]"
    :how-to="[
        ['name' => 'Add items', 'text' => 'Price, discounts and quantity.'],
        ['name' => 'Add a coupon and tax', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do the example deals cost?', 'answer' => '$855.10, saving $476.24.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Items" :columns="['name' => 'Item', 'price' => 'Price', 'off' => 'Sale %', 'extra' => 'Extra %', 'qty' => 'Qty']" :rows="[['TV', 899, 30, 0, 1], ['Headphones', 249, 40, 10, 1], ['Sweater', 60, 50, 20, 2]]" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Coupon" value="20" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Sales tax" value="8" step="any" suffix="%" />
    </div>

    <x-calc.result label="You pay" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 'TV	899	30	0	1
Headphones	249	40	10	1
Sweater	60	50	20	2', 'coupon' => 20, 'tax' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'list' => ['label' => 'List price'],
            'saved' => ['label' => 'Saved'],
            'tax' => ['label' => 'Sales tax'],
            'coupon' => ['label' => 'Coupon'],
        ]" />
        <x-calc.quick-ref heading="Items" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>item = price × (1 − d₁)(1 − d₂) × qty</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
