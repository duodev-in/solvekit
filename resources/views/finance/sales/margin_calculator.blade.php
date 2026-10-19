<x-calc.page
    title="Margin Calculator - SolveKit"
    description="Free margin calculator: gross margin, markup and profit from cost and price, or the price for a target margin, or the most you can pay for a margin."
    lede="Work out margin, markup and price."
    about="Margin = (price − cost) ÷ price; markup = (price − cost) ÷ cost. Price for a target margin = cost ÷ (1 − margin). A 25% margin is a 33.3% markup. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'margin', 'fields' => ['mode', 'cost', 'price', 'margin']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => ''],
        ['name' => 'Enter the values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the margin on an item costing $60 sold for $100?', 'answer' => '40%; markup 66.67%.'],
        ['question' => 'What price gives a 40% margin on $60?', 'answer' => '$100.00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="I know" :options="['cost_price' => 'Cost and price', 'cost_margin' => 'Cost and margin', 'price_margin' => 'Price and margin']" selected="cost_price" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cost" label="Cost" value="60" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Price" value="100" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Margin" value="40" step="any" suffix="%" />
    </div>

    <x-calc.result label="Gross margin" />

    <x-calc.options :decimals="false" :examples="[
        'Cost and price' => ['mode' => 'cost_price', 'cost' => 60, 'price' => 100, 'margin' => ''],
        'Cost and margin' => ['mode' => 'cost_margin', 'cost' => 60, 'price' => '', 'margin' => 40],
        'Price and margin' => ['mode' => 'price_margin', 'cost' => '', 'price' => 100, 'margin' => 35],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'margin' => ['label' => 'Margin'],
            'markup' => ['label' => 'Markup'],
            'profit' => ['label' => 'Profit'],
            'price' => ['label' => 'Price'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>margin = (P − C) ÷ P</li>
            <li>P = C ÷ (1 − m)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
