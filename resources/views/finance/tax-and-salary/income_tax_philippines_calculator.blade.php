<x-calc.page
    title="Income Tax Philippines Calculator - SolveKit"
    description="Free Philippines income tax calculator: withholding tax on compensation under the TRAIN law (2023 rates) after SSS, PhilHealth and Pag-IBIG contributions."
    lede="Work out Philippine income tax on your salary."
    about="From 2023 compensation income is taxed at 0% up to ₱250,000 a year, 15% to ₱400,000, 20% to ₱800,000, 25% to ₱2 million, 30% to ₱8 million and 35% above. Employee SSS (5%), PhilHealth (2.5%) and Pag-IBIG (2%, up to ₱200) contributions are deducted first. The 13th-month pay and bonuses are tax-free up to ₱90,000. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'philippines', 'fields' => ['salary', 'other', 'bonus'], 'data' => ['philippines' => config('finance_data.philippines')], 'sym' => 'PHP', 'currency' => 'PHP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your salary', 'text' => ''],
        ['name' => 'Add allowances and bonuses', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the tax on ₱45,000 a month?', 'answer' => '₱3,593.33 a month.'],
        ['question' => 'And on ₱25,000?', 'answer' => '₱313.75.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="salary" label="Monthly basic salary" value="45000" step="0.01" suffix="₱" />
        <x-calc.field name="other" label="Other taxable allowances a month" value="0" step="0.01" suffix="₱" />
        <x-calc.field name="bonus" label="13th month and bonuses a year" value="45000" step="0.01" suffix="₱" />
    </div>

    <x-calc.result label="Withholding tax a month" />

    <x-calc.options :decimals="false" :examples="[
        '₱45k' => ['salary' => 45000, 'other' => 0, 'bonus' => 45000],
        '₱25k' => ['salary' => 25000, 'other' => 0, 'bonus' => 25000],
        '₱150k' => ['salary' => 150000, 'other' => 10000, 'bonus' => 200000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'contributions' => ['label' => 'Contributions'],
            'net' => ['label' => 'Net pay a month'],
            'marginal' => ['label' => 'Marginal rate'],
            'bonus' => ['label' => '13th month'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>taxable = (salary − contributions) × 12 + bonus over ₱90,000</li>
            <li>tax = TRAIN schedule</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
