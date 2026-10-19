<x-calc.page
    title="DuPont Analysis Calculator - SolveKit"
    description="Free DuPont analysis calculator: return on equity split into profit margin, asset turnover and financial leverage, with the 5-step version."
    lede="Break down ROE with DuPont analysis."
    about="ROE = net margin × asset turnover × equity multiplier = (NI ÷ sales) × (sales ÷ assets) × (assets ÷ equity). The 5-step version splits the margin into tax burden (NI ÷ EBT), interest burden (EBT ÷ EBIT) and EBIT margin. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'dupont', 'fields' => ['income', 'revenue', 'assets', 'equity', 'ebt', 'ebit']]"
    :how-to="[
        ['name' => 'Enter income statement figures', 'text' => ''],
        ['name' => 'Enter balance sheet averages', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What drives a 30% ROE with an 8% margin?', 'answer' => 'Turnover 1.5× and leverage 2.5×.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="Net income" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="revenue" label="Revenue" value="1500000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Average total assets" value="1000000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="equity" label="Average equity" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="ebt" label="EBT (optional)" value="160000" step="0.01" suffix="$" />
        <x-calc.field name="ebit" label="EBIT (optional)" value="200000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Return on equity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['income' => 120000, 'revenue' => 1500000, 'assets' => 1000000, 'equity' => 400000, 'ebt' => 160000, 'ebit' => 200000],
        'Retailer' => ['income' => 50000, 'revenue' => 2500000, 'assets' => 900000, 'equity' => 450000, 'ebt' => '', 'ebit' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'margin' => ['label' => 'Net margin'],
            'turnover' => ['label' => 'Asset turnover'],
            'leverage' => ['label' => 'Equity multiplier'],
            'five' => ['label' => '5-step'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROE = NI/S × S/A × A/E</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
