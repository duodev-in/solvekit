<x-calc.page
    title="Altman Z-Score Calculator - SolveKit"
    description="Free Altman Z-score calculator: bankruptcy risk score for public manufacturers (Z), private companies (Z') and non-manufacturers (Z''), with zones."
    lede="Score a company's bankruptcy risk."
    about="Original Z = 1.2A + 1.4B + 3.3C + 0.6D + 1.0E with A = working capital ÷ assets, B = retained earnings ÷ assets, C = EBIT ÷ assets, D = market equity ÷ liabilities, E = sales ÷ assets. Z' uses book equity; Z'' drops sales for non-manufacturers. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'altman', 'fields' => ['model', 'wc', 're', 'ebit', 'equity', 'sales', 'assets', 'liabilities']]"
    :how-to="[
        ['name' => 'Choose the model', 'text' => ''],
        ['name' => 'Enter the figures', 'text' => 'From the latest statements.'],
    ]"
    :faqs="[
        ['question' => 'What is the Z-score of the example company?', 'answer' => '2.936: Grey zone.'],
    ]"
>
    <x-calc.select name="model" label="Model" :options="['public' => 'Original Z (public manufacturer)', 'private' => 'Z\' (private manufacturer)', 'nonmfg' => 'Z\'\' (non-manufacturer)']" selected="public" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wc" label="Working capital" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="re" label="Retained earnings" value="400000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebit" label="EBIT" value="180000" step="0.01" suffix="$" />
        <x-calc.field name="equity" label="Equity (market or book)" value="900000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sales" label="Sales" value="1600000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Total assets" value="1500000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="liabilities" label="Total liabilities" value="600000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Altman Z-score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['model' => 'public', 'wc' => 250000, 're' => 400000, 'ebit' => 180000, 'equity' => 900000, 'sales' => 1600000, 'assets' => 1500000, 'liabilities' => 600000],
        'Struggling' => ['model' => 'public', 'wc' => -50000, 're' => -100000, 'ebit' => 20000, 'equity' => 200000, 'sales' => 900000, 'assets' => 1200000, 'liabilities' => 1000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'model' => ['label' => 'Model'],
            'zones' => ['label' => 'Zones'],
            'ratios' => ['label' => 'Ratios'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Z = 1.2A + 1.4B + 3.3C + 0.6D + 1.0E</li>
            <li>Z' = 0.717A + 0.847B + 3.107C + 0.420D + 0.998E</li>
            <li>Z'' = 6.56A + 3.26B + 6.72C + 1.05D</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
