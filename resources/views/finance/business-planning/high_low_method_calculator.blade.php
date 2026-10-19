<x-calc.page
    title="High-Low Method Calculator - SolveKit"
    description="Free high-low method calculator: split a mixed cost into variable cost per unit and fixed cost from the highest and lowest activity levels."
    lede="Separate fixed and variable costs."
    about="Variable cost per unit = (cost at the highest activity − cost at the lowest) ÷ (highest − lowest activity). Fixed cost = total cost − variable cost × activity. It uses only two points, so outliers can distort it; regression is more robust. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'high_low', 'fields' => ['high_units', 'high_cost', 'low_units', 'low_cost', 'at']]"
    :how-to="[
        ['name' => 'Enter the highest and lowest activity', 'text' => 'With their costs.'],
        ['name' => 'Predict', 'text' => 'Optional.'],
    ]"
    :faqs="[
        ['question' => 'What are the variable and fixed costs from 12,000 units at $58,000 and 7,000 at $43,000?', 'answer' => '$3.00 per unit; fixed $22,000.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="high_units" label="Highest activity (units)" value="12000" min="0" step="1" />
        <x-calc.field name="high_cost" label="Cost at highest" value="58000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="low_units" label="Lowest activity" value="7000" min="0" step="1" />
        <x-calc.field name="low_cost" label="Cost at lowest" value="43000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="at" label="Predict cost at (optional)" value="10000" min="0" step="1" />
    </div>

    <x-calc.result label="Variable cost per unit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['high_units' => 12000, 'high_cost' => 58000, 'low_units' => 7000, 'low_cost' => 43000, 'at' => 10000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fixed' => ['label' => 'Fixed cost'],
            'formula' => ['label' => 'Cost formula'],
            'predict' => ['label' => 'Predicted cost'],
            'check' => ['label' => 'Check at the low point'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VC = ΔCost ÷ ΔUnits</li>
            <li>FC = Cost − VC × Units</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
