<x-calc.page
    title="WACC Calculator (Weighted Average Cost of Capital) - SolveKit"
    description="Free WACC calculator: weighted average cost of capital from the market values and costs of equity and debt, with the interest tax shield."
    lede="Calculate a company's WACC."
    about="WACC = E/V × Rₑ + D/V × R_d × (1 − t), with V = E + D at market values. It is the discount rate for a company's free cash flow to the firm. Interest is tax-deductible, so debt's cost is taken after tax. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'wacc', 'fields' => ['equity', 'debt', 're', 'rd', 'tax']]"
    :how-to="[
        ['name' => 'Enter the capital structure', 'text' => 'At market values.'],
        ['name' => 'Enter costs and tax rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the WACC with 60% equity at 10% and 40% debt at 6%, 21% tax?', 'answer' => '7.896%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="equity" label="Market value of equity" value="600000000" step="0.01" suffix="$" />
        <x-calc.field name="debt" label="Market value of debt" value="400000000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="re" label="Cost of equity" value="10" step="any" suffix="%" />
        <x-calc.field name="rd" label="Cost of debt (pre-tax)" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Tax rate" value="21" step="any" suffix="%" />
    </div>

    <x-calc.result label="WACC" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['equity' => 600000000, 'debt' => 400000000, 're' => 10, 'rd' => 6, 'tax' => 21],
        'All equity' => ['equity' => 500000000, 'debt' => 0, 're' => 9, 'rd' => 5, 'tax' => 21],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'we' => ['label' => 'Equity weight'],
            'wd' => ['label' => 'Debt weight'],
            'rd' => ['label' => 'After-tax cost of debt'],
            'equity' => ['label' => 'Equity part'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>WACC = E/V Rₑ + D/V R_d (1 − t)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
