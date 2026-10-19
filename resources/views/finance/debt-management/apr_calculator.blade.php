<x-calc.page
    title="APR Calculator - SolveKit"
    description="Free APR calculator: annual percentage rate of a loan including fees and points, by the actuarial method of Regulation Z."
    lede="Find the APR of a loan including fees."
    about="APR is the rate at which the payments' present value equals the amount financed: the loan minus prepaid finance charges such as origination fees and points. It is higher than the note rate when there are fees (Truth in Lending Act, Regulation Z Appendix J). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'apr', 'fields' => ['amount', 'rate', 'years', 'fees', 'points']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => ''],
        ['name' => 'Enter fees and points', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the APR of $300,000 at 6.5% with $4,500 fees and 1 point?', 'answer' => '6.745%.'],
        ['question' => 'And a $10,000 personal loan at 10% for 3 years with a $500 fee?', 'answer' => '13.56%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="fees" label="Fees (origination, prepaid charges)" value="4500" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="points" label="Points" value="1" step="any" suffix="%" />
    </div>

    <x-calc.result label="APR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 300000, 'rate' => 6.5, 'years' => 30, 'fees' => 4500, 'points' => 1],
        'Personal loan' => ['amount' => 10000, 'rate' => 10, 'years' => 3, 'fees' => 500, 'points' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'payment' => ['label' => 'Monthly payment'],
            'financed' => ['label' => 'Amount financed'],
            'charge' => ['label' => 'Finance charge'],
            'gap' => ['label' => 'Above the note rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>amount − fees = PMT[1 − (1 + i)^−n] ÷ i</li>
            <li>APR = 12i</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
