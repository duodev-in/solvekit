<x-calc.page
    title="Texas Tax Calculator - SolveKit"
    description="Free Texas tax calculator: Texas has no state income tax; see what you pay instead in sales and property tax, and the income tax you avoid compared with another state."
    lede="See Texas taxes on your income, spending and home."
    about="Texas levies no personal income tax. It relies on a 6.25% state sales tax plus up to 2% local (1.95% on average) and on local property taxes, among the highest in the US (often 1.5–2.5% of value a year). Enter your own property tax rate from your appraisal district. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'no_income_tax', 'fields' => ['income', 'spending', 'local', 'home_value', 'property_rate', 'compare', 'status'], 'data' => ['states' => config('finance_data.states'), 'sales' => config('finance_data.sales')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter income and spending', 'text' => ''],
        ['name' => 'Enter your home value and rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much income tax does a $90,000 earner avoid in Texas compared with California?', 'answer' => '$4,140.42 of California income tax on the same income.'],
        ['question' => 'What do sales and property taxes add up to?', 'answer' => '$8,775.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Income" value="90000" step="0.01" suffix="$" />
        <x-calc.field name="spending" label="Taxable spending a year" value="30000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="local" label="Local sales tax rate" value="2" step="any" suffix="%" />
        <x-calc.field name="home_value" label="Home value" value="350000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="property_rate" label="Property tax rate" value="1.8" step="any" suffix="%" />
        <x-calc.select name="compare" label="Compare with" :options="['AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming']" selected="CA" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly']" selected="single" />
    </div>

    <x-calc.result label="Texas state income tax" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['income' => 90000, 'spending' => 30000, 'local' => 2, 'home_value' => 350000, 'property_rate' => 1.8, 'compare' => 'CA', 'status' => 'single'],
        'Renter' => ['income' => 60000, 'spending' => 25000, 'local' => 2, 'home_value' => 0, 'property_rate' => 0, 'compare' => 'NY', 'status' => 'single'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sales' => ['label' => 'Sales tax'],
            'property' => ['label' => 'Property tax'],
            'total' => ['label' => 'Sales and property tax'],
            'compare' => ['label' => 'Income tax avoided'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>income tax = 0</li>
            <li>sales = spending × 8.25%</li>
            <li>property = value × rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
