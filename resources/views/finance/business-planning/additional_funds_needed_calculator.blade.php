<x-calc.page
    title="Additional Funds Needed Calculator - SolveKit"
    description="Free AFN calculator: external financing needed for sales growth from assets and spontaneous liabilities tied to sales, profit margin and payout ratio."
    lede="Find the outside funding growth requires."
    about="AFN = (A*/S₀)ΔS − (L*/S₀)ΔS − M × S₁ × (1 − payout), where A* are assets that grow with sales, L* spontaneous liabilities (payables, accruals), M the profit margin and S₁ next year's sales. A positive AFN must come from new debt or equity. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'afn', 'fields' => ['sales', 'next', 'assets', 'liabilities', 'margin', 'payout']]"
    :how-to="[
        ['name' => 'Enter sales now and projected', 'text' => ''],
        ['name' => 'Enter balance sheet ratios and payout', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much funding does growing from $5M to $6M need?', 'answer' => '$320,000.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sales" label="Current sales" value="5000000" step="0.01" suffix="$" />
        <x-calc.field name="next" label="Projected sales" value="6000000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Assets tied to sales" value="3000000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="liabilities" label="Spontaneous liabilities" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Profit margin" value="5" step="any" suffix="%" />
        <x-calc.field name="payout" label="Dividend payout ratio" value="40" step="any" suffix="%" />
    </div>

    <x-calc.result label="Additional funds needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sales' => 5000000, 'next' => 6000000, 'assets' => 3000000, 'liabilities' => 500000, 'margin' => 5, 'payout' => 40],
        'Slow growth' => ['sales' => 5000000, 'next' => 5300000, 'assets' => 3000000, 'liabilities' => 500000, 'margin' => 8, 'payout' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'assets' => ['label' => 'New assets needed'],
            'liabilities' => ['label' => 'From spontaneous liabilities'],
            'retained' => ['label' => 'From retained earnings'],
            'growth' => ['label' => 'Sales growth'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AFN = (A/S)ΔS − (L/S)ΔS − M S₁ (1 − d)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
