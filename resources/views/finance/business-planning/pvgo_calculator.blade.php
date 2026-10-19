<x-calc.page
    title="PVGO Calculator - SolveKit"
    description="Free PVGO calculator: present value of growth opportunities, the part of a share price above the value of its current earnings as a perpetuity."
    lede="Find how much of a share price is for growth."
    about="PVGO = price − EPS ÷ cost of equity. EPS ÷ r is what the share would be worth if earnings never grew and were all paid out. A large PVGO means the market is paying for future growth. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'pvgo', 'fields' => ['price', 'eps', 'rate']]"
    :how-to="[
        ['name' => 'Enter price and EPS', 'text' => ''],
        ['name' => 'Enter the cost of equity', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much of a $120 share with $5 EPS is growth at 9%?', 'answer' => '$64.44 (53.7%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Share price" value="120" step="0.01" suffix="$" />
        <x-calc.field name="eps" label="Earnings per share" value="5" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Cost of equity" value="9" step="any" suffix="%" />
    </div>

    <x-calc.result label="Present value of growth opportunities" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 120, 'eps' => 5, 'rate' => 9],
        'Value stock' => ['price' => 60, 'eps' => 6, 'rate' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'nogrowth' => ['label' => 'Value with no growth'],
            'share' => ['label' => 'Growth share of price'],
            'pe' => ['label' => 'P/E'],
            'nogrowthPe' => ['label' => 'No-growth P/E'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PVGO = P − EPS ÷ r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
