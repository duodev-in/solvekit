<x-calc.page
    title="PayPal Fee Calculator - SolveKit"
    description="Free PayPal fee calculator: what you receive after PayPal's US fees (3.49% + $0.49 for Checkout, 2.99% + $0.49 for goods and services), and how much to ask to cover them."
    lede="Work out PayPal fees."
    about="PayPal charges a percentage plus a fixed fee per transaction; international buyers add 1.5%. To receive an exact amount, ask for (amount + fixed fee) ÷ (1 − rate). Rates are PayPal's published US rates in 2026 and can change; check your account's fee page. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'paypal', 'fields' => ['mode', 'amount', 'kind', 'international'], 'data' => ['fees' => config('finance_data.fees')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the payment type', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the fee on a $100 PayPal Checkout payment?', 'answer' => '$3.98; you receive $96.02.'],
        ['question' => 'What should you invoice to receive $100?', 'answer' => '$104.12.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['receive' => 'What I receive', 'grossup' => 'What to ask for']" selected="receive" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.select name="kind" label="Payment type" :options="['checkout' => 'PayPal Checkout (3.49% + $0.49)', 'goods' => 'Goods and services (2.99% + $0.49)', 'card' => 'Card processing (2.99% + $0.49)', 'invoicing' => 'Invoicing (3.49% + $0.49)']" selected="checkout" />
    </div>

    <x-calc.checkbox name="international" label="International buyer (+1.5%)" :checked="false" />

    <x-calc.result label="You receive" />

    <x-calc.options :decimals="false" :examples="[
        'Checkout' => ['mode' => 'receive', 'amount' => 100, 'kind' => 'checkout', 'international' => false],
        'Gross up' => ['mode' => 'grossup', 'amount' => 100, 'kind' => 'invoicing', 'international' => false],
        'International' => ['mode' => 'receive', 'amount' => 250, 'kind' => 'goods', 'international' => true],
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
            <li>fee = amount × rate + fixed</li>
            <li>ask = (amount + fixed) ÷ (1 − rate)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
