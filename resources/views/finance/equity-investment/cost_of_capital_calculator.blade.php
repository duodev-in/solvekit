<x-calc.page
    title="Cost of Capital Calculator - SolveKit"
    description="Free cost of capital calculator: a company's blended cost of equity and after-tax debt (WACC)."
    lede="Find the cost of capital."
    about="A company's cost of capital is the return investors require across all its financing: the weighted average of the cost of equity and the after-tax cost of debt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'wacc', 'fields' => ['equity', 'debt', 're', 'rd', 'tax']]"
    :how-to="[
        ['name' => 'Enter equity and debt', 'text' => ''],
        ['name' => 'Enter their costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the cost of capital with $3M equity at 12% and $1M debt at 7%?', 'answer' => '10.31%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="equity" label="Equity value" value="3000000" step="0.01" suffix="$" />
        <x-calc.field name="debt" label="Debt value" value="1000000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="re" label="Cost of equity" value="12" step="any" suffix="%" />
        <x-calc.field name="rd" label="Interest rate on debt" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Tax rate" value="25" step="any" suffix="%" />
    </div>

    <x-calc.result label="WACC" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['equity' => 3000000, 'debt' => 1000000, 're' => 12, 'rd' => 7, 'tax' => 25],
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
            <li>k = E/V Rₑ + D/V R_d (1 − t)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
