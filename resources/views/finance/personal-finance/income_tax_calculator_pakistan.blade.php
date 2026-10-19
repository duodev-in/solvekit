<x-calc.page
    title="Income Tax Calculator Pakistan - SolveKit"
    description="Free Pakistan income tax calculator for salaried individuals: tax year 2027 slabs from the Finance Act 2026, monthly and yearly tax and take-home pay."
    lede="Work out income tax on your salary in Pakistan."
    about="For tax year 2027 (July 2026 to June 2027) salaried income up to Rs 600,000 is tax-free; then 1%, 11%, 20%, 25%, 29%, 32% and 35% above Rs 7 million, as set by the Finance Act 2026. The 9–10% surcharge on salaried income was abolished. Applies when salary is more than 75% of taxable income. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'pakistan', 'fields' => ['salary', 'period'], 'data' => ['pakistan' => config('finance_data.pakistan')], 'sym' => 'PKR', 'currency' => 'PKR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your salary', 'text' => ''],
        ['name' => 'Choose monthly or yearly', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the tax on Rs 150,000 a month?', 'answer' => 'Rs 6,000 a month.'],
        ['question' => 'And on Rs 500,000 a month?', 'answer' => 'Rs 92,000.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="salary" label="Salary" value="150000" step="0.01" suffix="Rs " />
        <x-calc.select name="period" label="Entered as" :options="['month' => 'Monthly', 'year' => 'Yearly']" selected="month" />
    </div>

    <x-calc.result label="Income tax a month" />

    <x-calc.options :decimals="false" :examples="[
        'Rs 150k' => ['salary' => 150000, 'period' => 'month'],
        'Rs 500k' => ['salary' => 500000, 'period' => 'month'],
        'Rs 1.2 million a year' => ['salary' => 1200000, 'period' => 'year'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'yearly' => ['label' => 'Tax a year'],
            'net' => ['label' => 'Take-home a month'],
            'effective' => ['label' => 'Effective rate'],
            'marginal' => ['label' => 'Marginal rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tax = fixed amount + rate × income over the slab start</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
