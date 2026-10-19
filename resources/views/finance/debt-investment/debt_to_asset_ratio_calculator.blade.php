<x-calc.page
    title="Debt to Asset Ratio Calculator - SolveKit"
    description="Free Debt to Asset Ratio Calculator: ratio = total debt ÷ total assets. The share of assets financed by debt."
    lede="Work out the debt to assets from total debt (or liabilities) and total assets."
    about="The share of assets financed by debt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'debt_to_asset_ratio', 'fields' => ['debt', 'assets']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total debt (or liabilities), Total assets.'],
        ['name' => 'Read the result', 'text' => 'The debt to assets appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the debt to assets?', 'answer' => 'Ratio = total debt ÷ total assets.'],
        ['question' => 'What is the debt to assets for total debt $400,000, total assets $1,000,000?', 'answer' => '40%.'],
        ['question' => 'And for total debt $650,000, total assets $900,000?', 'answer' => '72.22%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Higher means more financial risk.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="debt" label="Total debt (or liabilities)" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Total assets" value="1000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Debt to assets" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['debt' => 400000, 'assets' => 1000000],
        'Example B' => ['debt' => 650000, 'assets' => 900000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = total debt ÷ total assets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
