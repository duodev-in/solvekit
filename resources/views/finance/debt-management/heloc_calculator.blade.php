<x-calc.page
    title="HELOC Calculator - SolveKit"
    description="Free HELOC calculator: interest-only payment during the draw period, the repayment payment afterwards and the credit line available from your equity."
    lede="Estimate HELOC payments and your credit line."
    about="A home equity line of credit usually has a 10-year draw period with interest-only payments, then a 15–20-year repayment period. Lenders typically lend up to 80–90% combined loan-to-value. HELOC rates are variable (prime + margin); this assumes the rate stays the same. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'heloc', 'fields' => ['amount', 'rate', 'draw', 'repay', 'value', 'owed', 'cltv']]"
    :how-to="[
        ['name' => 'Enter the amount drawn and rate', 'text' => ''],
        ['name' => 'Enter periods and home equity', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the payments on a $50,000 HELOC at 8.5%?', 'answer' => '$354.17 during the draw, then $433.91.'],
        ['question' => 'How big a line can a $450,000 home with $250,000 owed get at 85%?', 'answer' => '$132,500 at 85% combined LTV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount drawn" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="8.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="draw" label="Draw period" value="10" min="0" step="any" suffix="years" />
        <x-calc.field name="repay" label="Repayment period" value="20" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Home value" value="450000" step="0.01" suffix="$" />
        <x-calc.field name="owed" label="Mortgage owed" value="250000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cltv" label="Maximum combined LTV" value="85" step="any" suffix="%" />
    </div>

    <x-calc.result label="Interest-only payment during the draw" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 50000, 'rate' => 8.5, 'draw' => 10, 'repay' => 20, 'value' => 450000, 'owed' => 250000, 'cltv' => 85],
        'Small draw' => ['amount' => 20000, 'rate' => 9, 'draw' => 10, 'repay' => 15, 'value' => 300000, 'owed' => 180000, 'cltv' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'repay' => ['label' => 'Repayment payment'],
            'jump' => ['label' => 'Payment change'],
            'interest' => ['label' => 'Total interest'],
            'line' => ['label' => 'Credit line available'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>draw: B × r ÷ 12</li>
            <li>repay: B r ÷ [1 − (1 + r)^−n]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
