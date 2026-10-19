<x-calc.page
    title="Payday Loan Calculator - SolveKit"
    description="Free payday loan calculator: APR of a payday loan fee, cost per $100 and the cost of rolling the loan over."
    lede="See the true cost of a payday loan."
    about="A typical fee of $15 per $100 for two weeks is an APR of about 391%: APR = fee ÷ amount × 365 ÷ days. Rolling over adds the fee again each time. Many states cap or ban payday loans. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'payday', 'fields' => ['amount', 'fee', 'days', 'rollovers']]"
    :how-to="[
        ['name' => 'Enter the amount and fee', 'text' => ''],
        ['name' => 'Enter the term and rollovers', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What APR is a $60 fee on $400 for 14 days?', 'answer' => '391.07%.'],
        ['question' => 'What do 3 rollovers cost?', 'answer' => '$240.00 in fees after 3 rollovers.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount borrowed" value="400" step="0.01" suffix="$" />
        <x-calc.field name="fee" label="Fee" value="60" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="days" label="Term" value="14" min="1" step="1" suffix="days" />
        <x-calc.field name="rollovers" label="Rollovers" value="0" min="0" step="1" />
    </div>

    <x-calc.result label="APR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 400, 'fee' => 60, 'days' => 14, 'rollovers' => 0],
        'Rolled over' => ['amount' => 400, 'fee' => 60, 'days' => 14, 'rollovers' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per100' => ['label' => 'Fee per $100'],
            'rollover' => ['label' => 'Fees with rollovers'],
            'effective' => ['label' => 'Effective annual rate'],
            'card' => ['label' => 'Interest on a card at 24% for the same time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>APR = fee ÷ amount × 365 ÷ days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
