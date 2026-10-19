<x-calc.page
    title="Lemonade Stand Calculator - SolveKit"
    description="Free Lemonade Stand Calculator: profit = cups × (price − cost per cup) − fixed costs. A lemonade stand is a first lesson in business: revenue, costs and break-even."
    lede="Work out the profit from your figures."
    about="A lemonade stand is a first lesson in business: revenue, costs and break-even. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'lemonade_stand', 'fields' => ['cups', 'price', 'cost', 'fixed']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cups sold, Price per cup, Cost per cup (lemons, sugar, cup), Fixed costs (table, sign).'],
        ['name' => 'Read the result', 'text' => 'The profit appears as you type, with revenue, break-even cups below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the profit?', 'answer' => 'Profit = cups × (price − cost per cup) − fixed costs.'],
        ['question' => 'What is the profit for cups sold 120, price per cup $1, cost per cup $0.35, fixed costs $15?', 'answer' => '$63.00. Revenue: $120.00.'],
        ['question' => 'And for cups sold 60, price per cup $0.75, cost per cup $0.30, fixed costs $5?', 'answer' => '$22.00. Revenue: $45.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Break-even is fixed costs ÷ profit per cup.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cups" label="Cups sold" value="120" min="0" step="1" />
        <x-calc.field name="price" label="Price per cup" value="1" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost" label="Cost per cup (lemons, sugar, cup)" value="0.35" step="0.01" suffix="$" />
        <x-calc.field name="fixed" label="Fixed costs (table, sign)" value="15" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Profit" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cups' => 120, 'price' => 1, 'cost' => 0.35, 'fixed' => 15],
        'Example B' => ['cups' => 60, 'price' => 0.75, 'cost' => 0.3, 'fixed' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Revenue'],
            'r2' => ['label' => 'Break-even cups'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>profit = cups × (price − cost per cup) − fixed costs</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
