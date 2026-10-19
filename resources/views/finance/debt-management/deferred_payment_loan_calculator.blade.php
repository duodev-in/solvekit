<x-calc.page
    title="Deferred Payment Loan Calculator - SolveKit"
    description="Free deferred payment loan calculator: interest that builds up during a deferral, the capitalized balance and the payment afterwards."
    lede="See what deferring loan payments costs."
    about="During deferral interest keeps accruing (unless the loan is subsidized). At the end it is capitalized: added to the principal, so you then pay interest on it. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'deferred', 'fields' => ['amount', 'rate', 'defer', 'years', 'compound', 'subsidized']]"
    :how-to="[
        ['name' => 'Enter the loan and deferral', 'text' => ''],
        ['name' => 'Enter the repayment term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a 2-year deferral add to $25,000 at 6.5%?', 'answer' => '$3,250.00 of interest; the payment becomes $320.77.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="defer" label="Deferral" value="24" min="0" step="1" suffix="months" />
        <x-calc.field name="years" label="Repayment term" value="10" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="compound" label="Interest during deferral" :options="['simple' => 'Simple (federal student loans)', 'monthly' => 'Compounded monthly']" selected="simple" />
    </div>

    <x-calc.checkbox name="subsidized" label="Subsidized (no interest during deferral)" :checked="false" />

    <x-calc.result label="Monthly payment after deferral" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 25000, 'rate' => 6.5, 'defer' => 24, 'years' => 10, 'compound' => 'simple', 'subsidized' => false],
        'Subsidized' => ['amount' => 25000, 'rate' => 6.5, 'defer' => 24, 'years' => 10, 'compound' => 'simple', 'subsidized' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'accrued' => ['label' => 'Interest accrued'],
            'balance' => ['label' => 'Balance after deferral'],
            'interest' => ['label' => 'Total interest'],
            'extra' => ['label' => 'Cost of deferring'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>accrued = P × r × months ÷ 12</li>
            <li>balance = P + accrued</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
