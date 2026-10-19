<x-calc.page
    title="Pag-IBIG Housing Loan Calculator - SolveKit"
    description="Free Pag-IBIG housing loan calculator: monthly amortization by repricing period with Pag-IBIG Fund rates (indicative, editable) and the 35% income guideline."
    lede="Estimate a Pag-IBIG housing loan amortization."
    about="Pag-IBIG fixes the rate for the repricing period you choose (1 to 30 years), then reprices. The preset rates are Pag-IBIG's published regular rates (indicative; check pagibigfund.gov.ph). In 2026 a promo offers 4.5% for loans up to ₱2.5 million and 5.75% up to ₱10 million, fixed for 3 years, until December 31, 2026. Enter your own rate to override. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'pagibig', 'fields' => ['amount', 'period', 'rate', 'years', 'income'], 'data' => ['pagibig' => config('finance_data.pagibig')], 'sym' => 'PHP', 'currency' => 'PHP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => ''],
        ['name' => 'Choose the repricing period', 'text' => 'Or enter the rate offered.'],
    ]"
    :faqs="[
        ['question' => 'What is the amortization on ₱2 million over 30 years with 3-year repricing?', 'answer' => '₱12,314.34.'],
        ['question' => 'And at the 2026 promo rate of 4.5%?', 'answer' => '₱10,133.71.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="2000000" step="0.01" suffix="₱" />
        <x-calc.select name="period" label="Repricing period" :options="['1' => '1 year', '3' => '3 years', '5' => '5 years', '10' => '10 years', '15' => '15 years', '20' => '20 years', '25' => '25 years', '30' => '30 years']" selected="3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Your rate (optional)" value="" step="any" suffix="%" />
        <x-calc.field name="years" label="Loan term" value="30" min="0" step="1" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Gross monthly income (optional)" value="60000" step="0.01" suffix="₱" />
    </div>

    <x-calc.result label="Monthly amortization" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 2000000, 'period' => '3', 'rate' => '', 'years' => 30, 'income' => 60000],
        'Promo' => ['amount' => 2000000, 'period' => '3', 'rate' => 4.5, 'years' => 30, 'income' => 60000],
        '10-year fixed' => ['amount' => 3500000, 'period' => '10', 'rate' => '', 'years' => 25, 'income' => 90000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rate' => ['label' => 'Rate used'],
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
            'income' => ['label' => 'Income check'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = L r ÷ [1 − (1 + r)^−n]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
