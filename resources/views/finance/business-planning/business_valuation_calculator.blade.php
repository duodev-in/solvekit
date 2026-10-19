<x-calc.page
    title="Business Valuation Calculator - SolveKit"
    description="Free business valuation calculator: value a small business by earnings multiple, revenue multiple, net assets and discounted cash flow side by side."
    lede="Estimate what a business is worth."
    about="Earnings multiple: SDE or EBITDA × a market multiple (small businesses often 2–5×). Revenue multiple: sales × multiple. Asset approach: assets − liabilities. DCF (Gordon): next year's cash flow ÷ (discount rate − growth). Use the methods that suit the business. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'valuation', 'fields' => ['earnings', 'multiple', 'revenue', 'rev_multiple', 'assets', 'liabilities', 'fcf', 'rate', 'growth']]"
    :how-to="[
        ['name' => 'Enter earnings and multiples', 'text' => ''],
        ['name' => 'Add assets and cash flow', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the example business worth?', 'answer' => '$1,354,412 on average (range $600,000 to $1,817,647).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="earnings" label="SDE or EBITDA" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="multiple" label="Earnings multiple" value="3.5" min="0" step="any" />
        <x-calc.field name="revenue" label="Annual revenue" value="2000000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rev_multiple" label="Revenue multiple" value="0.8" min="0" step="any" />
        <x-calc.field name="assets" label="Assets (fair value)" value="900000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Liabilities" value="300000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fcf" label="Free cash flow" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Discount rate" value="20" step="any" suffix="%" />
        <x-calc.field name="growth" label="Long-run growth" value="3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Average of the methods" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['earnings' => 400000, 'multiple' => 3.5, 'revenue' => 2000000, 'rev_multiple' => 0.8, 'assets' => 900000, 'liabilities' => 300000, 'fcf' => 300000, 'rate' => 20, 'growth' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'low' => ['label' => 'Lowest'],
            'high' => ['label' => 'Highest'],
            'count' => ['label' => 'Methods'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="By method" name="methods" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>earnings × multiple</li>
            <li>revenue × multiple</li>
            <li>assets − liabilities</li>
            <li>FCF(1 + g) ÷ (r − g)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
