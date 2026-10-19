<x-calc.page
    title="Finance Charge Calculator - SolveKit"
    description="Free finance charge calculator: total interest and fees on a loan or installment plan, with the APR."
    lede="Find the total cost of credit."
    about="Under the Truth in Lending Act the finance charge is the dollar cost of credit: interest plus most fees. Credit cards compute it each month as balance × APR ÷ 12. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'finance_charge', 'fields' => ['amount', 'rate', 'months', 'fees']]"
    :how-to="[
        ['name' => 'Enter the amount, rate and term', 'text' => ''],
        ['name' => 'Add fees', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the finance charge on $12,000 at 9.5% for 48 months with $250 of fees?', 'answer' => '$2,720.93.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount financed" value="12000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="9.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="months" label="Term" value="48" min="0" step="1" suffix="months" />
        <x-calc.field name="fees" label="Fees" value="250" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Finance charge" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 12000, 'rate' => 9.5, 'months' => 48, 'fees' => 250],
        'Furniture plan' => ['amount' => 3000, 'rate' => 19.9, 'months' => 24, 'fees' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'interest' => ['label' => 'Interest'],
            'fees' => ['label' => 'Fees'],
            'payment' => ['label' => 'Monthly payment'],
            'apr' => ['label' => 'APR'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>finance charge = PMT × n − amount + fees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
