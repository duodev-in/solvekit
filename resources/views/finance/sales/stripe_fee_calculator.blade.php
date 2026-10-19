<x-calc.page
    title="Stripe Fee Calculator - SolveKit"
    description="Free Stripe fee calculator: net payout after Stripe's US card fees (2.9% + 30¢ online) and the price to charge to receive an exact amount."
    lede="Work out Stripe fees."
    about="Stripe's standard US pricing is 2.9% + 30¢ for online cards, 3.4% + 30¢ for manually entered cards and 2.7% + 5¢ in person, with 1.5% more for international cards. Gross-up: charge (amount + fixed) ÷ (1 − rate). Volume and custom pricing differ. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'stripe', 'fields' => ['mode', 'amount', 'kind', 'international'], 'data' => ['fees' => config('finance_data.fees')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the payment type', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does Stripe take from a $100 online payment?', 'answer' => '$3.20.'],
        ['question' => 'What should you charge to receive $100?', 'answer' => '$103.30.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['receive' => 'What I receive', 'grossup' => 'What to charge']" selected="receive" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.select name="kind" label="Payment type" :options="['card' => 'Online card (2.9% + 30¢)', 'manual' => 'Manually entered (3.4% + 30¢)', 'in_person' => 'In person (2.7% + 5¢)']" selected="card" />
    </div>

    <x-calc.checkbox name="international" label="International card (+1.5%)" :checked="false" />

    <x-calc.result label="You receive" />

    <x-calc.options :decimals="false" :examples="[
        'Online' => ['mode' => 'receive', 'amount' => 100, 'kind' => 'card', 'international' => false],
        'Gross up' => ['mode' => 'grossup', 'amount' => 100, 'kind' => 'card', 'international' => false],
        'Small payment' => ['mode' => 'receive', 'amount' => 5, 'kind' => 'card', 'international' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fee' => ['label' => 'Fee'],
            'effective' => ['label' => 'Effective rate'],
            'grossup' => ['label' => 'To receive the full amount'],
            'net' => ['label' => 'Net'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fee = amount × 2.9% + $0.30</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
