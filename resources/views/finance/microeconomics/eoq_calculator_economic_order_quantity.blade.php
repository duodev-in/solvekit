<x-calc.page
    title="EOQ Calculator (Economic Order Quantity) - SolveKit"
    description="Free EOQ calculator: economic order quantity that minimizes ordering and holding costs, orders per year, cycle time and total cost."
    lede="Find the economic order quantity."
    about="EOQ = √(2DS ÷ H), where D is annual demand, S the cost per order and H the holding cost per unit per year. At the EOQ, yearly ordering cost equals yearly holding cost. It assumes steady demand and no quantity discounts. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'eoq', 'fields' => ['demand', 'order_cost', 'holding', 'lead']]"
    :how-to="[
        ['name' => 'Enter demand and costs', 'text' => ''],
        ['name' => 'Read the order size', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the EOQ for 12,000 units a year at $75 an order and $3 holding?', 'answer' => '774.6 units.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="demand" label="Annual demand (units)" value="12000" min="0" step="1" />
        <x-calc.field name="order_cost" label="Cost per order" value="75" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="holding" label="Holding cost per unit a year" value="3" step="0.01" suffix="$" />
        <x-calc.field name="lead" label="Lead time (optional)" value="10" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Economic order quantity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['demand' => 12000, 'order_cost' => 75, 'holding' => 3, 'lead' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'orders' => ['label' => 'Orders a year'],
            'cycle' => ['label' => 'Order cycle'],
            'cost' => ['label' => 'Ordering + holding cost'],
            'rop' => ['label' => 'Reorder point'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EOQ = √(2DS ÷ H)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
