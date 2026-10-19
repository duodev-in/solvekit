<x-calc.page
    title="Lottery Annuity Calculator - SolveKit"
    description="Free Lottery Annuity Calculator: the after-tax cash option and the 30-payment annuity (rising 5% a year) for a lottery jackpot, with 2026 federal and your state tax."
    lede="See what a lottery jackpot pays after tax."
    about="US multistate jackpots pay as 30 annual payments, each 5% larger than the last, or a smaller cash option (about 45–50% of the jackpot, depending on interest rates). The first payment = jackpot × 0.05 ÷ (1.05³⁰ − 1). Federal tax uses 2026 brackets on each payment; state tax uses the rate you enter (0% in California, Florida, Texas and other states for lottery prizes). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'lottery_annuity', 'fields' => ['jackpot', 'cash', 'cash_pct', 'state_rate', 'income', 'status', 'rate'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the jackpot', 'text' => 'And the cash value if announced.'],
        ['name' => 'Enter your state rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a $500 million lottery jackpot pay after tax as cash?', 'answer' => '$132,237,500.'],
        ['question' => 'And as the annuity?', 'answer' => '$295,249,992 over 30 years; first payment $7,525,718 rising 5% a year to $30,976,874.'],
        ['question' => 'Which is better?', 'answer' => 'The annuity is worth more at your investment return.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="jackpot" label="Advertised jackpot (annuity)" value="500000000" step="0.01" suffix="$" />
        <x-calc.field name="cash" label="Cash option (if known)" value="" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash_pct" label="Or cash as a share of the jackpot" value="45" step="any" suffix="%" />
        <x-calc.field name="state_rate" label="State tax rate" value="4.25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Other taxable income" value="0" step="0.01" suffix="$" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly']" selected="single" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Your investment return (to compare)" value="5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Cash option after tax" />

    <x-calc.options :decimals="false" :examples="[
        '$500 million' => ['jackpot' => 500000000, 'cash' => '', 'cash_pct' => 45, 'state_rate' => 4.25, 'income' => 0, 'status' => 'single', 'rate' => 5],
        '$1 billion, no state tax' => ['jackpot' => 1000000000, 'cash' => '', 'cash_pct' => 45, 'state_rate' => 0, 'income' => 0, 'status' => 'single', 'rate' => 5],
        '$100 million' => ['jackpot' => 100000000, 'cash' => '', 'cash_pct' => 48, 'state_rate' => 5, 'income' => 60000, 'status' => 'mfj', 'rate' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'first' => ['label' => 'Annuity payments'],
            'annuity' => ['label' => 'Annuity after tax'],
            'pv' => ['label' => 'Annuity value today'],
            'better' => ['label' => 'Which is worth more'],
            'withheld' => ['label' => 'Withheld at payout (24%)'],
        ]" />
        <x-calc.grid heading="Annuity payments" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>annuity: 30 payments, first = J × 0.05 ÷ (1.05³⁰ − 1)</li>
            <li>tax = federal brackets + state rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
