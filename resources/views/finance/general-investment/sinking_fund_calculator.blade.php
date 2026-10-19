<x-calc.page
    title="Sinking Fund Calculator - SolveKit"
    description="Free Sinking Fund Calculator: payment = FV × r ÷ [(1 + r)^n − 1]. A sinking fund sets aside equal payments that grow to a sum needed later, such as replacing equipment or repaying a bond."
    lede="Work out the payment each period from your figures."
    about="A sinking fund sets aside equal payments that grow to a sum needed later, such as replacing equipment or repaying a bond. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'sinking_fund', 'fields' => ['goal', 'rate', 'years', 'per']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Amount needed, Annual return, Years, Payments a year.'],
        ['name' => 'Read the result', 'text' => 'The payment each period appears as you type, with total paid in below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the payment each period?', 'answer' => 'Payment = FV × r ÷ [(1 + r)^n − 1].'],
        ['question' => 'What is the payment each period for amount needed $50,000, annual return 4%, years 5, payments a year 12?', 'answer' => '$754.16. Total paid in: $45,249.57.'],
        ['question' => 'And for amount needed $12,000, annual return 3%, years 2, payments a year 12?', 'answer' => '$485.77. Total paid in: $11,658.59.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Starting earlier lowers each payment.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="goal" label="Amount needed" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual return" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="5" min="0" step="any" suffix="years" />
        <x-calc.field name="per" label="Payments a year" value="12" min="0" step="1" />
    </div>

    <x-calc.result label="Payment each period" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['goal' => 50000, 'rate' => 4, 'years' => 5, 'per' => 12],
        'Example B' => ['goal' => 12000, 'rate' => 3, 'years' => 2, 'per' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total paid in'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>payment = FV × r ÷ [(1 + r)^n − 1]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
