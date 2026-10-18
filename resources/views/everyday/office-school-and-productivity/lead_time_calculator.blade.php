<x-calc.page
    title="Lead Time Calculator - SolveKit"
    description="Free lead time calculator: lead time from order and delivery dates or from supplier, transit and receiving times, and the inventory reorder point."
    lede="Work out lead time and when to reorder."
    about="Lead time is the time from placing an order to having it ready to use. The reorder point = daily demand × lead time + safety stock: when stock falls to this level, order again so it arrives before you run out."
    :calc="['engine' => 'ev-office', 'tool' => 'lead_time', 'fields' => ['mode', 'order', 'delivery', 'business', 'supplier', 'transit', 'receiving', 'demand', 'safety']]"
    :how-to="[
        ['name' => 'Enter the dates or stages', 'text' => 'For past orders or planning.'],
        ['name' => 'Add demand and safety stock', 'text' => 'For the reorder point.'],
    ]"
    :faqs="[
        ['question' => 'What is lead time?', 'answer' => 'The time from order to having the goods ready to use.'],
        ['question' => 'How do I calculate a reorder point?', 'answer' => 'Daily demand × lead time + safety stock: 20 × 14 + 60 = 340 units.'],
        ['question' => 'Business or calendar days?', 'answer' => 'Use what your supplier quotes.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['dates' => 'Order and delivery dates', 'stages' => 'Stages']" selected="dates" />

    <div data-show-when="mode:dates">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="order" label="Order date" value="2026-10-01" type="date" />
            <x-calc.field name="delivery" label="Delivered" value="2026-10-15" type="date" />
        </div>
    </div>

    <div data-show-when="mode:dates">
        <x-calc.checkbox name="business" label="Count business days only" :checked="false" />
    </div>

    <div data-show-when="mode:stages" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="supplier" label="Supplier processing" value="5" min="0" suffix="days" />
            <x-calc.field name="transit" label="Transit" value="7" min="0" suffix="days" />
            <x-calc.field name="receiving" label="Receiving and inspection" value="1" min="0" suffix="days" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="demand" label="Daily demand (optional)" value="20" min="0" suffix="units" />
        <x-calc.field name="safety" label="Safety stock" value="60" min="0" suffix="units" />
    </div>

    <x-calc.result label="Lead time" />

    <x-calc.options :examples="[
        'Order 1 → 15 Oct' => ['mode' => 'dates', 'order' => '2026-10-01', 'delivery' => '2026-10-15', 'business' => false, 'supplier' => '', 'transit' => '', 'receiving' => '', 'demand' => 20, 'safety' => 60],
        'Business days' => ['mode' => 'dates', 'order' => '2026-10-01', 'delivery' => '2026-10-15', 'business' => true, 'supplier' => '', 'transit' => '', 'receiving' => '', 'demand' => 20, 'safety' => 60],
        'By stage' => ['mode' => 'stages', 'order' => '', 'delivery' => '', 'business' => false, 'supplier' => 5, 'transit' => 7, 'receiving' => 1, 'demand' => 35, 'safety' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'weeks' => ['label' => 'In weeks'],
            'reorder' => ['label' => 'Reorder point'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lead time = delivery − order</li>
            <li>reorder point = demand × lead time + safety stock</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
