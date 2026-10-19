<x-calc.page
    title="Loan Balance Calculator - SolveKit"
    description="Free loan balance calculator: remaining balance after a number of payments, with principal and interest paid so far."
    lede="Find what you still owe on a loan."
    about="Balance after k payments = P(1 + r)^k − PMT × [(1 + r)^k − 1] ÷ r. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'balance', 'fields' => ['amount', 'rate', 'years', 'paid']]"
    :how-to="[
        ['name' => 'Enter the original loan', 'text' => ''],
        ['name' => 'Enter payments made', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is left on $250,000 at 6% after 5 years?', 'answer' => '$232,635.89.'],
        ['question' => 'How much interest has been paid?', 'answer' => '$72,568.47.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Original loan" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="paid" label="Payments made" value="60" min="0" step="1" />
    </div>

    <x-calc.result label="Balance remaining" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 250000, 'rate' => 6, 'years' => 30, 'paid' => 60],
        'Car loan' => ['amount' => 30000, 'rate' => 7, 'years' => 5, 'paid' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'principal' => ['label' => 'Principal repaid'],
            'interest' => ['label' => 'Interest paid'],
            'remaining' => ['label' => 'Still to pay'],
            'share' => ['label' => 'Share repaid'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>B = P(1 + r)^k − PMT[(1 + r)^k − 1] ÷ r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
