<x-calc.page
    title="Cyber Monday Calculator - SolveKit"
    description="Free Cyber Monday calculator: total cost and savings on online deals with stacked discounts, coupons and sales tax."
    lede="Add up your Cyber Monday deals."
    about="Stacked discounts multiply: price × (1 − first %) × (1 − second %). Online orders usually include sales tax where you live; free shipping thresholds can change which deal is best. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'stacked_discounts', 'fields' => ['items', 'coupon', 'tax']]"
    :how-to="[
        ['name' => 'Add items', 'text' => ''],
        ['name' => 'Add tax', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do the example deals cost?', 'answer' => '$1,080.62.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Items" :columns="['name' => 'Item', 'price' => 'Price', 'off' => 'Sale %', 'extra' => 'Extra %', 'qty' => 'Qty']" :rows="[['Laptop', 1199, 25, 0, 1], ['Mouse', 49, 30, 0, 2], ['Software', 99, 50, 15, 1]]" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Coupon" value="0" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Sales tax" value="7" step="any" suffix="%" />
    </div>

    <x-calc.result label="You pay" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 'Laptop	1199	25	0	1
Mouse	49	30	0	2
Software	99	50	15	1', 'coupon' => 0, 'tax' => 7],
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
