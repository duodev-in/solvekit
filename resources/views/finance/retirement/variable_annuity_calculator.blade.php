<x-calc.page
    title="Variable Annuity Calculator - SolveKit"
    description="Free variable annuity calculator: growth after mortality and expense (M&E) charges, fund fees and rider fees, compared with the same return without fees."
    lede="See what variable annuity fees do to growth."
    about="Variable annuities charge a mortality and expense fee (often about 1.25%), sub-account fund fees and optional rider fees (living or death benefit guarantees), all taken yearly. The value grows at (1 + return)(1 − fees) each year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'variable_annuity', 'fields' => ['deposit', 'rate', 'me', 'fund', 'rider', 'years']]"
    :how-to="[
        ['name' => 'Enter deposit and return', 'text' => ''],
        ['name' => 'Enter the fees', 'text' => 'From the prospectus.'],
    ]"
    :faqs="[
        ['question' => 'What do $100,000 become in 20 years at 7% with 3% of total fees?', 'answer' => '$210,431.25; fees cost $176,537.19.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="deposit" label="Deposit" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Return before fees" value="7" step="any" suffix="%" />
        <x-calc.field name="me" label="M&E charge" value="1.25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fund" label="Fund fees" value="0.75" step="any" suffix="%" />
        <x-calc.field name="rider" label="Rider fees" value="1" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="20" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Value after fees" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['deposit' => 100000, 'rate' => 7, 'me' => 1.25, 'fund' => 0.75, 'rider' => 1, 'years' => 20],
        'No rider' => ['deposit' => 100000, 'rate' => 7, 'me' => 1.25, 'fund' => 0.75, 'rider' => 0, 'years' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gross' => ['label' => 'Without fees'],
            'fees' => ['label' => 'Cost of fees'],
            'share' => ['label' => 'Share lost'],
            'net' => ['label' => 'Net return'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = D[(1 + r)(1 − fees)]^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
