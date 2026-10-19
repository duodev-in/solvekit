<x-calc.page
    title="Deferred Annuity Calculator - SolveKit"
    description="Free deferred annuity calculator: growth of a deposit and yearly premiums during the deferral period, then the monthly payout over a number of years."
    lede="See what a deferred annuity pays out."
    about="During deferral the value grows at the credited rate with premiums at the start of each year. At payout the value is converted into level monthly payments for a set number of years (period certain) at the payout rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'deferred_annuity', 'fields' => ['deposit', 'yearly', 'rate', 'defer', 'years', 'payout_rate']]"
    :how-to="[
        ['name' => 'Enter premiums and growth', 'text' => ''],
        ['name' => 'Enter deferral and payout years', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does $100,000 deferred 10 years at 5% pay monthly for 20 years at 4%?', 'answer' => '$987.08.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="deposit" label="Initial premium" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="yearly" label="Yearly premium" value="0" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Growth rate" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="defer" label="Deferral" value="10" min="0" step="1" suffix="years" />
        <x-calc.field name="years" label="Payout years" value="20" min="0" step="1" suffix="years" />
        <x-calc.field name="payout_rate" label="Payout rate (optional)" value="4" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly payout" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['deposit' => 100000, 'yearly' => 0, 'rate' => 5, 'defer' => 10, 'years' => 20, 'payout_rate' => 4],
        'With premiums' => ['deposit' => 20000, 'yearly' => 10000, 'rate' => 4.5, 'defer' => 15, 'years' => 15, 'payout_rate' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'value' => ['label' => 'Value at payout'],
            'paidin' => ['label' => 'Premiums paid'],
            'total' => ['label' => 'Total payouts'],
            'ratio' => ['label' => 'Payout multiple'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = P(1 + r)^d + premiums</li>
            <li>PMT = V i ÷ [1 − (1 + i)^−n]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
