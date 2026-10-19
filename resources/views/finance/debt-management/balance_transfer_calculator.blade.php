<x-calc.page
    title="Balance Transfer Calculator - SolveKit"
    description="Free balance transfer calculator: interest and fee saved by moving a card balance to a 0% promotional APR card."
    lede="See whether a balance transfer saves money."
    about="A transfer fee (usually 3–5%) is added to the new balance. During the promotion little or no interest builds up, so more of each payment cuts the balance; afterwards the regular APR applies to what is left. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'balance_transfer', 'fields' => ['balance', 'apr', 'payment', 'fee', 'promo', 'months', 'after']]"
    :how-to="[
        ['name' => 'Enter the balance, APR and payment', 'text' => ''],
        ['name' => 'Enter the offer', 'text' => 'Fee, promo APR and length.'],
    ]"
    :faqs="[
        ['question' => 'How much does moving $6,000 at 24.99% to an 18-month 0% card with a 3% fee save at $300 a month?', 'answer' => '$1,633.09.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Balance to transfer" value="6000" step="0.01" suffix="$" />
        <x-calc.field name="apr" label="Current APR" value="24.99" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Monthly payment" value="300" step="0.01" suffix="$" />
        <x-calc.field name="fee" label="Transfer fee" value="3" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="promo" label="Promotional APR" value="0" step="any" suffix="%" />
        <x-calc.field name="months" label="Promotion length" value="18" min="0" step="1" suffix="months" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="after" label="APR after the promotion" value="22.99" step="any" suffix="%" />
    </div>

    <x-calc.result label="Saved by transferring" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 6000, 'apr' => 24.99, 'payment' => 300, 'fee' => 3, 'promo' => 0, 'months' => 18, 'after' => 22.99],
        'Short promo' => ['balance' => 6000, 'apr' => 24.99, 'payment' => 200, 'fee' => 5, 'promo' => 0, 'months' => 6, 'after' => 26.99],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fee' => ['label' => 'Transfer fee'],
            'stay' => ['label' => 'If you stay'],
            'move' => ['label' => 'If you transfer'],
            'left' => ['label' => 'Left when the promo ends'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>new balance = B × (1 + fee)</li>
            <li>interest at promo APR, then regular APR</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
