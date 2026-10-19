<x-calc.page
    title="Loan Comparison Calculator - SolveKit"
    description="Free loan comparison calculator: compare loans by monthly payment, total interest, fees and APR."
    lede="Compare loans side by side."
    about="Comparing APR, which includes fees, is fairer than comparing interest rates. A longer term lowers the payment but usually costs more in total. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'comparison', 'fields' => ['loans']]"
    :how-to="[
        ['name' => 'Add each loan', 'text' => ''],
        ['name' => 'Compare', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Which of three $20,000 offers costs least?', 'answer' => 'Credit union: $3,391.37.'],
    ]"
>
    <x-calc.rows-editor name="loans" label="Loans" :columns="['name' => 'Loan', 'amount' => 'Amount', 'rate' => 'Rate %', 'years' => 'Years', 'fees' => 'Fees']" :rows="[['Bank', 20000, 8.5, 5, 0], ['Online lender', 20000, 7.5, 5, 800], ['Credit union', 20000, 7.9, 4, 0]]" :text="['name']" />

    <x-calc.result label="Lowest total cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['loans' => 'Bank	20000	8.5	5	0
Online lender	20000	7.5	5	800
Credit union	20000	7.9	4	0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cheapest' => ['label' => 'Cheapest overall'],
            'payment' => ['label' => 'Lowest payment'],
            'gap' => ['label' => 'Gap between best and worst'],
            'count' => ['label' => 'Loans compared'],
        ]" />
        <x-calc.grid heading="Comparison" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = Σ interest + fees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
