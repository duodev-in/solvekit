<x-calc.page
    title="Mortgage Comparison Calculator - SolveKit"
    description="Free mortgage comparison calculator: compare two or more mortgage offers by payment, total interest, fees and APR."
    lede="Compare mortgage offers side by side."
    about="For each loan the payment, interest over the full term and APR including fees are shown. The lowest total cost depends on how long you keep the loan; compare offers on the same loan amount. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'comparison', 'fields' => ['loans']]"
    :how-to="[
        ['name' => 'Add each offer', 'text' => 'Amount, rate, years and fees.'],
        ['name' => 'Compare', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Which is cheaper: 30 years at 6.5% or 15 years at 5.75% on $320,000?', 'answer' => '15-year fixed: $162,316.21; lowest payment 30-year with points: $1,944.35 a month.'],
    ]"
>
    <x-calc.rows-editor name="loans" label="Loans" :columns="['name' => 'Loan', 'amount' => 'Amount', 'rate' => 'Rate %', 'years' => 'Years', 'fees' => 'Fees']" :rows="[['30-year fixed', 320000, 6.5, 30, 4000], ['15-year fixed', 320000, 5.75, 15, 4000], ['30-year with points', 320000, 6.125, 30, 7200]]" :text="['name']" />

    <x-calc.result label="Lowest total cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['loans' => '30-year fixed	320000	6.5	30	4000
15-year fixed	320000	5.75	15	4000
30-year with points	320000	6.125	30	7200'],
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
            <li>APR includes fees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
